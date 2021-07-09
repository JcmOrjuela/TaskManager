<?php

namespace core;

use core\View;

class Controller
{
    public function __construct()
    {
        $this->views = new View();
        $this->loadModel();
    }
    public function loadModel()
    {
        $model = get_class($this) . "Model";
        $routeClass =  dirname(__FILE__, 2) . "/Models/" . $model . ".php";
        if (file_exists($routeClass)) {
            require_once $routeClass;

            $this->model = new $model();
        }
    }
}
