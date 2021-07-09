<?php

namespace core;

use Core\DbConnexion;

class Model extends DbConnexion
{

    private $table;
    private $camps;

    public function __construct(String $table, array $camps)
    {
        parent::__construct();
        $this->dbConn = parent::db();

        $this->table = $table;
        $this->camps = implode(',', $camps);
    }

    public function create($data)
    {
        $query = <<<QUERY
        INSERT INTO {$this->table} ({$this->camps})
        VALUES 
        QUERY;

        $keys = array_keys($data);
        $keys = ':' . implode(', :', $keys);

        $query .= "($keys)";

        $stmt = $this->dbConn->prepare($query);
        return $stmt->execute($data);
    }
    public function read(array $filters = [])
    {
        $query = <<<QUERY
        SELECT * FROM {$this->table}
        QUERY;

        if (!empty($filters)) {
            $filters = array_sql_filter($filters);
            $query .= " WHERE $filters";
        }
        $stmt = $this->dbConn->prepare($query);
        if ($stmt->execute()) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
    public function update($id)
    {
    }
    public function delete($id)
    {
        $query = <<<QUERY
        DELETE FROM {$this->table}
        WHERE ID = ? 
        QUERY;

        $stmt = $this->dbConn->prepare($query);
        return $stmt->execute(array(
            $id
        ));
    }

    public function lastId()
    {
        return $this->dbConn->lastInsertId();
    }
}
