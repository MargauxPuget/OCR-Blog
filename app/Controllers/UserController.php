<?php

namespace MPuget\blog\Controllers;

use MPuget\blog\Models\Post;
use MPuget\blog\Models\User;
use MPuget\blog\Models\TimeTrait;
use MPuget\blog\Repository\UserRepository;
use MPuget\blog\Controllers\CoreController;

class UserController extends CoreController
{

    protected $userRepo;

    public function __construct(){
        $this->userRepo = new UserRepository();
    }

    // une page = une méthode
    public function home()
    {
        $userList = $this->userRepo->findAll();
        $viewData = [
            'pageTitle' => 'OCR - Blog - User',
            'userList' => $userList
        ];
        //var_dump($viewData['userList']);
        
        /* foreach ($viewData['userList'] as &$user) {
            echo($user->getFirstname() . '<br>');
        } */



        $this->show('user/home', $viewData);
    }

    public function formUser()
    {
        var_dump("UserController->formUser()");

        // pour la modification dun user
        $postData = $_POST;
        $user = [];
        if (isset($postData['identifiant'])) {
            if (!isset($postData['identifiant']) && !is_int($postData['identifiant'])) {
                echo("Il faut l'identifiant d'un utilisateur.");
                return false;
            }

            $userId = intval($postData['identifiant']);
        
            $user = $this->userRepo->find($userId);
;        }

        $viewData = [
            'pageTitle' => 'OCR - Blog - formUser',
            'user' => $user,
        ];

        $this->show('user/formUser', $viewData);
    }

    public function addUser()
    {
        var_dump("UserController->addUser()");
        
        $newUser = $this->userRepo->addUser();

        $viewData = [
            'pageTitle' => 'OCR - Blog - user',
            'newUser' => $newUser
        ];

        $this->show('user/user', $viewData);
    }

    public function updateUser()
    {
        var_dump("UserController->updateUser()");
        
        $postData = $_POST;
        
        if (!isset($postData['identifiant']) && !is_int($postData['identifiant'])) {
            echo("Il faut l'identifiant d'un utilisateur.");
            return false;
        }

        $userId = intval($postData['identifiant']);
        
        $user = $this->userRepo->updateUser($userId);

        $viewData = [
            'pageTitle' => 'OCR - Blog - user - update',
            'user' => $user
        ];

        $this->show('user/updateUser', $viewData);
    } 

    public function deleteUser()
    {
        var_dump("UserController->deleteUser()");


        $postData = $_POST;
        var_dump($postData);
        if (!isset($postData['identifiant']) && !is_int($postData['identifiant'])) {
            echo("Il faut l'identifiant d'un utilisateur.");
            return false;
        }

        $userId = intval($postData['identifiant']);
        
        $user = $this->userRepo->deleteUser($userId);

        $viewData = [
            'pageTitle' => 'OCR - Blog - user - delete',
            'user' => $user
        ];

        $this->show('user/deleteUser', $viewData);
    }
}