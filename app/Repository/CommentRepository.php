<?php

namespace MPuget\blog\Repository;

use MPuget\blog\Models\Comment;
use MPuget\blog\Models\User;
use MPuget\blog\Models\Post;
use MPuget\blog\Utils\Database;
use MPuget\blog\Repository\UserRepository;
use MPuget\blog\Repository\PostRepository;


class CommentRepository extends AbstractRepository
{

    /**
     * find() permet de récupérer un produit spécifique par son id
     * 
     * @param Integer id du produit à récupérer
     * @return Comment
     */
    public function find($id): ?Comment
    {
        $id = intval($id);

        $pdoStatement = $this->pdo->prepare('SELECT * FROM `comment` WHERE id = :id');
        $pdoStatement->execute([
            'id' => $id,
        ]);
        $result = $pdoStatement->fetchObject();

        $userRepo = new UserRepository();
        $userId = $result->user_id;
        $user = $userRepo->find(intval($userId));
        $result->user = $user;

        $postRepo = new PostRepository();
        $postId = $result->post_id;
        $post = $postRepo->find($postId);
        $result->post = $post;

        
        $comment = new Comment($result);
        $comment->setId($result->id);
        $comment->setBody($result->body);
        $comment->setUser($result->user);
        $comment->setPost($result->post);
        $comment->setCreatedAt(date('Y-m-d H:i:s'));

        return $comment;
    }

    /**
     * findAll() permet de récupérer tous les enregistrement de la table product
     * 
     * @return Post[]
     */
    public function findAll()
    {
        $pdoStatement = $this->pdo->prepare('SELECT id FROM `comment`');
        $pdoStatement->execute();
        $commentList = $pdoStatement->fetchAll();
        $comments = [];
        foreach ($commentList as $comment) {
            $comment = $this->find($comment['id']);
            $comments[] = $comment;
        }
        
        return $comments;
    }

    public function findAllforOnePost(Post $post)
    {
        $pdoStatement = $this->pdo->prepare('SELECT id FROM `comment`
        WHERE post_id=:postId');
        $pdoStatement->execute([
            "postId" => $post->getId(),
        ]);
        $commentList = $pdoStatement->fetchAll();

        $comments = [];
        foreach ($commentList as $comment) {

            $comment = $this->find($comment['id']);
            $comments[] = $comment;
        }
        
        return $comments;
    }

    public function addComment()
    {
        var_dump("CommentRepository->addComment()");

        $newComment = $_POST;
        if (
			!isset($newComment['body'])
			|| !isset($newComment['userId'])
        ) {
            echo('Il faut un un message et un auteur valide pour soumettre le formulaire.');
            return;
        }
		
        $userRepo = new UserRepository();
        $user = $userRepo->find($newComment['userId']);
		$newComment['user'] = $user;

        $postRepo = new PostRepository();
        $post = $postRepo->find($newComment['postId']);
		$newComment['post'] = $post;

        $comment = new Comment();
        $comment->setBody($newComment['body']);
        $comment->setUser($newComment['user']);
        $comment->setPost($newComment['post']);
        $comment->setCreatedAt(date('Y-m-d H:i:s'));

        $pdoStatement = $this->pdo->prepare("INSERT INTO comment (body, user_id, post_id)
        VALUES (:body, :userId, :postId)");
        $pdoStatement->execute([
            'body' => $comment->getBody(),
            'userId'  => intval($comment->getUser()->getId()),
            'postId'  => intval($comment->getPost()->getId()),
        ]);

        $commentId = Database::getPDO()->lastInsertId();
        $comment = $this->find($commentId);

        return $comment;
    }

    public function updateComment()
    {
       
    }

    public function deleteComment(Comment $comment) : bool
    {
        var_dump("CommentRepository->deleteComment()");

        $sql = "DELETE FROM `comment` WHERE id = ( :id) ";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([
            'id' => $comment->getId(),
        ]);

        return true;
    }

}
