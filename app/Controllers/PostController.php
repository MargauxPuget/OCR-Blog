<?php

namespace MPuget\blog\Controllers;

use MPuget\blog\Models\Post;
use MPuget\blog\Models\TimeTrait;
use MPuget\blog\Repository\PostRepository;
use MPuget\blog\Repository\UserRepository;
use MPuget\blog\Controllers\CoreController;

class PostController extends CoreController
{
    protected $postRepo;

    public function __construct(){
        $this->postRepo = new PostRepository();
    }

    public function home()
    {
        $postRepo = new PostRepository;
        $postList = $postRepo->findAll();
        
        $viewData = [
            'pageTitle' => 'OCR - Blog - Post',
            'postList' => $postList
        ];
        //var_dump($viewData['postList']);

        $this->show('post/home', $viewData);
    }

    public function singlePost()
    {
        var_dump("PostController->singlePost()");

        $postId = $_POST['identifiant'];
        $postRepo = new PostRepository();
        $post = $postRepo->find($postId);

        $userRepo = new UserRepository();
        $userList = $userRepo->findAll();

        $viewData = [
            'pageTitle' => 'OCR - Blog - post',
            'post'      => $post,
            'userList'  => $userList,
        ];

        $this->show('post/post', $viewData);
    }
    public function formPost()
    {
        // pour la modification dun post
        $postData = $_POST;
        $post = [];
        if (isset($postData['identifiant'])) {
            if (!isset($postData['identifiant']) && !is_int($postData['identifiant'])) {
                echo("Il faut l'identifiant d'un utilisateur.");
                return false;
            }
            $postId = intval($postData['identifiant']);
            $post = $this->postRepo->find($postId);
        }

        // On récupère tous les utilisateur
        $userRepo = new UserRepository();
        $userList = $userRepo->findAll();

        $viewData = [
            'pageTitle' => 'OCR - Blog - formPost',
            'post'      => $post,
            'userList'  => $userList,
        ];

        $this->show('post/formPost', $viewData);
    }

    public function addPost()
    {
        var_dump("PostController->addPost()");

        $postRepo = new PostRepository();
        $newPost = $postRepo->addPost();

        $viewData = [
            'pageTitle' => 'OCR - Blog - post',
            'post' => $newPost
        ];

        $this->show('post/post', $viewData);
    }

    public function updatePost()
    {
        var_dump("PostController->updatePost()");
        
        $postData = $_POST;
        var_dump($postData);
        if (!isset($postData['identifiant']) && !is_int($postData['identifiant'])) {
            echo("Il faut l'identifiant d'un utilisateur.");
            return false;
        }

        $postId = intval($postData['identifiant']);
        
        $post = $this->postRepo->updatePost($postId);

        $viewData = [
            'pageTitle' => 'OCR - Blog - post - update',
            'post' => $post
        ];

        $this->show('post/updatePost', $viewData);
    } 

    public function deletePost()
    {
        var_dump("PostController->deletePost()");

        $postRepository = new PostRepository();
        $post = $postRepository->deletePost();

        $viewData = [
            'pageTitle' => 'OCR - Blog - post - delete',
            'post' => $post
        ];

        $this->show('post/deletePost', $viewData);
    }

}