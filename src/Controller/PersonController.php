<?php 
declare(strict_types=1);

namespace Controller;

use Database\ConnectionPDO;
use Model\Person;
use Model\Repository\PersonRepository;
use Router\Attributes\GET;
use Router\Attributes\POST;
use Router\Attributes\Prefix;

#[Prefix('/api/person')]
class PersonController
{
    #[POST('/update')]
    public function updatePerson(): void
    {
        $personRepository = new PersonRepository(ConnectionPDO::connect());

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $person = $this->formatPersonRequest(true);
            $personRepository->updatePerson($person);

            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => 'Person added successfully']);
            exit;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            echo "Method Not Allowed";
        }
    }

    #[POST('/add')]
    public function addPerson()
    {
        $personRepository = new PersonRepository(ConnectionPDO::connect());

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $person = $this->formatPersonRequest();
            $personRepository->addPerson($person);

            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => 'Person added successfully']);
            exit;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            echo "Method Not Allowed";
        }
    }

    #[GET('/delete')]
    public function deletePerson(): void
    {
        $personRepository = new PersonRepository(ConnectionPDO::connect());

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $personRepository->deletePerson(intval($_GET['id']));

            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => 'Person added successfully']);
            exit;
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            echo "Method Not Allowed";
        }
    }

    private function formatPersonRequest(?bool $isEdit = false): Person
    {
        $nama = $_POST['nama'] ?? '';
        $tempat = $_POST['tempat'] ?? '';
        $tanggalLahir = strtotime($_POST['ttl']) ?? 0;
        $alamat = $_POST['alamat'] ?? '';
        $noTelp = $_POST['no_telp'] ?? '';
        $jenisKelamin = $_POST['jenis_kelamin'] ?? '';
        $fotoBase64 = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $fotoBase64 = base64_encode(file_get_contents($_FILES['foto']['tmp_name']));
        } else {
            $fotoBase64 = $_POST['foto_base64'] ?? null;
        }

        if ($jenisKelamin === 'Pria') {
            $jenisKelamin = true;
        } else {
            $jenisKelamin = false;
        }

        $id = 0;
        if ($isEdit) {
            $id = intval($_POST['id']);
        }

        if (is_null($fotoBase64) && $id != 0) {
            
            $person = (new PersonRepository(ConnectionPDO::connect()))->getById($id);
            $fotoBase64 = $person->base64Photo;
        }
        
        return new Person(
            id: $id,
            name: $nama,
            tempatLahir: $tempat,
            alamat: $alamat,
            tanggalLahir: $tanggalLahir,
            jenisKelamin: $jenisKelamin,
            base64Photo: $fotoBase64,
            noTelp: $noTelp
        );
    }
}