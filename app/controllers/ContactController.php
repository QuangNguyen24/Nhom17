<?php

class ContactController extends Controller
{
    // Hiển thị form liên hệ
    public function index()
    {
        $this->view('contact/index');
    }

    // Xử lý gửi liên hệ
    public function send()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = trim($_POST['fullname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $message = trim($_POST['message'] ?? '');

            if ($fullname && $email && $message) {
                $contactModel = $this->model('Contact');
                $contactModel->createContact($fullname, $email, $message);

                header('Location: index.php?url=contact/index&success=1');
                exit;
            } else {
                header('Location: index.php?url=contact/index&error=1');
                exit;
            }
        }
    }
}
