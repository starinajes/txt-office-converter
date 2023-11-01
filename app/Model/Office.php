<?php

namespace OfficeConverter\Model;

/**
 * Модель офиса.
 * todo: переподключить в парсере на модель
 */
class Office
{
    private $id;
    private $name;
    private $address;
    private $phone;

    public function __construct($id, $name, $address, $phone)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->phone = $phone;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getPhone()
    {
        return $this->phone;
    }
}
