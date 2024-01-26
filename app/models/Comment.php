<?php

// namespace MPuget\Entity;
// use DateTime;

/**
 * repositoryClass=CommentRepository::class
 */
class Comment extends TimeTrait
{
    /**
     * commentId
     * type="integer"
     */
    private $commentId;

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

    /**
     * type="datetime"
     */
    private $createdAt;

    /**
     * type="datetime", nullable=true)
     */
    private $updatedAt;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
    }

    public function getCommentId(): ?int
    {
        return $this->commentId;
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
}
