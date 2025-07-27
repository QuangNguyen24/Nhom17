<?php

require_once '../app/models/User.php';
require_once '../PHPMailer/PHPMailer.php';
require_once '../PHPMailer/SMTP.php';
require_once '../PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController extends Controller
{
    public function index()
    {
        return $this->login();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $userModel = new User();
            $user = $userModel->getByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['user_id'] = $user['id'];

                if (isset($_SESSION['redirect_after_login'])) {
                $redirect = $_SESSION['redirect_after_login'];
                unset($_SESSION['redirect_after_login']);
                header('Location: ' . $redirect);
                exit;
            }

                $redirect = ($user['role'] === 'admin') ? '/admin.php?url=dashboard' : '/index.php';
                header('Location: ' . BASE_URL . $redirect);
                exit;
            }
            

            return $this->view('auth/login', ['error' => 'Sai tài khoản hoặc mật khẩu!']);
        }

        return $this->view('auth/login');
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $phone    = trim($_POST['phone'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (!$username || !$email || !$phone || !$password) {
                return $this->view('auth/register', ['error' => 'Vui lòng điền đầy đủ thông tin.']);
            }

            $userModel = new User();

            if ($userModel->exists($username)) {
                return $this->view('auth/register', ['error' => 'Tên đăng nhập đã tồn tại.']);
            }

            $userModel->create([
                'username' => $username,
                'password' => $password,
                'email'    => $email,
                'phone'    => $phone,
                'role'     => 'customer'
            ]);

            $user = $userModel->getByUsername($username);
            $_SESSION['user'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_id'] = $user['id'];

            header("Location: " . BASE_URL . "/index.php?url=auth/login");
            exit;
        }

        return $this->view('auth/register');
    }

  public function forgot_password()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $userModel = new User();
            $user = $userModel->getByEmail($email);

            if ($user) {
                $pin = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $_SESSION['reset_pin'] = $pin;
                $_SESSION['reset_email'] = $email;
                $_SESSION['reset_expires'] = time() + 300;

                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'nhieuphuc2004@gmail.com';
                    $mail->Password = 'shyaqmrtbxftphne';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    $mail->setFrom('nhieuphuc2004@gmail.com', 'Nexorevn E-Commerce');
                    $mail->addAddress($email);
                    $mail->isHTML(true);
                    $mail->Subject = 'Reset Password PIN';
                    $mail->Body = "<p>Your reset PIN: <strong>$pin</strong></p><p>This PIN is valid for 5 minutes.</p>";

                    $mail->send();
                    header("Location: " . BASE_URL . "/index.php?url=auth/verify_pin");
                    exit;
                } catch (Exception $e) {
                    return $this->view('auth/forgot_password', ['error' => 'Failed to send email.']);
                }
            }

            return $this->view('auth/forgot_password', ['error' => 'Email not found.']);
        }

        return $this->view('auth/forgot_password');
    }

    public function verify_pin()
    {
        if (!isset($_SESSION['reset_pin'], $_SESSION['reset_email'])) {
            header("Location: " . BASE_URL . "/auth/forgot_password");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input_pin = trim(strval($_POST['pin'] ?? ''));
            $actual_pin = strval($_SESSION['reset_pin']);
            $expires = $_SESSION['reset_expires'] ?? 0;

            if (time() > $expires) {
                session_unset();
                return $this->view('auth/verify_pin', ['error' => 'PIN expired.']);
            }

            if ($input_pin === $actual_pin) {
                $_SESSION['pin_verified'] = true;
                header("Location: " . BASE_URL . "/index.php?url=auth/reset_password");
                exit;
            }

            return $this->view('auth/verify_pin', ['error' => 'Incorrect PIN.']);
        }

        return $this->view('auth/verify_pin');
    }

    public function reset_password()
    {
        if (!isset($_SESSION['reset_email'], $_SESSION['pin_verified'])) {
            header("Location: " . BASE_URL . "/auth/forgot_password");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = trim($_POST['password'] ?? '');
            $confirm = trim($_POST['confirm_password'] ?? '');

            if ($password !== $confirm) {
                return $this->view('auth/reset_password', ['error' => 'Passwords do not match.']);
            }

            $userModel = new User();
            $userModel->updatePassword($_SESSION['reset_email'], $password);

            session_unset();
            header("Location: " . BASE_URL . "/index.php?url=auth/login?reset=success");
            exit;
        }

        return $this->view('auth/reset_password');
    }
}
