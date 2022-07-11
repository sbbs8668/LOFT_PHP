<?php

namespace Src;

use PDO;
use PDOException;

class PdoDb
{
    private static self $instance;

    private PDO $pdo;
    private array $log;

    private string $query;
    private array $parameters;
    private string $method;

    private string $host;
    private string $dbname;
    private string $dsn;
    private string $user;
    private string $pswd;

    private function __construct()
    {
        $this->host = 'localhost';
        $this->dbname= 'loftblog';
        $this->dsn = "mysql:host=$this->host; dbname=$this->dbname";
        $this->user = 'loftuser';
        $this->pswd = 'loftuser1111';
    }
    private function __clone()
    {
    }
    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    private function connect()
    {
        if (!isset($this->pdo)) {
            try {
                $this->pdo = new PDO($this->dsn, $this->user, $this->pswd);
            }catch (PDOException $error) {
                echo $error->getMessage();
                exit;
            }
        }
        return $this->pdo;
    }
    private function callDB()
    {
        $this->connect();
        $startTime = microtime(1);
        $callDB = $this->pdo->prepare($this->query);
        $result = $callDB->execute($this->parameters);
        $timeFinal = $startTime - microtime(1);
        if (!$result) {
            if ($callDB->errorCode()) {
                trigger_error(json_encode($callDB->errorInfo()));
            }
            return false;
        }
        $this->log[] = [
            'query' => $this->query,
            'time' => $timeFinal,
            'method' => $this->method,
        ];
        return $callDB;
    }
    public function exec(string $query, array $parameters = [], string $method = '')
    {
        $this->query = $query;
        $this->parameters = $parameters;
        $this->method = $method;
        $callDB = $this->callDB();

        return $callDB->rowCount();
    }
    public function fetchAll(string $query, array $parameters = [], string $method = '')
    {
        $this->query = $query;
        $this->parameters = $parameters;
        $this->method = $method;
        $callDB = $this->callDB();

        return $callDB->fetchAll(PDO::FETCH_ASSOC);
    }
    public function fetchOne(string $query, array $parameters = [], string $method = '')
    {
        $this->query = $query;
        $this->parameters = $parameters;
        $this->method = $method;
        $callDB = $this->callDB();
        $result = $callDB->fetchAll(PDO::FETCH_ASSOC);

        return reset($result);
    }
    public function getLastId(): int
    {
        $this->connect();
        return $this->pdo->lastInsertId();
    }
    public function getLog()
    {
        $this->connect();
        return $this->log;
    }
}
