<?php

namespace MPuget\blog\models;

use DateTime;
use MPuget\blog\models\IdTrait;
use MPuget\blog\models\TimeTrait;

/**
 * repositoryClass=CommentRepository::class
 */
class Comment
{

    use IdTrait;
    use TimeTrait;
    
    /**
     * title
     * type="text"
     */
    private $title;

    /**
     * body
     * type="text"
     */
    private $boby;

    /**
     * user_id
     * type="integer"
     */
    private $userId;

    /**
     * post_id
     * type="integer"
     */
    private $postId;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
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

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getPostId(): ?int
    {
        return $this->postId;
    }

    public function setPostId(int $postId): self
    {
        $this->postId = $postId;

        return $this;
    }
}
