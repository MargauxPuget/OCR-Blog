<?php

namespace MPuget\blog\models;

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

    public function __construct($var = [])
    {
        if (empty($var)) {
            return;
        }
        $this->setId($var->id);
        $this->seBody($var->body);
        if (!empty($var['user'])) {
            $this->setUser($var['user']);
        }
        if (!empty($var['post'])) {
            $this->setPost($var['post']);
        }
        if (empty(($var->created_at))){
            $this->setCreatedAt(date('Y-m-d H:i:s'));
        } else {
            $this->setCreatedAt(date('created_at'));
        }
        if (!empty(($var->updates_at))){
            $this->setUpdatesAt(date('updates_at'));
        }
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

    public function setUser(int $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(int $post): self
    {
        $this->post = $post;

        return $this;
    }
}
