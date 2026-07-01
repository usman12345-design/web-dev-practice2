<?php
/* this database class for dbl connecton
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\ArrayParameterType;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Connection;

class database
{
    protected Connection  $connection;
    public function __construct(array $config)
    {
           $this->connection = DriverManager::getConnection($config);
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->connection, $method], $args);

    }
}*/