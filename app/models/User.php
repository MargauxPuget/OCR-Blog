<?php

namespace MPuget\blog\Models;

use DateTime;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User extends TimeTrait
{
    /**
     * userId
     * type="integer"
     */
    private $userId;

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
        $this->setCreatedAt(new DateTime());
    }

    public function getUserId(): ?int
    {
        return $this->UserId;
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
}
