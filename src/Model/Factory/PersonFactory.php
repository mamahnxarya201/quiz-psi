<?php
declare(strict_types=1);

namespace Model\Factory;

use Model\Person;

class PersonFactory 
{
    public static function createFromArray(array $data): Person
    {
        return new Person(
            intval($data['id']),
            (string)$data['name'],
            (string)$data['tempat_lahir'],
            (string)$data['alamat'],
            strtotime($data['tanggal_lahir']),
            boolval($data['jenis_kelamin']),
            (string)$data['photo'],
            (string)$data['no_telp']
        );
    }
}