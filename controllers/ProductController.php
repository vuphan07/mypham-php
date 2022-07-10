<?php

class ProductController extends BaseController
{
    private $productModel;

    public function __construct()
    {
        $this->loadModel('CategoryModel');
        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel;
        $this->CategoryModel = new CategoryModel;
    }

    public function index()
    {
        $products = $this->productModel->getAll();
        $categories = $this->CategoryModel->getAll();
        return $this->view('fontend.products.index', [
            "products" => $products,
            "categories" => $categories
        ]);
    }

    public function category()
    {
        if (isset($_GET['id'])) {
            $products = $this->productModel->getByCategory($_GET['id'] ?? '');
            $categories = $this->CategoryModel->getAll();
            return $this->view('fontend.products.category', [
                "products" => $products,
                "categories" => $categories
            ]);
        } else {
        }
    }

    public function detail()
    {
        $id = $_GET['id'];
        $product = $this->productModel->getById($id);
        $products = ["data" => []];

        if ($product['data'] && count($product['data']) > 0) {
            $products = $this->productModel->getByCategory($product['data'][0]['category_id']);
        }


        return $this->view('fontend.products.detail', [
            "product" => $product,
            "products" => $products
        ]);
    }

    public function delete()
    {
        try {
            $id = $_POST['data']['id'];
            $this->productModel->deleteById($id);
            echo "true";
        } catch (\Throwable $th) {
            return "false";
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if ($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                } else {
                    echo "File is not an image.";
                }
                $image = $this->uploadFile($_FILES["image"]);
                $name = isset($_POST["name"]) ?  $_POST["name"] : '';
                $price = isset($_POST["price"]) ?  $_POST["price"] : '';
                $quantity = isset($_POST["quantity"]) ?  $_POST["quantity"] : '';
                $category_id = isset($_POST["category_id"]) ?  $_POST["category_id"] : '';
                $description = isset($_POST["description"]) ?  $_POST["description"] : '';
                $discount = isset($_POST["discount"]) ?  $_POST["discount"] : '';
                $id = isset($_POST["idproduct"]) ?  $_POST["idproduct"] : '';
                if (!$name || !$price || !$quantity || !$category_id || !$description || !$image) {
                    if ($_SERVER["HTTP_REFERER"])
                        header("Location: " . $_SERVER["HTTP_REFERER"]);
                    header("Location: ./admin.php?controller=product");
                    return;
                }
                $data = [
                    "name" => $name,
                    "price" => $price,
                    "quantity" => $quantity,
                    "image" => $image,
                    "category_id" => $category_id,
                    "description" => $description,
                    "discount" => $discount,
                ];
                if ($id) {
                    $this->productModel->updateById($id, $data);
                } else {
                    $product = $this->productModel->store($data);
                }
                if ($_SERVER["HTTP_REFERER"])
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                header("Location: ./admin.php?controller=product");
            } catch (\Throwable $th) {
                if ($_SERVER["HTTP_REFERER"])
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                header("Location: ./admin.php?controller=product");
            }
        }
    }

    function uploadFile($file)
    {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Check file size
        if ($file["size"] > 500000) {
            return null;
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            return null;
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            return null;
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                return $target_file;
            } else {
                return null;
            }
        }
    }
}
