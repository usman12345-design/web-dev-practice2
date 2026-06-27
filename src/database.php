<?php
namespace App;

class database
{
    protected \PDO $pdo;
    public function __construct($config)
    {
        $defaultoptions = [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => FALSE,
        ];
        try {
            $db_name = "mysql:host=" . $config['host'] . ";dbname=" . $config['dbname'];
            $this->pdo = new \PDO(
                $db_name,
                $config['user'],
                $config['pass'],
                $config['options'] ?? $defaultoptions
            );
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->pdo, $method], $args);

    }
}
