<?php

namespace MPuget\blog\Controllers;

use MPuget\blog\twig\Twig;
use MPuget\blog\Models\Post;
use MPuget\blog\Models\TimeTrait;
use MPuget\blog\Controllers\CoreController;
use MPuget\blog\Repository\PostRepository;
use MPuget\blog\Repository\UserRepository;
use MPuget\blog\Repository\CommentRepository;

class PostController extends CoreController
{
    protected $postRepo;
    protected $userRepo;
    protected $commentRepo;
    protected $twig;

    public function __construct(){
        $this->twig = new Twig();
        $this->postRepo = new PostRepository();
        $this->userRepo = new UserRepository();
        $this->commentRepo = new CommentRepository();
    }

    public function home()
    {
        var_dump('PostControler->home()');
        $postList = $this->postRepo->findAll();
        
        $viewData = [
            'pageTitle' => 'OCR - Blog - Post',
            'postList' => $postList
        ];
        //var_dump($viewData['postList']);

        echo $this->twig->getTwig()->render('post/home.twig', $viewData);
        // $this->show('post/home', $viewData);
    }

    public function singlePost()
    {
        var_dump("PostController->singlePost()");

        $postId = $_POST['identifiant'];
        $post = $this->postRepo->find($postId);
        $userList = $this->userRepo->findAll();
        $commentList = $this->commentRepo->findAllforOnePost($post);

        $viewData = [
            'pageTitle'     => 'OCR - Blog - post',
            'post'          => $post,
            'userList'      => $userList,
            'commentList'   => $commentList,
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
        $userList = $this->userRepo->findAll();

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

        $newPost = $_POST;
        if (
        !isset($newPost['title'])
        || !isset($newPost['body'])
        || !isset($newPost['userId'])
        ) {
            echo('Il faut un title et un message et un auteur valide pour soumettre le formulaire.');
            return;
        }

        $post = new Post($newPost);

        $user = $this->userRepo->find($newPost['userId']);
        $int = intval($user->getId());

        $post->setTitle($newPost['title']);
        $post->setBody($newPost['body']);
        $post->setUser($user);
        $post->setCreatedAt(date('Y-m-d H:i:s'));

        $post = $this->postRepo->addPost($post);
        $viewData = [
            'pageTitle' => 'OCR - Blog - post',
            'post' => $post
        ];

        $this->show('post/post', $viewData);
    }

    public function updatePost()
    {
        var_dump("PostController->updatePost()");
        
        $postData = $_POST;
        if (!isset($postData['identifiant']) && !is_int($postData['identifiant'])) {
            echo("Il faut l'identifiant d'un utilisateur.");
            return false;
        }

        $post = $this->postRepo->find($_POST['identifiant']);

        if (isset($postData['title']) && ($postData['title'] !== $post->getTitle())){
            $post->setTitle($postData['title']);
        }
        if (isset($postData['body']) && ($postData['body'] !== $post->getBody())){
            $post->setBody($postData['body']);
        }
        if (isset($postData['userId']) && ($postData['userId'] !== $post->getUser()->getId())){
            $user = $this->userRepo->find($postData['userId']);
            $post->setUser($user);
        }
        $post = $this->postRepo->updatePost($post);

        $viewData = [
            'pageTitle' => 'OCR - Blog - post - update',
            'post' => $post
        ];

        $this->show('post/updatePost', $viewData);
    } 

    public function deletePost()
    {
        var_dump("PostController->deletePost()");

        $postData = $_POST;

        if (!isset($postData['identifiant']) && !is_int($postData['identifiant'])) {
            echo("Il faut l'identifiant d'un post/article.");
            return false;
        }
        
        $post = $this->postRepo->find($postData['identifiant']);

        $post = $this->postRepository->deletePost($post);

        $viewData = [
            'pageTitle' => 'OCR - Blog - post - delete',
            'post' => $post
        ];

        $this->show('post/deletePost', $viewData);
    }

}