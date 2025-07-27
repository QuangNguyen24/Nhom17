<?php

namespace admin;

use Controller;

class ContactController extends Controller {
    public function index() {
        // session_start();

        if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
            header('Location: ../login.php');
            exit();
        }

        $contactModel = $this->model('Contact');
        $contacts = $contactModel->getAll();

        $this->view('admin/contact/index', ['contacts' => $contacts]);
    }
}
