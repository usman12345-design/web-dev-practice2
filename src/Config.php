<?php
namespace App;

class Config
{
    public array $config;

    public function __construct()
    {
        $this->config = [
            'db' => [
                'host' => $_ENV['DB_HOST'],
                'dbname' => $_ENV['DB_DATABASE'],
                'user' => $_ENV['DB_USER'],
                'pass' => $_ENV['DB_PASS']
            ],
        ];

    }

    public function __get($name)
    {
        return $this->config[$name] ?? null;
    }
}