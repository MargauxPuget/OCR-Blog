<?php

namespace MPuget\blog\controllers;

use MPuget\blog\Models\Post;
use MPuget\blog\Models\User;
use MPuget\blog\Models\TimeTrait;
use MPuget\blog\Repository\UserRepository;
use MPuget\blog\Controllers\CoreController;

class UserController extends CoreController
{
    // une page = une méthode
    public function home()
    {
        // si j'ai besoin de données depuis la BDD :
        // 0. j'ajoute les require dont j'ai besoin
            //* ils sont dans les use ligne 5 et 6
        // 1. j'instancie mon modèle
        $userRepo = new UserRepository;

        // 2. j'utilise la méthode appropriée pour récupérer les données dont j'ai besoin
        $userList = $userRepo->findAll();
        
        $viewData = [
            'pageTitle' => 'OCR - Blog - User',
            'userList' => $userList
        ];
        // var_dump($viewData['userList']);

        // on délègue l'affichage de nos vues à la méthode show()
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
        // je veux ajouter un nouvelle utilisateur
        $userRepository = new UserRepository();
        $newUser = $userRepository->addUser();

        $viewData = [
            'pageTitle' => 'OCR - Blog - user',
            'newUser' => $newUser
        ];

        $this->show('user/user', $viewData);
    }

    public function deleteUser()
    {
        var_dump("UserController->deleteUser()");
        // je veux ajouter un nouvelle utilisateur
        $userRepository = new UserRepository();
        $user = $userRepository->deleteUser();

        $viewData = [
            'pageTitle' => 'OCR - Blog - user - delete',
            'user' => $user
        ];

        $this->show('deleteUser', $viewData);
    }

    public function about()
    {
        $viewData = [
            'pageTitle' => 'OCR - Blog - À propos'
        ];

        $this->show('about', $viewData);
    }
}