<?php

namespace tm\core;


class Database
{
    protected $pdo;
    protected static $instance;
    public static $countSql = 0;
    public static $queries = [];

    protected function __construct()
    {
        $database = $_ENV;
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ];
        $this->pdo = new \PDO($database['DB_DSN'], $database['DB_USER'], $database['DB_PASSWORD'], $options);
    }

    public static function instance()
    {
        if(self::$instance === null){

            self::$instance = new self;
        }

        return self::$instance;
    }

    public function execute($sql, $params = [])
    {
        self::$countSql++;
        self::$queries[] = $sql;

        $statement = $this->pdo->prepare($sql);

        return $statement->execute($params);
    }

    public function query($sql, $params = [])
    {
        self::$countSql++;
        self::$queries[] = $sql;

        $statement = $this->pdo->prepare($sql);
        $res = $statement->execute($params);

        if($res !== false){

            return $statement->fetchAll();
        }

        return [];
    }
}