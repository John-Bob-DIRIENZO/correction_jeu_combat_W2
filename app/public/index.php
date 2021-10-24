<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';

// Il faut set toutes les dépendances que l'on
// veut auto-injecter
$dic = new \App\Fram\Utils\DIC();
$dic->set('ConnectionInterface', function () {
    return new \App\Fram\Factories\PDOFactory();
});
$dic->autoInjects('Manager');

$router = new \App\Fram\Router();
$router->getController();