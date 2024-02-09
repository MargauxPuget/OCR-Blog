<?php

namespace MPuget\blog\Controllers;

use MPuget\blog\twig\Twig;
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

    public function toto(){
        $twig = new Twig();
        echo $twig->getTwig()->render('index.twig');
    }

    
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
        }

        $viewData = [
            'pageTitle' => 'OCR - Blog - formUser',
            'user' => $user,
        ];

        $this->show('user/formUser', $viewData);
    }

    public function addUser()
    {
        var_dump("UserController->addUser()");

        $newUser = $_POST;
        if (
        !isset($newUser['firstname'])
        || !isset($newUser['lastname'])
        || !isset($newUser['email'])
        || !filter_var($newUser['email'], FILTER_VALIDATE_EMAIL)
        || !isset($newUser['password'])
        ) {
            echo('Il faut un email et un message valide pour soumettre le formulaire.');
            return;
        }

        $user = new User();
        $user->setFirstname($newUser['firstname']);
        $user->setLastname($newUser['lastname']);
        $user->setEmail($newUser['email']);
        $user->setPassword($newUser['password']);
        $user->setCreatedAt(date('Y-m-d H:i:s'));

        $newUser = $this->userRepo->addUser($user);

        $viewData = [
            'pageTitle' => 'OCR - Blog - user',
            'user' => $newUser
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

        $user = $this->userRepo->find($_POST['identifiant']);

        if (isset($_POST['firstname']) && ($_POST['firstname'] !== $user->getFirstname())){
            $user->setFirstname($_POST['firstname']);
        }
        if (isset($_POST['lastname']) && ($_POST['lastname'] !== $user->getLastname())){
            $user->setLastname($_POST['lastname']);
        }
        if (isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
        && ($_POST['email'] !== $user->getEmail())){
            $user->setEmail($_POST['email']);
        }
        if (isset($_POST['password']) && ($_POST['password'] !== $user->getPassword())){
            $user->setPassword($_POST['password']);
        }      
        
        $user = $this->userRepo->updateUser($user);

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

        $user = $this->userRepo->find($postData['identifiant']);

        $userId = $user->getId();
        
        $this->userRepo->deleteUser($user);

        $viewData = [
            'pageTitle' => 'OCR - Blog - user - delete',
            'user' => $user
        ];

        $this->show('user/deleteUser', $viewData);
    }
}