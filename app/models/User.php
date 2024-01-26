<?php

namespace MPuget\blog\Models;

use DateTime;
use PDO;
use MPuget\blog\utils\Database;
use MPuget\blog\models\IdTrait;
use MPuget\blog\models\TimeTrait;
use MPuget\blog\Repository\UserRepository;


class User
{
    use IdTrait;

    /**
     * type="string", length=64
     */
    private $firstname;

    /**
     * type="string", length=64
     */
    private $lastname;

    /**
     * type="string", length=128
     */
    private $email;

    /**
     * type="string", length=128
     */
    private $password;

    public function __construct()
    {
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    // 3ème chose à ajouter dans nos modèles : des méthodes findAll() & find()

    /**
     * findAll() permet de récupérer tous les enregistrement de la table product
     * 
     * @return User[]
     */
    public function findAll()
    {
        // notre requête SQL
        $sql = "SELECT * FROM `user`";

        // on récupère notre connexion à la BDD
        $pdo = Database::getPDO();

        // https://kourou.oclock.io/content/uploads/2020/11/query-exec.png
        // on récupère un pdo statement avec $pdo->query($sql)
        $pdoStmt = $pdo->query($sql);

        // https://kourou.oclock.io/content/uploads/2020/11/fetch-fetchall.png
        $results = $pdoStmt->fetchAll();

        // il ne nous reste plus qu'à ... retourner ce tableau results !
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

        // on récupère notre connexion à la BDD
        $pdo = Database::getPDO();
        
        // on récupère un pdo statement avec $pdo->query($sql)
        $pdoStmt = $pdo->query($sql);
        $pdoStatement = $pdo->prepare('SELECT * FROM `user` WHERE id = :id');
        $pdoStatement->execute([
            'id' => $id,
        ]);

        // pour récupérer un seul objet de type User, on utilise 
        // la méthode fetchObject() de PDO !
        $result = $pdoStatement->fetchObject();

        return $result;
    }
}
