<?php
namespace core;
include_once dirname(__DIR__,1).'/config/config.php';

class DbConnexion
{
    public $pdo;
    private $dbName;

    public function __construct($dbName = 'TEST')
    {
        $this->dbName = strtoupper($dbName);
        try {
            $this->pdo = new \PDO(
                constant("DB_DSN_$this->dbName"),
                constant("DB_USER_$this->dbName"),
                constant("DB_PASS_$this->dbName")
            );

            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }
    public function db()
    {
        return $this->pdo;
    }
}