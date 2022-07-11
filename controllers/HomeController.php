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
        } else if (isset($_GET['category'])) {
            $products = $this->productModel->getByCategory($_GET['category']);
        } else {
            $products = $this->productModel->getAllEnoughQuantity();
        }
        $categories = $this->CategoryModel->getAll();
        $productsSlide = $this->productModel->getAllEnoughQuantity();
        return $this->view('fontend.homes.index', [
            "products" => $products,
            "categories" => $categories,
            "productsSlide" => $productsSlide,
        ]);
    }
}
