<?php

class DiscountController extends BaseController
{
    public function __construct()
    {
        $this->loadModel('DiscountModel');
        $this->discountModel = new DiscountModel;
    }

    public function index()
    {
        $products = $this->productModel->getProductsold();
        $total = $this->orderModel->getTotal();
        return $this->view('fontend.admin.home.index', [
            "products" => $products,
            "total" => $total
        ]);
    }

    public function store(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                //code...

                $id = isset($_POST['id']) ? $_POST['id'] : "";
                $value = isset($_POST['value']) ? $_POST['value'] : "";
                $count = isset($_POST['count']) ? $_POST['count'] : "";
                if (!$id || !$value || !$count) {
                    return header("Location: admin.php");
                }

                $data = [
                    'id' => $id,
                    'value' => $value,
                    'count' => $count
                ];

                $this->discountModel->store($data);
                if ($_SERVER["HTTP_REFERER"])
                header("Location: " . $_SERVER["HTTP_REFERER"]);
                header("Location: ./admin.php");
            } catch (\Throwable $th) {
                if ($_SERVER["HTTP_REFERER"])
                header("Location: " . $_SERVER["HTTP_REFERER"]);
                header("Location: ./admin.php");
            }
        } else {
            if ($_SERVER["HTTP_REFERER"])
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            header("Location: ./admin.php");
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {

                $id = isset($_POST['id']) ? $_POST['id'] : "";
                $count = isset($_POST['count']) ? $_POST['count'] : "";
                $value = isset($_POST['newvalue']) ? $_POST['newvalue'] : "";
                if (!$id || !$value || !$count) {
                    return header("Location: admin.php");
                }

                $data = [
                    'id' => $id,
                    'value' => $value,
                    'count' => $count
                ];

                $this->discountModel->updateById($data);
                if ($_SERVER["HTTP_REFERER"])
                header("Location: " . $_SERVER["HTTP_REFERER"]);
                header("Location: ./admin.php");
            } catch (\Throwable $th) {
                if ($_SERVER["HTTP_REFERER"])
                header("Location: " . $_SERVER["HTTP_REFERER"]);
                header("Location: ./admin.php");
            }
        } else {
            if ($_SERVER["HTTP_REFERER"])
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            header("Location: ./admin.php");
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $id = isset($_POST['id']) ? $_POST['id'] : "";
               
                if (!$id) {
                    return header("Location: admin.php");
                }
                $this->discountModel->deleteById($id);
                if ($_SERVER["HTTP_REFERER"])
                header("Location: " . $_SERVER["HTTP_REFERER"]);
                header("Location: ./admin.php");
            } catch (\Throwable $th) {
                if ($_SERVER["HTTP_REFERER"])
                header("Location: " . $_SERVER["HTTP_REFERER"]);
                header("Location: ./admin.php");
            }
        } else {
            if ($_SERVER["HTTP_REFERER"])
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            header("Location: ./admin.php");
        }
    }
}
