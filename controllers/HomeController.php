<?php

class HomeController extends BaseController
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
        $products = [];
        if (isset($_GET['keysearch'])) {
            $products = $this->productModel->getByKeyword($_GET['keysearch']);
        } else {
            $products = $this->productModel->getAllEnoughQuantity();
        }
        $categories = $this->CategoryModel->getAll();
        return $this->view('fontend.homes.index', [
            "products" => $products,
            "categories" => $categories,
        ]);
    }
}
