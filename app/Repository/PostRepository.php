<?php

namespace MPuget\blog\Repository;

use MPuget\blog\Models\Post;
use MPuget\blog\Models\User;
use MPuget\blog\Utils\Database;
use MPuget\blog\Repository\UserRepository;


class PostRepository extends AbstractRepository
{

    /**
     * find() permet de récupérer un produit spécifique par son id
     * 
     * @param Integer id du produit à récupérer
     * @return Post
     */
    public function find($id)
    {
        $id = intval($id);

        $pdoStatement = $this->pdo->prepare('SELECT * FROM `post` WHERE id = :id');
        $pdoStatement->execute([
            'id' => $id,
        ]);
        $result = $pdoStatement->fetchObject();


        $userRepo = new UserRepository();

        $userId = $result->user_id;

        $user = $userRepo->find($userId);

        $result->user = $user;
        
        $post = new Post();
        $post->setTitle($result->title);
        $post->setBody($result->body);
        $post->setUser($result->user);
        $post->setCreatedAt($result->created_at);
        $post->setUpdatedAt($result->updated_at);

        return $result;
    }

    /**
     * findAll() permet de récupérer tous les enregistrement de la table product
     * 
     * @return Post[]
     */
    public function findAll()
    {
        $pdoStatement = $this->pdo->prepare('SELECT id FROM `post`');
        $pdoStatement->execute();
        $postList = $pdoStatement->fetchAll();
        $posts = [];
        foreach ($postList as $post) {
            $post = $this->find($post['id']);
            $posts[] = $post;
        }
        //var_dump('1', $posts);
        return $posts;
    }


    public function addPost()
    {
        var_dump("PostRepository->addPost()");

        $newPost = $_POST;
        if (
        !isset($newPost['title'])
        || !isset($newPost['body'])
        || !isset($newPost['userId'])
        ) {
            echo('Il faut un title et un message et un auteur valide pour soumettre le formulaire.');
            return;
        }
        echo('Voila un nouvel article ' . $newPost['title'] . ' ! <br>');

        $post = new Post($newPost);
        $userRepo = new UserRepository();

        $user = $userRepo->find($newPost['userId']);
        $int = intval($user->getId());


        $pdoStatement = $this->pdo->prepare("INSERT INTO post (title, body, user_id) VALUES (:title, :body, :userId)");
        $pdoStatement->execute([
            'title' => $post->getTitle(),
            'body'  => $post->getBody(),
            'userId' => $int,
        ]);

        $postId = Database::getPDO()->lastInsertId();
        $post->setId($postId);

        //var_dump('post', $this->find($postId));

        echo('Le nouvel article ' . $newPost['title'] . 'est  maintenant bien ajouté en BDD! <br>');

        return $this;
    }

    public function deletePost() : bool
    {
        var_dump("PostRepository->deletePost()");

        $postData = $_POST;
        var_dump($postData);
        if (!isset($postData['identifiant']) && !is_int($postData['identifiant'])) {
            echo("Il faut l'identifiant d'un post/article.");
            return false;
        }
        $postId = $postData['identifiant'];
        echo('Byebye, number :  ' . $postId . ' ! <br>');

        $sql = "DELETE FROM `post` WHERE id = ( :id) ";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([
            'id' => $postId,
        ]);


        echo('On pleur votre départ ! <br>');

        return true;

    }


}
