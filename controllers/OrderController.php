<?php

class OrderController extends BaseController
{
    public function __construct()
    {
        $this->loadModel('DiscountModel');
        $this->loadModel('OrderModel');
        $this->loadModel('OrderItemModel');
        $this->loadModel('ProductModel');
        $this->discountModel = new DiscountModel;
        $this->orderModel = new OrderModel;
        $this->orderItemModel = new OrderItemModel;
        $this->productModel = new ProductModel;
    }

    public function index()
    {
        $myOrders = $this->orderModel->getAllMyOrders();
        if ($myOrders == null) {
            return header("Location: index.php");
        }
        $productsSlide = $this->productModel->getAllEnoughQuantity();
        return $this->view('fontend.orders.index', [
            "orders" => $myOrders,
            "productsSlide" => $productsSlide,
        ]);
    }

    public function checkdiscountcode()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['data']['code']) {
                $code = $_POST['data']['code'];
                $discountCodes = $this->discountModel->getById($code);
                if (!$discountCodes['data'] || count($discountCodes['data']) <= 0) {
                    echo $this->formatRespon("Mã giảm giá không tồn tại hoặc đã hết hạn", 0);
                } else {
                    echo $this->formatRespon("Áp dụng mã giảm giá thành công", $discountCodes['data']);
                }
            }
        }
    }

    public function update()
    {
        try {
            $id = isset($_POST['id']) ? $_POST['id'] : '';
            $status = isset($_POST['status']) ? $_POST['status'] : '';
            if (!$id || !$status) {
                header("Location: ./admin?controller=adminOrder");
            }
            $data = [
                "status" => $status,
            ];
            $this->orderModel->updateById($id, $data);
            if ($_SERVER["HTTP_REFERER"])
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            header("Location: ./admin.php?controller=adminOrder");
        } catch (\Throwable $th) {
            if ($_SERVER["HTTP_REFERER"])
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            header("Location: ./admin.php?controller=adminOrder");
        }
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['data']) {
                try {
                    $this->orderItemModel::$connect->begin_transaction();
                    $userId = isset($_POST['data']['userId']) ? $_POST['data']['userId'] : '';
                    $discountCode = isset($_POST['data']['discountCode']) ? $_POST['data']['discountCode'] : '';
                    $price = isset($_POST['data']['price']) ? $_POST['data']['price'] : '';
                    if (!$userId) {
                        echo $this->formatRespon("đặt hàng thất bại", 0);
                        return;
                    }

                    if ($discountCode) {
                        $discountCodes = $this->discountModel->getById($discountCode);
                        if ($discountCodes['data'] && count($discountCodes['data']) > 0 && $discountCodes['data'][0]['count'] > 0) {
                            $dataOrder = [
                                "user_id" => $userId,
                                "discount_id" => $discountCode,
                                "cost" => $price,
                            ];
                            $discountCodeQuantity = $discountCodes['data'][0]['count'] - 1;
                            $result = $this->orderModel->store($dataOrder);
                            if ($result) {
                                $this->discountModel->updateById($discountCode, [
                                    "count" => $discountCodeQuantity
                                ]);
                                foreach ($_SESSION['cart'] as &$cart) {
                                    $item = $this->productModel->getById($cart['id']);
                                    if ($item['data'] && count($item['data']) > 0) {
                                        $item = $item['data'][0];
                                        if ($item['quantity'] < $cart['quantity']) {
                                            throw new Exception;
                                        }
                                        $dataOrderItem = [
                                            "order_id" => $result,
                                            "product_id" => $cart['id'],
                                            "quantity" => $cart['quantity'],
                                        ];
                                        $resultOrderItem = $this->orderItemModel->store($dataOrderItem);
                                        if ($resultOrderItem) {
                                            $newQuantity =  $item['quantity'] - $cart['quantity'];
                                            $resultUpdateProduct = $this->productModel->updateById($cart['id'], [
                                                "quantity" => $newQuantity
                                            ]);
                                            if ($resultUpdateProduct) {
                                                throw new Exception;
                                            }
                                        } else {
                                            throw new Exception;
                                        }
                                    }
                                }
                                unset($_SESSION['cart']);
                                echo $this->formatRespon("đặt hàng thành công", 1);
                                return;
                            } else {
                                throw new Exception;
                            }
                        } else {
                            echo $this->formatRespon("Mã giảm giá đã hết vui lòng thử lại", 0);
                            return;
                        }
                    } else {
                        $dataOrder = [
                            "user_id" => $userId,
                            "cost" => $price,
                        ];
                        $result = $this->orderModel->store($dataOrder);

                        if ($result) {
                            foreach ($_SESSION['cart'] as &$cart) {
                                $item = $this->productModel->getById($cart['id']);
                                if ($item['data'] && count($item['data']) > 0) {
                                    if ($item['data'][0]['quantity'] < $cart['quantity']) {
                                        echo $this->formatRespon("Sản phẩm đã hết vui lòng thử lại", 0);
                                        return  $this->orderItemModel::$connect->rollback();
                                    }
                                    $dataOrderItem = [
                                        "order_id" => $result,
                                        "product_id" => $cart['id'],
                                        "quantity" => $cart['quantity'],
                                    ];
                                    $resultOrderItem = $this->orderItemModel->store($dataOrderItem);
                                    if ($resultOrderItem) {

                                        $newQuantity =  $item['data'][0]['quantity'] - $cart['quantity'];
                                        $newSold =  $item['data'][0]['sold'] +  $cart['quantity'];
                                        $resultUpdateProduct = $this->productModel->updateById($cart['id'], [
                                            "quantity" => $newQuantity,
                                            "sold" => $newSold
                                        ]);
                                        if (!$resultUpdateProduct) {
                                            throw new Exception;
                                        }
                                    } else {
                                        throw new Exception;
                                    }
                                } else {
                                    throw new Exception;
                                }
                            }
                            $this->orderItemModel::$connect->commit();
                            unset($_SESSION['cart']);
                            echo $this->formatRespon("đặt hàng thành công", 1);
                        } else {
                            throw new Exception;
                        }
                    }
                } catch (\Throwable $th) {
                    $this->orderItemModel::$connect->rollback();
                    echo $this->formatRespon("Có lỗi xảy ra vui lòng thử lại sau", 0);
                }
            }
        }
    }
}
