<?php

class UserController extends BaseController
{
    private $userModel;

    public function __construct()
    {
        $this->loadModel('userModel');
        $this->loadModel('orderModel');
        $this->loadModel('orderItemModel');
        $this->orderItem = new orderItemModel;
        $this->userModel = new userModel;
        $this->orderModel = new orderModel;
    }

    public function index()
    {
        $users = $this->userModel->getAll();
        return $this->view('fontend.admin.users.index', [
            "users" => $users,
        ]);
    }

    public function delete()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['data']) && isset($_POST['data']['id'])) {
                    $id = $_POST['data']['id'];
                    $orders = $this->orderModel->getAllByUserId($id);
                    $orders = $orders['data'];
                    foreach ($orders as &$value) {
                        $this->orderItem->deleteByOrderId($value['id']);
                    }
                    $this->orderModel->deleteByUserId($id);
                    $this->userModel->deleteById($id);
                    return true;
                }
            }
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = isset($_POST['password']) ? $_POST['password'] : "";
            $email = isset($_POST['email']) ? $_POST['email'] : "";
            $phone = isset($_POST['phone']) ? $_POST['phone'] : "";
            $id = isset($_POST['userid']) ? $_POST['userid'] : "";
            if ( !$password || !$phone || !$email || !$id) {
                if ($_SERVER["HTTP_REFERER"])
                return header("Location: " . $_SERVER["HTTP_REFERER"]);
            }

            $data = [
                "email" => $email,
                "phone" => $phone,
                "password" => $password
            ];

            $this->userModel->updateById($id,$data);
            if ($_SERVER["HTTP_REFERER"])
            return header("Location: " . $_SERVER["HTTP_REFERER"]);
            return header("Location: index.php ");
        } else {
            if ($_SERVER["HTTP_REFERER"])
            return header("Location: " . $_SERVER["HTTP_REFERER"]);
            return header("Location: index.php ");
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = isset($_POST['username']) ? $_POST['username'] : "";
            $password = isset($_POST['password']) ? $_POST['password'] : "";
            if (!$username || !$password) {
                if ($_SERVER["HTTP_REFERER"])
                    return header("Location: " . $_SERVER["HTTP_REFERER"]);
            }
            $user = $this->userModel->login($username, $password);
            if ($user === null) {
                if ($_SERVER["HTTP_REFERER"])
                    return header("Location: " . $_SERVER["HTTP_REFERER"]);
            }
            if (!$user['status']) {
                if ($_SERVER["HTTP_REFERER"])
                    return header("Location: " . $_SERVER["HTTP_REFERER"]);
            }
            $_SESSION['user'] = $user['data'];
            if ($_SERVER["HTTP_REFERER"])
                return header("Location: " . $_SERVER["HTTP_REFERER"]);
            return header("Location: index.php ");
        } else {
            if ($_SERVER["HTTP_REFERER"])
                return header("Location: " . $_SERVER["HTTP_REFERER"]);
            return header("Location: index.php ");
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = isset($_POST['username']) ? $_POST['username'] : "";
            $password = isset($_POST['password']) ? $_POST['password'] : "";
            $email = isset($_POST['email']) ? $_POST['email'] : "";
            $phone = isset($_POST['phone']) ? $_POST['phone'] : "";
            $confirmpassword = isset($_POST['confirmpassword']) ? $_POST['confirmpassword'] : "";
            if (!$username || !$password || !$confirmpassword || !$phone || !$email) {
                if ($_SERVER["HTTP_REFERER"])
                    return header("Location: " . $_SERVER["HTTP_REFERER"]);
            }
            $user = $this->userModel->register($username, $password, $confirmpassword, $email, $phone);
            if ($user === null) {
                if ($_SERVER["HTTP_REFERER"])
                    return header("Location: " . $_SERVER["HTTP_REFERER"]);
            }
            $user = $this->login($user, $password);
            if ($user === null) {
                if ($_SERVER["HTTP_REFERER"])
                    return header("Location: " . $_SERVER["HTTP_REFERER"]);
            }
            if (!$user['status']) {
                if ($_SERVER["HTTP_REFERER"])
                    return header("Location: " . $_SERVER["HTTP_REFERER"]);
            }
            $_SESSION['user'] = $user['data'];
            if ($_SERVER["HTTP_REFERER"])
                return header("Location: " . $_SERVER["HTTP_REFERER"]);
            return header("Location: index.php ");
        } else {
            if ($_SERVER["HTTP_REFERER"])
                return header("Location: " . $_SERVER["HTTP_REFERER"]);
            return header("Location: index.php ");
        }
    }

    public function logout()
    {
        unset($_SESSION['user']);
        return header("Location: index.php ");
    }
}
