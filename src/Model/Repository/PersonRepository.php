<?php

declare(strict_types=1);

namespace Model\Repository;

use Database\ConnectionPDO;
use Exception;
use PDO;
use PDOException;
use Model\Factory\PersonFactory;
use Model\Person;

class PersonRepository
{
    public function __construct(
        protected PDO $db,
    ) {}

    public function getAll(): array
    {
        try {
            $sth = $this->db->prepare("select * from person");
            $sth->execute();
            $personArray =  $sth->fetchAll(PDO::FETCH_ASSOC);
            $personCollection = [];
            foreach ($personArray as $person) {
                $personCollection[] = PersonFactory::createFromArray($person);
            }
            return $personCollection;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function getById(int $id): Person
    {
        try {
            $sth = $this->db->prepare("select * from person where id = :id");
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
            $sth->execute();
            $person =  $sth->fetch(PDO::FETCH_ASSOC);
            ConnectionPDO::disconnect();
            return PersonFactory::createFromArray($person);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function addPerson(Person $person): void
    {
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $photoData = null;
        if ($person->base64Photo) {
            $photoData = base64_decode($person->base64Photo);
        }

        $sql = "INSERT INTO person (`name`, no_telp, alamat, jenis_kelamin, tanggal_lahir, tempat_lahir, photo) VALUES (:name, :no_telp, :alamat, :jenis_kelamin, :tanggal_lahir, :tempat_lahir, :photo)";

        $stmt =  $this->db->prepare($sql);

        $stmt->bindParam(':name', $person->name, PDO::PARAM_STR);
        $stmt->bindParam(':no_telp', $person->noTelp, PDO::PARAM_STR);
        $stmt->bindParam(':alamat', $person->alamat, PDO::PARAM_STR);
        $stmt->bindParam(':jenis_kelamin', $person->jenisKelamin, PDO::PARAM_BOOL);
        $stmt->bindParam(':tanggal_lahir', $person->getTanggalLahir(), PDO::PARAM_STR);
        $stmt->bindParam(':tempat_lahir', $person->tempatLahir, PDO::PARAM_STR);
        $stmt->bindParam(':photo', $photoData, PDO::PARAM_LOB);

        if (!$stmt->execute()) {
            throw new Exception("Error: " . $stmt->errorInfo()[2]);
        }
    }

    public function updatePerson(Person $person): void
    {
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $photoData = null;
        if ($person->base64Photo) {
            $photoData = base64_decode($person->base64Photo);
        }

        $sql = "UPDATE person SET `name` = :name, no_telp = :no_telp, alamat = :alamat, jenis_kelamin = :jenis_kelamin, tanggal_lahir = :tanggal_lahir, tempat_lahir = :tempat_lahir, photo = :photo WHERE id = :id";

        $stmt =  $this->db->prepare($sql);
        $stmt->bindParam(':id', $person->id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $person->name, PDO::PARAM_STR);
        $stmt->bindParam(':no_telp', $person->noTelp, PDO::PARAM_STR);
        $stmt->bindParam(':alamat', $person->alamat, PDO::PARAM_STR);
        $stmt->bindParam(':jenis_kelamin', $person->jenisKelamin, PDO::PARAM_BOOL);
        $stmt->bindParam(':tanggal_lahir', $person->getTanggalLahir(), PDO::PARAM_STR);
        $stmt->bindParam(':tempat_lahir', $person->tempatLahir, PDO::PARAM_STR);
        $stmt->bindParam(':photo', $photoData, PDO::PARAM_LOB);

        if (!$stmt->execute()) {
            throw new Exception("Error: " . $stmt->errorInfo()[2]);
        }
    }
}
