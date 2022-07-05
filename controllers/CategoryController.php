<?php

class CategoryController extends BaseController
{

    public function __construct()
    {
        $this->loadModel('CategoryModel');
        $this->loadModel('ProductModel');
        $this->categoryModel = new CategoryModel;
        $this->productModel = new ProductModel;
    }

    public function index()
    {
        return $this->view('fontend.categories.index');
    }

    public function update()
    {
        try {
            $id = isset($_POST['categoryid']) ? $_POST['categoryid'] : '';
            $newvalue = isset($_POST['newvalue']) ? $_POST['newvalue'] : '';
            if (!$id || !$newvalue) {
                header("Location: ./admin?controller=product");
            }
            $data = [
                "name" => $newvalue,
            ];
            $this->categoryModel->updateById($id, $data);
            if ($_SERVER["HTTP_REFERER"])
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            header("Location: ./admin.php?controller=product");
        } catch (\Throwable $th) {
            if ($_SERVER["HTTP_REFERER"])
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            header("Location: ./admin.php?controller=product");
        }
    }

    public function delete()
    {
        try {
            $id = isset($_POST['categoryid']) ? $_POST['categoryid'] : '';
            if (!$id) {
                header("Location: ./admin?controller=product");
            }
            $this->productModel::$connect->begin_transaction();
            $products = $this->productModel->getByCategory($id);
            if (isset($products) && isset($products['data']) && count($products['data']) > 0) {
                foreach ($products['data'] as &$product) {
                    $this->productModel->deleteById($product['id']);
                }
            }

            $this->categoryModel->deleteById($id);
            $this->productModel::$connect->commit();
            if ($_SERVER["HTTP_REFERER"])
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            header("Location: ./admin.php?controller=product");
        } catch (\Throwable $th) {
            $this->productModel::$connect->rollback();

            if ($_SERVER["HTTP_REFERER"])
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            header("Location: ./admin.php?controller=product");
        }
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                //code...

                $name = isset($_POST['name']) ? $_POST['name'] : "";
                if (!$name) {
                    return header("Location: admin.php");
                }

                $result = $this->categoryModel->store([
                    "name" => $name,
                ]);
                if ($_SERVER["HTTP_REFERER"])
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                header("Location: ./admin.php?controller=product");
            } catch (\Throwable $th) {
                if ($_SERVER["HTTP_REFERER"])
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                header("Location: ./admin.php?controller=product");
            }
        } else {
            if ($_SERVER["HTTP_REFERER"])
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            header("Location: ./admin.php?controller=product");
        }
    }
}
