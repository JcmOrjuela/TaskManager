<?php

namespace core;

class View
{
    public function getView($controller, $view, $data = null)
    {
        $controller = get_class($controller);
        $view = "Views/$controller/$view.php";
        require_once($view);
    }
}
