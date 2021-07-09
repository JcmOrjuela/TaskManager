<?php

use core\Model;

class UserModel extends Model
{
    public $dbConn;

    private $table = 'users';
    private $campos = [
        'name',
        'password',
        'email',
        'update_at',
        'created_at',
    ];


    public function __construct()
    {
        parent::__construct($this->table, $this->campos);
    }

    public function store(Object $data)
    {
        $body = [
            'name' => $data->name,
            'password' => $data->password,
            'email' => $data->email,
            'update_at' => $data->create_at,
            'created_at' => $data->create_at,
        ];
        $this->create($body);
    }
    public function destroy(int $id)
    {
        $this->delete($id);
    }
}
