<?php

use core\Controller;

class Status extends Controller
{

    public function read($data = [])
    {
        if (empty($data)) {
            $result = $this->model->read();

            echo json_encode($result);
        }
    }
}
