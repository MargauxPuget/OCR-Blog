<?php

namespace MPuget\blog\Controllers;

use MPuget\blog\Models\Comment;
use MPuget\blog\Controllers\CoreController;
use MPuget\blog\Repository\PostRepository;
use MPuget\blog\Repository\UserRepository;
use MPuget\blog\Repository\CommentRepository;

class CommentController extends CoreController
{
    protected $commentRepo;
    protected $postRepo;
    protected $userrepo;

    public function __construct(){
        $this->postRepo = new PostRepository();
		$this->commentRepo = new CommentRepository();
        $this->userRepo = new UserRepository();
    }

    public function formComment()
    {
		var_dump('CommentController->formComment()');

        // pour la modification dun comment
        $commentData = $_POST;
        $comment = [];
        if (isset($commentData['identifiant'])) {
            if (!isset($commentData['identifiant']) && !is_int($commentData['identifiant'])) {
                echo("Il faut l'identifiant d'un utilisateur.");
                return false;
            }
            $CommentId = intval($commentData['identifiant']);
            $comment = $this->commentRepo->find($CommentId);
        }

        // On récupère tous les info utilise à l'affichage de la page d'un single post
        $post = $this->postRepo->find($comment->getPost()->getId());
        $userList = $this->userRepo->findAll();
        $commentList = $this->commentRepo->findAllforOnePost($post);

        $viewData = [
            'pageTitle' => 'OCR - Blog - formComment',
            'comment'   => $comment,
            'post'      => $post,
            //'commentList'  => $commentList,
            //'userList'  => $userList,
        ];

        $this->show('comment/formComment', $viewData);
    }

    public function updateComment()
    {
        var_dump("CommentController->updateComment()");

        

        $viewData = [
            'pageTitle' => 'OCR - Blog - post - update',
            'post' => $post,
        ];

        $this->show('post/post', $viewData);
    } 

    public function addComment()
    {
        var_dump("CommentController->addComment()");

		$newComment = $this->commentRepo->addComment();

        $post = $this->postRepo->find($newComment->getPost()->getId());

        $userList = $this->userRepo->findAll();
        $commentList = $this->commentRepo->findAllforOnePost($post);

        $viewData = [
            'pageTitle' => 'OCR - Blog - comment - add',
			'post'      => $post,
            //'comment'   => $newComment,
            'commentList'  => $commentList,
            'userList'  => $userList,
        ];

        $this->show('post/post', $viewData);
    }

    public function deleteComment()
    {
        var_dump("CommentController->deleteComment()");

        $postData = $_POST;

        if (!isset($postData['identifiant']) && !is_int($postData['identifiant'])) {
            echo("Il faut l'identifiant d'un commentaire.");
            return false;
        }
        
        $comment = $this->commentRepo->find($postData['identifiant']);

        $comment = $this->commentRepo->deleteComment($comment);

        $viewData = [
            'pageTitle' => 'OCR - Blog - comment - delete',
            'comment' => $comment
        ];

        $this->show('comment/deleteComment', $viewData);
    }

}