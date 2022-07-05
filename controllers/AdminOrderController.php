<?php

class AdminOrderController extends BaseController
{
    public function __construct()
    {
        $this->loadModel('OrderModel');
        $this->loadModel('StatusModel');
        $this->orderModel = new OrderModel;
        $this->statusOderModel = new StatusModel;
    }

    public function index()
    {
        $orders = $this->orderModel->getAll();
        $statusorders = $this->statusOderModel->getAll();
        return $this->view('fontend.admin.orders.index', [
            "orders" => $orders,
            "statusorders" => $statusorders
        ]);
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
            die(12);
            $this->orderModel->updateById($id, $data);
            header("Location: ./admin?controller=adminOrder");
        } catch (\Throwable $th) {
            header("Location: ./admin?controller=adminOrder");
        }
    }

    public function store()
    {
        echo __METHOD__;
    }
}
