<?php

namespace MPuget\blog\Controllers;

use MPuget\blog\Models\Post;
use MPuget\blog\Models\TimeTrait;
use MPuget\blog\Repository\PostRepository;
use MPuget\blog\Repository\UserRepository;
use MPuget\blog\Controllers\CoreController;

class PostController extends CoreController
{
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

    public function formPost()
    {
        var_dump("PostController->formPost()");
        $userRepo = new UserRepository();
        $userlist = $userRepo->findAll();

        $viewData = [
            'pageTitle' => 'OCR - Blog - formPost',
            'userList' => $userlist,
        ];

        $this->show('post/formPost', $viewData);
    }

    public function addPost()
    {
        var_dump("PostController->addPost()");

        $postRepository = new PostRepository();
        $newPost = $postRepository->addPost();

        $viewData = [
            'pageTitle' => 'OCR - Blog - post',
            'newPost' => $newPost
        ];

        $this->show('post/post', $viewData);
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