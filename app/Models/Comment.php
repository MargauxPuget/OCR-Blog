<?php

namespace MPuget\blog\Models;

use MPuget\blog\Models\User;
use MPuget\blog\Models\Post;
use MPuget\blog\Models\IdTrait;
use MPuget\blog\Models\TimeTrait;

/**
 * repositoryClass=CommentRepository::class
 */
class Comment
{
    use IdTrait;
    use TimeTrait;

    /**
     * body
     * type="text"
     */
    private $body;

    /**
     * user
     * type="User"
     */
    private $user;

    /**
     * post
     * type="Post"
     */
    private $post;


    public function __construct($var = [])
    {
        var_dump('CONS', $var['post']);
        if (empty($var)) {
            return;
        }

        $this->setBody($var['body']);
       
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
        var_dump('CONS_1', $this);
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

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(Post $post): self
    {
        $this->post = $post;

        return $this;
    }
}
