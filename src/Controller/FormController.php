<?php 
declare(strict_types=1);

namespace Controller;

use Database\ConnectionPDO;
use Model\Repository\PersonRepository;
use Router\Attributes\GET;
use Router\Attributes\Prefix;

#[Prefix('/form')]
class FormController
{
    #[GET('/view')]
    public function formViewDataController(): void
    {
        if (is_null($_GET['id'])) {
            echo 'ID not found !, ID is required for this page to render !'; 
            return;
        }
        $titleText = 'Melihat';
        $action = 'view';
        $person = (new PersonRepository(ConnectionPDO::connect()))->getById(intval($_GET['id']));

        require 'src/views/form.php';
    }

    #[GET('/edit')]
    public function formEditDataController(): void
    {
        if (is_null($_GET['id'])) {
            echo 'ID not found !, ID is required for this page to render !'; 
            return;
        }
        $titleText = 'Merubah';
        $action = 'edit';
        $person = (new PersonRepository(ConnectionPDO::connect()))->getById(intval($_GET['id']));

        require 'src/views/form.php';
    }

    #[GET('/add')]
    public function formAddDataController(): void
    {
        $titleText = 'Menambah';
        $action = 'add';

        require 'src/views/form.php';
    }
}