<?php

class AdminController extends BaseController
{
    public function __construct()
    {
        $this->loadModel('ProductModel');
        $this->loadModel('OrderModel');
        $this->loadModel('DiscountModel');
        $this->productModel = new ProductModel;
        $this->orderModel = new OrderModel;
        $this->discountModel = new DiscountModel;
    }

    public function index()
    {
        $products = $this->productModel->getProductsold();
        $total = $this->orderModel->getTotal();
        $discounts = $this->discountModel->getAll();
        return $this->view('fontend.admin.home.index', [
            "products" => $products,
            "total" => $total,
            "discounts"=> $discounts,
        ]);
    }

}
