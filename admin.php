<?php
require './core/Database.php';
require './models/BaseModel.php';
require './controllers/BaseController.php';
$listController = ['CategoryController', 'DiscountController', 'ContactController', 'AdminOrderController', 'AdminController', 'OrderController', 'ProductController', 'CartController', 'NotFoundController', 'HomeController', 'UserController'];
ob_start();
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: index.php');
}
$controllerName = ucfirst(($_REQUEST['controller'] ?? 'Admin') . 'Controller');

if (!in_array($controllerName, $listController)) {
    $controllerName = 'NotFoundController';
}
$actionName = $_REQUEST['action'] ?? 'index';
require "./controllers/${controllerName}.php";
$objectController = new $controllerName;
$objectController->$actionName();
