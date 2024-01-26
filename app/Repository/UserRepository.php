<?php

namespace MPuget\blog\Repository;

use MPuget\blog\Models\User;


class UserRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $entity, bool $flush = false): void
    {
        
    }

    public function remove(User $entity, bool $flush = false): void
    {
        
    }


}
