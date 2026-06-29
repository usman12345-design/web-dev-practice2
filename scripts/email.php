<?php
require_once __DIR__ . '/../vendor/autoload.php';

$container = new App\Container;

(new App\myApp($container))->boot();

$container->get(\App\Services\EmailService::class)->SendQueuedEmails();
