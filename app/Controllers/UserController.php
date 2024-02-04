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
        $userList = $this->userRepo->find(1);
        var_dump($userList);
        $viewData = [
            'pageTitle' => 'OCR - Blog - User',
            'userList' => $userList
        ];
        
        $this->show('user/home', $viewData);
    }

    public function formUser()
    {
        var_dump("UserController->formUser()");

        $viewData = [
            'pageTitle' => 'OCR - Blog - formUser',
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
        var_dump($postData);
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