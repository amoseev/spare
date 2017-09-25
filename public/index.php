<?php

require_once(__DIR__ . '../../vendor/autoload.php');

$dotenv = new Dotenv\Dotenv(__DIR__. '/../');
$dotenv->load();

$container = \Infrastructure\Container\ContainerFactory::create();

error_reporting(E_ALL ^ E_DEPRECATED);

/** @var \Slim\App $app */
$app = $container->get('app');
$app->run();