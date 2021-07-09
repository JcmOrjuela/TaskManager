<?php


spl_autoload_register(function ($class) {
    if (file_exists(
        $library = dirname(__FILE__) . "/$class.php"
    )) {
        require_once $library;
    }
});
