<?php

namespace MPuget\blog\Models;

use PDO;
use MPuget\blog\Utils\Database;
use MPuget\blog\Models\IdTrait;
use MPuget\blog\Models\TimeTrait;
use MPuget\blog\Repository\UserRepository;


class User
{
    use IdTrait;
    use TimeTrait;

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

    public function __construct($var = [])
    {
        if (empty($var)) {
            return;
        }
        $this->setId($var->id);
        $this->setFirstname($var->firstname);
        $this->setLastname($var->lastname);
        $this->setEmail($var->email);
        $this->setPassword($var->password);
        if (empty(($var->created_at))){
            $this->setCreatedAt(date('Y-m-d H:i:s'));
        } else {
            $this->setCreatedAt(date('created_at'));
        }
        if (!empty(($var->updates_at))){
            $this->setUpdatesAt(date('updates_at'));
        }
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

    public function getname(): ?string
    {
        return $this->firstname . ' ' . $this->lastname;
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
}
