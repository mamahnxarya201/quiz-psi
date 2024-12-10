<?php

namespace Controller;

use Database\ConnectionPDO;
use Model\Repository\PersonRepository;
use Router\Attributes\GET;

class HomeController
{
    #[GET('/')]
    public function homeController(): void
    {
        $personCollection = (new PersonRepository(ConnectionPDO::connect()))->getAll();
        require 'src/views/home.php';
    }
}