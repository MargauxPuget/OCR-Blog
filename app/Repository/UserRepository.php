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
        //$user = $this->find($userId);
        $user->setId($userId);
        var_dump($user);

        echo('Bienvenue ' . $newUser['firstname'] . ' maintenant vous etes bien ajouté ! <br>');

        return $user;
    }

    public function updateUser()
    {
        var_dump("UserRepository->updateUser()");

        $user = $this->find($_POST['identifiant']);

        $updateUser = [];
        if (isset($_POST['firstname']) && ($_POST['firstname'] !== $user->getFirstname())){
            $updateUser['firstname'] = $_POST['firstname'];
        }
        if (isset($_POST['lastname']) && ($_POST['lastname'] !== $user->getLastname())){
            $updateUser['lastname'] = $_POST['lastname'];
        }
        if (isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
        && ($_POST['email'] !== $user->getEmail())){
            $updateUser['email'] = $_POST['email'];
        }
        if (isset($_POST['password']) && ($_POST['password'] !== $user->getPassword())){
            $updateUser['password'] = $_POST['password'];
        }

        $sql = "UPDATE user SET firstname=:firstname, lastname=:lastname, email=:email, password=:password
        WHERE id=:id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([
            'id'        => $user->getId(),
            'firstname' => (isset($updateUser['firstname'])) ? $updateUser['firstname'] : $user->getFirstname(),
            'lastname'  => (isset($updateUser['lastname'])) ? $updateUser['lastname'] : $user->getLastname(),
            'email'     => (isset($updateUser['email'])) ? $updateUser['email'] : $user->getEmail(),
            'password'  => (isset($updateUser['password'])) ? $updateUser['password'] : $user->getPassword(),
        ]);

    }

    public function deleteUser(int $id) : bool
    {
        var_dump("UserRepository->deleteUser()");

        echo('Byebye, number :  ' . $id . ' ! <br>');

        $sql = "DELETE FROM `user` WHERE id = ( :id) ";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([
            'id' => $id,
        ]);


        echo('On pleur votre départ ! <br>');

        return true;
    }
}
