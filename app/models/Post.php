<?php

namespace MPuget\blog\models;

use DateTime;
use PDO;
use MPuget\blog\utils\Database;
use MPuget\blog\models\TimeTrait;

/**
 * repositoryClass=PostRepository::class
 */
class Post
{

    use TimeTrait;
    /**
     * post-id
     * type="integer"
     */
    private $postId;

    /**
     * title
     * type="string", length=128
     */
    private $title;

    /**
     * body
     * type="text"
     */
    private $body;

    /**
     * user-id
     * type="integer"
     */
    private $userId;

    /**
     * created_at
     * type="datetime"
     */
    private $createdAt;

    /**
     * updated_at
     * type="datetime", nullable=true
     */
    private $updatedAt;
    
    public function __construct()
    {
        $this->setCreatedAt(new datetime());
    }

    public function getPostId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

	public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

	     /**
     * findAll() permet de récupérer tous les enregistrement de la table product
     * 
     * @return Product[]
     */
    /*public function findAll()
    {
        // notre requête SQL
        $sql = "SELECT * FROM `product`";

        // on récupère notre connexion à la BDD
        $pdo = Database::getPDO();

        // https://kourou.oclock.io/content/uploads/2020/11/query-exec.png
        // on récupère un pdo statement avec $pdo->query($sql)
        $pdoStmt = $pdo->query($sql);

        // https://kourou.oclock.io/content/uploads/2020/11/fetch-fetchall.png
        $results = $pdoStmt->fetchAll(PDO::FETCH_CLASS, 'Product');

        // il ne nous reste plus qu'à ... retourner ce tableau results !
        return $results;
    } */
}
