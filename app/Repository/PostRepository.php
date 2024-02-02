<?php

namespace MPuget\blog\Repository;

use MPuget\blog\models\Post;
use MPuget\blog\Models\User;
use MPuget\blog\utils\Database;


class PostRepository extends DefaultRepository
{
    public function find($id): User
    {
        $pdoStatement = $this->pdo->prepare('SELECT * FROM `post` WHERE id = :id');
        $pdoStatement->execute([
            'id' => $id,
        ]);

        // pour récupérer un seul objet de type User, on utilise
        // la méthode fetchObject() de PDO !
        $result = $pdoStatement->fetchObject();

        $userRepo = new UserRepository();
        $user = $userRepo->find($result['user_id']);

        $post = new Post();
        $post->setTitle($result['title']);
        $post->setBody($result['body']);
        $post->setUser($user);

        return $user;
    }

    public function findAll()
    {
        $pdoStatement = $this->pdo->prepare('SELECT id FROM `post`');
        $result = $pdoStatement->fetchObject();
        $posts = [];
        foreach ($result as $array) {
            $post = $this->find($array['id']);
            $posts[] = $post;
        }

        return $posts;
    }

    public function create(Post $post)
    {
        $pdoStatement = $this->pdo->prepare('insert into post (id, body, title, user_id) values (null, :body, :title, :user_id)');
        $pdoStatement->execute([
            'body' => $post->getBody(),
            'title' => $post->getTitle(),
            'user_id' => $post->getUser()->getId()
        ]);

        $postId = Database::getPDO()->lastInsertId();
        $post->setId($postId);

        return $post;
    }
}
