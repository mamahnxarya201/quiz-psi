<?php

declare(strict_types=1);

namespace Model\Repository;

use Database\ConnectionPDO;
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
            $sth = ConnectionPDO::connect()->prepare("select * from person");
            $sth->execute();
            $personArray =  $sth->fetchAll(PDO::FETCH_ASSOC);
            ConnectionPDO::disconnect();
            $personCollection = [];
            foreach ($personArray as $person) {
                $personCollection[] = PersonFactory::createFromArray($person);
            }
            return $personCollection;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function getById(string $id): Person
    {
        try {
            $sth = ConnectionPDO::connect()->prepare("select * from person where id = :id");
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
            $sth->execute();
            $person =  $sth->fetch(PDO::FETCH_ASSOC);
            ConnectionPDO::disconnect();
            return PersonFactory::createFromArray($person);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
