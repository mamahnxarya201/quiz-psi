<?php 
declare(strict_types=1);

namespace Controller;

use Database\ConnectionPDO;
use Model\Repository\PersonRepository;

class PageController
{
    public function homeController(): void
    {
        $personCollection = (new PersonRepository(ConnectionPDO::connect()))->getAll();
        require 'views/home.php';
    }

    public function formViewDataController(): void
    {
        if (is_null($_GET['id'])) {
            echo 'ID not found !, ID is required for this page to render !'; 
            return;
        }
        $titleText = 'Melihat';
        $action = 'view';
        $person = (new PersonRepository(ConnectionPDO::connect()))->getById($_GET['id']);

        require 'views/form.php';
    }

    public function formEditDataController(): void
    {
        if (is_null($_GET['id'])) {
            echo 'ID not found !, ID is required for this page to render !'; 
            return;
        }
        $titleText = 'Merubah';
        $action = 'edit';
        $person = (new PersonRepository(ConnectionPDO::connect()))->getById($_GET['id']);

        require 'views/form.php';
    }

    public function formAddDataController(): void
    {
        $titleText = 'Menambah';
        $action = 'add';
        
        require 'views/form.php';
    }
}