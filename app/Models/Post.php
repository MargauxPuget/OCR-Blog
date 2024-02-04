<?php

namespace MPuget\blog\models;

use PDO;
use DateTime;
use MPuget\blog\Models\User;
use MPuget\blog\Models\IdTrait;
use MPuget\blog\Utils\Database;
use MPuget\blog\Models\TimeTrait;

/**
 * repositoryClass=PostRepository::class
 */
class Post
{
    use IdTrait;
    use TimeTrait;

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
    private User $user;

    
    public function __construct($var = [])
    {
        if (empty($var)) {
            return;
        }
        $this->setTitle($var['title']);
        $this->setBody($var['body']);
        if (!empty($var['user'])) {
            $this->setUser($var['user']);
        }
        $this->setCreatedAt(new datetime());
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

	public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser($user): self
    {
        $this->user = $user;

        return $this;
    }

}
