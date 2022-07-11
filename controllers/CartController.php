<?php

class CartController extends BaseController
{

    public function __construct()
    {
        $this->loadModel('ProductModel');
        $this->loadModel('CategoryModel');
        $this->productModel = new ProductModel;
        $this->CategoryModel = new CategoryModel;
    }

    public function index()
    {
        $categories = $this->CategoryModel->getAll();
        $products = $this->productModel->getAllEnoughQuantity();
        $productsSlide = $this->productModel->getAllEnoughQuantity();
        return $this->view('fontend.carts.index', [
            "products" => $products,
            "categories" => $categories,
            "productsSlide" => $productsSlide
        ]);
    }

    public function goback()
    {
        if (isset($_SERVER["HTTP_REFERER"])) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        } else {
            header("Location: ./index.php");
        }
    }

    public function destroy()
    {
        if ($_GET['id']) {
            $id = $_GET['id'];
            if (isset($_SESSION["cart"])) {
                if (!array_key_exists($id, $_SESSION["cart"])) {
                    if (isset($_SERVER["HTTP_REFERER"])) {
                        header("Location: " . $_SERVER["HTTP_REFERER"]);
                    } else {
                        header("Location: ./index.php");
                    }
                }
                unset($_SESSION["cart"][$id]);
                $this->goback();
            } else {
                $this->goback();
            }
        } else {
            $this->goback();
        }
    }

    public function delete()
    {
        if ($_GET['id']) {
            $id = $_GET['id'];
            if (isset($_SESSION["cart"])) {
                if (!array_key_exists($id, $_SESSION["cart"])) {
                    if (isset($_SERVER["HTTP_REFERER"])) {
                        header("Location: " . $_SERVER["HTTP_REFERER"]);
                    } else {
                        header("Location: ./index.php");
                    }
                }

                $quantity = $_SESSION["cart"][$id]['quantity'] - 1;
                if ($quantity <= 0) {
                    if (!array_key_exists($id, $_SESSION["cart"])) {
                        $this->goback();
                    }
                    unset($_SESSION["cart"][$id]);
                    $this->goback();
                } else {
                    if (!array_key_exists($id, $_SESSION["cart"])) {
                        $this->goback();
                    }
                    $_SESSION["cart"][$id]['quantity'] = $quantity;
                    $this->goback();
                }
            } else {
                $this->goback();
            }
        } else {
            $this->goback();
        }
    }


    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['data']['id']) {
                $product = $this->productModel->getById($_POST['data']['id']);
                $product = $product['data'];
                if ($product && count($product) > 0) {
                    $product = $product[0];
                    $number = $_POST['data']['count'];
                    if ($product['quantity'] < $number) {
                        echo ($this->formatRespon("Đã hết hàng", count($_SESSION["cart"]) ?? 0));
                        return;
                    }
                    if (isset($_SESSION["cart"])) {
                        if (!array_key_exists($product['id'], $_SESSION["cart"])) {
                            $product['quantity'] = $number;
                            $_SESSION["cart"][$product['id']] = $product;
                            echo ($this->formatRespon("Thêm sản phẩm thành công", count($_SESSION["cart"])));
                            return;
                        } else {
                            $product['quantity'] = $_SESSION["cart"][$product['id']]['quantity'] + $number;
                            $_SESSION["cart"][$product['id']] =  $product;
                            echo ($this->formatRespon("Thêm sản phẩm thành công", count($_SESSION["cart"])));
                            return;
                        }
                    } else {
                        $product['quantity'] = $number;
                        $_SESSION["cart"][$product['id']] = $product;
                        echo ($this->formatRespon("Thêm sản phẩm thành công", count($_SESSION["cart"])));
                        return;
                    }
                } else {
                    echo ($this->formatRespon("Thêm sản phẩm thất bại", count($_SESSION["cart"]) ?? 0));
                    return;
                }
            } else {
                echo ($this->formatRespon("Thêm sản phẩm thất bại", count($_SESSION["cart"]) ?? 0));
                return;
            }
        } else {
            if ($_GET['id']) {
                $product = $this->productModel->getById($_GET['id']);
                $product = $product['data'];
                if ($product && count($product) > 0) {
                    $product = $product[0];
                    $number = 1;
                    if ($product['quantity'] < $number) {
                        $this->goback();
                    }
                    if (isset($_SESSION["cart"])) {
                        if (!array_key_exists($product['id'], $_SESSION["cart"])) {
                            $product['quantity'] = $number;
                            $_SESSION["cart"][$product['id']] = $product;
                            $this->goback();
                        } else {
                            $product['quantity'] = $_SESSION["cart"][$product['id']]['quantity'] + $number;
                            $_SESSION["cart"][$product['id']] =  $product;
                            $this->goback();
                        }
                    } else {
                        $product['quantity'] = $number;
                        $_SESSION["cart"][$product['id']] = $product;
                        $this->goback();
                    }
                } else {
                    $this->goback();
                }
            } else {
                $this->goback();
            }
        }
    }
}
