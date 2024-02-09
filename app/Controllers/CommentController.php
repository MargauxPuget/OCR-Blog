<?php

namespace MPuget\blog\Controllers;

use MPuget\blog\Models\Comment;
use MPuget\blog\Models\TimeTrait;
use MPuget\blog\Repository\CommentRepository;
use MPuget\blog\Repository\UserRepository;
use MPuget\blog\Controllers\CoreController;

class CommentController extends CoreController
{
    protected $commentRepo;

    public function __construct(){
        //$this->postRepo = new PostRepository();
    }

    public function formComment()
    {
		
    }

    public function addComment()
    {
        var_dump("CommentController->addComment()");
var_dump($_POST);
		$commentRepo = new CommentRepository();
		$newComment = $commentRepo->addComment();

        var_dump($newComment);


        $viewData = [
            'pageTitle' => 'OCR - Blog - comment - add',
			'post' => $post,
            'comment' => $newComment,
        ];

        $this->show('post/post', $viewData);
    }

    public function updateComment()
    {
        
    } 

    public function deleteComment()
    {

    }

}