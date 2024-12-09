<?php 
declare(strict_types=1);

namespace Model;

class Person 
{
    public function __construct(
        public int $id,
        public string $name,
        public string $tempatLahir,
        public string $alamat,
        public int $tanggalLahir,
        public bool $jenisKelamin,
        public string $base64Photo,
        public string $noTelp
    )
    {}

    public function getTanggalLahir(): string
    {
        return !is_null($this->tanggalLahir) ? date('Y-m-d', $this->tanggalLahir) : '';
    }
}