<?php

class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct($namespace = '') {
        $url = $this->parseUrl();

        // Controller name: HomeController, ProductController,...
        $controllerName = ucfirst($url[0] ?? 'home') . 'Controller';
        $controllerFile = '../app/controllers/' . ($namespace ? "$namespace/" : '') . $controllerName . '.php';
        $controllerClass = ($namespace ? "$namespace\\" : '') . $controllerName;

        // Nếu controller tồn tại trong namespace (admin/user)
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $this->controller = new $controllerClass;
            unset($url[0]);
        } else {
            // fallback nếu không tìm thấy (load HomeController mặc định)
            require_once '../app/controllers/HomeController.php';
            $this->controller = new HomeController();
        }

        // Kiểm tra phương thức
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        // Tham số truyền vào
        $this->params = $url ? array_values($url) : [];

        // Gọi controller/method/params
        try {
            call_user_func_array([$this->controller, $this->method], $this->params);
        } catch (ArgumentCountError $e) {
            echo "<h3 style='color:red'>Thiếu tham số truyền vào controller!</h3>";
            echo "<pre>{$e->getMessage()}</pre>";
        }

    }

    private function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
