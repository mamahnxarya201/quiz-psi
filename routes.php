<?php

declare(strict_types=1);

use Controller\HomeController;
use Controller\PersonController;
use Router\RouteBootstrap;
use Controller\FormController;

$controllerClass = [
    HomeController::class,
    FormController::class,
    PersonController::class
];

(new RouteBootstrap($controllerClass))
    ->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);