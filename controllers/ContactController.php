<?php

class ContactController extends BaseController
{

    public function __construct()
    {
        $this->loadModel('ContactModel');
        $this->contactModel = new ContactModel;
    }

    public function index()
    {
        return $this->view('fontend.contacts.index', [
            "categories" => ["one" => 1, "two" => 2, "three" => 3]
        ]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = isset($_POST['name']) ? $_POST['name'] : "";

            $email = isset($_POST['email']) ? $_POST['email'] : "";
            $message = isset($_POST['message']) ? $_POST['message'] : "";
            if (!$name || !$email || !$message) {
                return header("Location: index.php");
            }

            $result = $this->contactModel->store([
                "email" => $email,
                "name" => $name,
                "content" => $message
            ]);
            if ($result) {
                $_SESSION['message_response'] = "cảm ơn bạn đã cho chúng tôi biết";
                return $this->view('fontend.contacts.index');
            } else {
                return $this->view('fontend.contacts.index');
            }
        }
        return $this->view('fontend.contacts.index');
    }
}
