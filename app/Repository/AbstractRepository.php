<?php

namespace MPuget\blog\Repository;

use MPuget\blog\utils\Database;

class AbstractRepository
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = Database::getPDO();
    }
}
