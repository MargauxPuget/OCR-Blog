<?php

namespace MPuget\blog\Repository;

use MPuget\blog\Models\User;
use MPuget\blog\Utils\Database;


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
        $pdoStatement = $this->pdo->prepare('SELECT id FROM `user`');
        $pdoStatement->execute();
        $userList = $pdoStatement->fetchAll();
        $users = [];
        foreach ($userList as $user) {
            $user = $this->find($user['id']);
            $users[] = $user;
        }

        return $users;
    }

    /**
     * find() permet de récupérer un produit spécifique par son id
     * 
     * @param Integer id du produit à récupérer
     * @return User
     */
    public function find($id)
    {
        $id = intval($id); 

        $pdoStatement = $this->pdo->prepare('SELECT * FROM `user` WHERE id = :id');
        $pdoStatement->execute([
            'id' => $id,
        ]);

        // pour récupérer un seul objet de type User, on utilise 
        // la méthode fetchObject() de PDO !
        $result = $pdoStatement->fetchObject();

        $user = new User();
        $user->setId($result->id);
        $user->setFirstname($result->firstname);
        $user->setLastname($result->lastname);
        $user->setEmail($result->email);
        $user->setpassword($result->password);

        return $user;
    }


    public function addUser()
    {
        var_dump("UserRepository->addUser()");

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

        $sql = "INSERT INTO user (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([
            'firstname' => $user->getFirstname(),
            'lastname'  => $user->getLastname(),
            'email'     => $user->getEmail(),
            'password'  => $user->getPassword(),
        ]);


        $userId = Database::getPDO()->lastInsertId();
        $user->setId($userId);
        var_dump($user);

        echo('Bienvenue ' . $newUser['firstname'] . ' maintenant vous etes bien ajouté ! <br>');

        return $this;
    }

    public function updateUser()
    {
        var_dump("UserRepository->updateUser()");

var_dump('$_POST', $_POST);
        $newUser = [];
        if (isset($_POST['firstname'])){
            $newUser = $_POST['firstname'];
        }
        if (isset($_POST['lastname'])){
            $newUser = $_POST['lastname'];
        }
        if (isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $newUser = $_POST['email'];
        }
        if (isset($_POST['password'])){
            $newUser = $_POST['password'];
        }
        var_dump($newUser);
        echo('Bienvenue ' . $newUser['firstname'] . ' ! <br>');
    }

    public function deleteUser(int $id) : bool
    {
        var_dump("UserRepository->deleteUser()");

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
