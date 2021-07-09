<?php

use core\Model;

class TaskModel extends Model
{
    public $dbConn;

    private $table = 'tasks';
    private $campos = [
        'name',
        'description',
        'create_at',
        'update_at',
        'expire_at',
        'id_status',
    ];


    public function __construct()
    {
        parent::__construct($this->table, $this->campos);
    }

    public function store(Object $data)
    {
        $body = [
            'name' => $data->name,
            'description' => $data->description,
            'create_at' => $data->create_at,
            'update_at' => $data->create_at,
            'expire_at' => $data->expire_at,
            'id_status' => $data->id_status,
        ];
        $this->create($body);

        $userTask = new Models\UserTaskModel;
        $userTask->store($data->users, $this->lastId());
    }

    public function getUsers($id_task)
    {
        $query = "SELECT u.* FROM user_task ut
        INNER JOIN users u  on u.id  = ut.id_user 
        WHERE ut.id_task = $id_task ";

        $stmt = $this->dbConn->prepare($query);
        if ($stmt->execute()) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function destroy(int $id)
    {
        $query = "DELETE FROM user_task 
        WHERE id_task = $id ";
        
        $stmt = $this->dbConn->prepare($query);
        $stmt->execute();

        $this->delete($id);
    }
}
