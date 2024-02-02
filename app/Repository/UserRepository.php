<?php

namespace MPuget\blog\Repository;

use MPuget\blog\Models\User;


class UserRepository extends AbstractRepository
{

       // 3ème chose à ajouter dans nos modèles : des méthodes findAll() & find()

    /**
     * findAll() permet de récupérer tous les enregistrement de la table product
     * 
     * @return User[]
     */
    public function findAll()
    {
        $sql = "SELECT * FROM `user`";
        $pdoStmt = $pdo->query($sql);

        $results = $pdoStmt->fetchAll();

        return $results;
    }

    /**
     * find() permet de récupérer un produit spécifique par son id
     * 
     * @param Integer id du produit à récupérer
     * @return User
     */
    public function find($id)
    {
        // notre requête SQL
        $sql = "SELECT * FROM `user` WHERE id = {$id}";

        
        // on récupère un pdo statement avec $pdo->query($sql)
        $pdoStmt = $this->pdo->query($sql);
        var_dump($pdoStmt);
        $pdoStatement = $this->pdo->prepare('SELECT * FROM `user` WHERE id = :id');
        $pdoStatement->execute([
            'id' => $id,
        ]);

        // pour récupérer un seul objet de type User, on utilise 
        // la méthode fetchObject() de PDO !
        $result = $pdoStatement->fetchObject();

        return $result;
    }


    public function createUser()
    {
        var_dump("UserRepository->createUser()");

        $newUser = $_POST;
        if (
        !isset($newUser['firstname'])
        || !isset($newUser['lastname'])
        || !isset($newUser['email'])
        || !filter_var($newUser['email'], FILTER_VALIDATE_EMAIL)
        || !isset($newUser['password'])
        ) {
            echo('Il faut un email et un message valide pour soumettre le formulaire.');
            return;
        }
        echo('Bienvenue ' . $newUser['firstname'] . ' ! <br>');

        $user = new User($newUser);
        var_dump($user);

        $sql = "INSERT INTO user (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([
            'firstname' => $user->getFirstname(),
            'lastname'  => $user->getLastname(),
            'email'     => $user->getEmail(),
            'password'  => $user->getPassword(),
        ]);


        echo('Bienvenue ' . $newUser['firstname'] . ' maintenant vous etes bien ajouté ! <br>');

        return $this;
    }

    public function deleteUser() : bool
    {
        var_dump("UserRepository->deleteUser()");

        $postData = $_POST;
        var_dump($postData);
        if (!isset($postData['identifiant']) && !is_int($postData['identifiant'])) {
            echo("Il faut l'identifiant d'un utilisateur.");
            return false;
        }
        $userId = $postData['identifiant'];
        echo('Byebye, number :  ' . $userId . ' ! <br>');

        $sql = "DELETE FROM `user` WHERE id = ( :id) ";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([
            'id' => $userId,
        ]);


        echo('On pleur votre départ ! <br>');

        return true;

    }


}
