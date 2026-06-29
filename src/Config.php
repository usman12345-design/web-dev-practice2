<?php
namespace App;

class Config
{
    public array $config;

    public function __construct()
    {
        $this->config = [
            'db' => [
                'dbname' => $_ENV['DB_DATABASE'],
                'user' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASS'],
                'host' => $_ENV['DB_HOST'],
                'driver' => $_ENV['DB_DRIVER']
            ],
            'Mailer' => [
                'dsn' => $_ENV['MAILER_DSN'] ?? []
            ]
        ];

    }

    public function __get($name)
    {
        return $this->config[$name] ?? null;
    }
}