<?php

namespace MPuget\blog\controllers;

use MPuget\blog\Models\Post;
use MPuget\blog\Models\User;
use MPuget\blog\Models\TimeTrait;
use MPuget\blog\Repository\UserRepository;
use MPuget\blog\Controllers\CoreController;

class MainController extends CoreController
{
    // une page = une méthode
    public function home()
    {
        $userRepo = new UserRepository;

        $userList = $userRepo->find(1);
        
        $viewData = [
            'pageTitle' => 'OCR - Blog - Accueil',
            'userList' => $userList
        ];

        $this->show('home', $viewData);
    }

}