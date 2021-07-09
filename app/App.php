<?php
require_once dirname(__DIR__, 1) . '\AutoLoad.php';
require_once dirname(__DIR__, 1) . '\Helpers\helpers.php';
class App
{
    public function  __construct()
    {

        $this->load_app();
    }

    private function load_app()
    {
        $info_request = $_SERVER['PATH_INFO'];
        $path_url = explode('/', $info_request);
        $path_url = array_map('strtolower', $path_url);


        $controller = ucFirst($path_url[1]);
        $method = $path_url[2] ?? $this->controller;
        $arguments = empty($_POST) ? $_GET : $_POST;
        
        $controller_path =  dirname(__DIR__, 1) . "/Controllers/{$controller}.php";

        if (file_exists($controller_path)) {
            require_once $controller_path;
            if (class_exists($controller)) {
                $controller = new $controller($this);
                if (method_exists($controller, $method)) {
                    $controller->{$method}($arguments);
                }
            }
        }
    }
}
new App();
