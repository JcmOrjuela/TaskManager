<?php

use core\Model;

class StatusModel extends Model
{
    public $dbConn;

    private $table = 'statuses';
    private $campos = [
        'name',
    ];


    public function __construct()
    {
        parent::__construct($this->table, $this->campos);
    }

    public function store(Object $data)
    {
        $body = [
            'name' => $data->name,
        ];
        $this->create($body);
    }
    public function destroy(int $id)
    {
        $this->delete($id);
    }
}
