<?php
namespace Models;
use core\Model;

class UserTaskModel extends Model
{
    public $dbConn;

    private $table = 'user_task';
    private $campos = [
        'id_user',
        'id_task'
    ];


    public function __construct()
    {
        parent::__construct($this->table, $this->campos);
    }

    public function store($id_users, $id_task)
    {
        $id_users = explode(',', $id_users);

        foreach ($id_users as $id_user) {

            $body = [
                'id_user' => $id_user,
                'id_task' => $id_task,
            ];
            $this->create($body);
        }
    }
    public function destroy(int $id)
    {
        $this->delete($id);
    }
}
