<?php

namespace MPuget\blog\Repository;

use MPuget\blog\Models\User;
use MPuget\blog\utils\Database;


class UserRepository extends DefaultRepository
{
    public function find($id): User
    {
        $pdoStatement = $this->pdo->prepare('SELECT * FROM `user` WHERE id = :id');
        $pdoStatement->execute([
            'id' => $id,
        ]);

        // pour récupérer un seul objet de type User, on utilise
        // la méthode fetchObject() de PDO !
        $result = $pdoStatement->fetchObject();

       $user = new User();
       $user->setId($result['id']);
       $user->setFirstname($result['firstname']);
       $user->setLastname($result['lastname']);
       $user->setEmail($result['email']);

        return $user;
    }
}
