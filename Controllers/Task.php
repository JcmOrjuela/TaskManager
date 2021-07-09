<?php

use core\Controller;
use Models\{UserModel, StatusModel};


class Task extends Controller
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
        } else {
            $result = $this->model->read($data);
            echo json_encode($result);
        }
    }
    public function users($data = [])
    {
        if (!empty($data)) {
            $result = $this->model->getUsers($data['id']);

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
