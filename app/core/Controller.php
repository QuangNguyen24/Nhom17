<?php
class Controller {
    public function model($model) {
        // require_once '../app/models/' . $model . '.php';
        require_once __DIR__ . '/../models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = [])
{
    extract($data); // Tạo các biến như $products, $categories, ...
    require_once __DIR__ . '/../views/' . $view . '.php';
}

}
