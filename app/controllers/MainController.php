<?php

namespace MPuget\blog\controllers;

use MPuget\blog\models\TimeTrait;
use MPuget\blog\models\User;
use MPuget\blog\models\Post;

class MainController extends CoreController
{
    // une page = une méthode
    public function home()
    {
        // si j'ai besoin de données depuis la BDD :
        // 0. j'ajoute les require dont j'ai besoin
            //* ils sont dans les use ligne 5 et 6
        // 1. j'instancie mon modèle
        $userModel = new User();
        var_dump($userModel);
        // 2. j'utilise la méthode appropriée pour récupérer les données dont j'ai besoin
        $userList = $userModel->findAll();
var_dump($userList);
        $viewData = [
            'pageTitle' => 'OCR - Blog - Accueil',
            'userList' => $userList
        ];

        // on délègue l'affichage de nos vues à la méthode show()
        $this->show('home', $viewData);
    }

    public function about()
    {
        $viewData = [
            'pageTitle' => 'OCR - Blog - À propos'
        ];

        $this->show('about', $viewData);
    }
}