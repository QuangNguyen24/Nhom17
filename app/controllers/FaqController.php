<?php
class FaqController extends Controller {
    public function index() {
        $this->view('faq/index', ['title' => 'FAQ']);
    }

    public function warranty() {
        $this->view('faq/warranty', ['title' => 'Chính sách bảo hành']);
    }

    public function return() {
        $this->view('faq/return', ['title' => 'Chính sách đổi trả']);
    }

    public function shipping() {
        $this->view('faq/shipping', ['title' => 'Chính sách vận chuyển']);
    }

    public function privacy() {
        $this->view('faq/privacy', ['title' => 'Chính sách bảo mật']);
    }

    public function payment_faq() {
        $this->view('faq/payment_faq', ['title' => 'Thanh toán']);
    }

    public function introduction_faq() {
        $this->view('faq/introduction_faq', ['title' => 'Hướng dẫn đặt hàng']);
    }
}
