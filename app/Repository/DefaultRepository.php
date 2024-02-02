<?php

namespace MPuget\blog\Repository;

use MPuget\blog\Models\User;
use MPuget\blog\utils\Database;


class DefaultRepository
{
    protected  $pdo;

    public function __construct()
    {
        $this->pdo = Database::getPDO();
    }
}
