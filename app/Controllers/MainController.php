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
        // si j'ai besoin de données depuis la BDD :
        // 0. j'ajoute les require dont j'ai besoin
            //* ils sont dans les use ligne 5 et 6
        // 1. j'instancie mon modèle
        $userRepo = new UserRepository;

        // 2. j'utilise la méthode appropriée pour récupérer les données dont j'ai besoin
        $userList = $userRepo->find(1);
        
        $viewData = [
            'pageTitle' => 'OCR - Blog - Accueil',
            'userList' => $userList
        ];

        // on délègue l'affichage de nos vues à la méthode show()
        $this->show('home', $viewData);
    }

}