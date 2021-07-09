<?php

use core\Controller;

class User extends Controller
{
    public function add(array $data)
    {
        $this->model->store((object) $data);
        header("Location:../../..");
    }
    public function read($data = [])
    {
        if (empty($data)) {
            $result = $this->model->read();

            echo json_encode($result);
        }
    }
    public function del($data = [])
    {
        if (!empty($data)) {
            if (isset($data['id'])) {
                $result = $this->model->destroy($data['id']);
            }
        }
    }
}
