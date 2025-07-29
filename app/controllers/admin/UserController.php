<?php
namespace admin;

use Controller;

class UserController extends Controller
{
    public function index()
    {
        $userModel = $this->model('User');
        $users = User::getAll(); // Gọi static

        $this->view('admin/user/index', ['users' => $users]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $_POST['username'],
                'email'    => $_POST['email'],
                'role'     => $_POST['role']
            ];
            $this->model('User')->create($data);
            header('Location: admin.php?url=user/index');
            exit;
        }
        $this->view('admin/user/add');
    }

    public function edit($id)
    {
        $userModel = $this->model('User');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $_POST['username'],
                'email'    => $_POST['email'],
                'role'     => $_POST['role']
            ];
            $userModel->update($id, $data);
            header('Location: admin.php?url=user/index');
            exit;
        }

        $user = $userModel->getById($id);
        $this->view('admin/user/edit', ['user' => $user]);
    }

    public function delete($id)
    {
        $this->model('User')->delete($id);
        header('Location: admin.php?url=user/index');
    }
}
