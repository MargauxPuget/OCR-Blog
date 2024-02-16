<?php

require_once __DIR__ . '/../vendor/autoload.php';

// require de nos Controllers
use MPuget\blog\Controllers\CoreController;
use MPuget\blog\Controllers\MainController;
use MPuget\blog\Controllers\UserController;
use MPuget\blog\Controllers\ErrorController;


//* -----------------------------------------------------
//*                Routeur : AltoRouter
//* -----------------------------------------------------

// On commence par instancier un objet AltoRouter
$router = new AltoRouter();
// echo get_class($router);
// on donne à AltoRouter la partie de l'URL à ne pas prendre en compte pour faire la 
// comparaison entre l'URL demandée par le visiteur (exemple /categoy/1) et l'URL de notre route
$publicFolder = dirname($_SERVER['SCRIPT_NAME']);
$router->setBasePath($publicFolder);


// On va ensuite pouvoir mapper nos routes
$router->map(
    'GET',
    '', // l'URL de cette route
    // target :
    [
        'action' => 'home', // méthode à appeler
        'controller' => 'MPuget\blog\Controllers\MainController' // controller concerné
    ],
    'home' // le nom qu'on donne à notre route (pour $router->generate())
);
$router->generate('home');


$router->map(
  'get',
  'toto',
  // target :
  [
      'action' => 'toto',
      'controller' => 'MPuget\blog\Controllers\UserController'
  ],
  'toto'
);
$router->generate('toto');

//*--------------------------
//*   User
//*--------------------------

$router->map(
  'get',
  'user',
  // target :
  [
      'action' => 'home',
      'controller' => 'MPuget\blog\Controllers\UserController'
  ],
  'userHome'
);
$router->generate('userHome');

$router->map(
  'POST',
  'formUser',
  // target :
  [
      'action' => 'formUser',
      'controller' => 'MPuget\blog\Controllers\UserController'
  ],
  'formUser'
);
$router->generate('formUser');

$router->map(
  'POST',
  'addUser',
  // target :
  [
      'action' => 'addUser',
      'controller' => 'MPuget\blog\Controllers\UserController'
  ],
  'addUser'
);
$router->generate('addUser');

$router->map(
  'post',
  'updateUser',
  // target :
  [
      'action' => 'updateUser',
      'controller' => 'MPuget\blog\Controllers\UserController'
  ],
  'updateUser'
);
$router->generate('updateUser');

$router->map(
  'post',
  'deleteUser',
  // target :
  [
      'action' => 'deleteUser',
      'controller' => 'MPuget\blog\Controllers\UserController'
  ],
  'deleteUser'
);
$router->generate('deleteUser');


$match = $router->match();


//*--------------------------
//*   Post
//*--------------------------

$router->map(
  'get',
  'post',
  // target :
  [
      'action' => 'home',
      'controller' => 'MPuget\blog\Controllers\PostController'
  ],
  'postHome'
);
$router->generate('postHome');

$router->map(
  'POST',
  'formPost',
  // target :
  [
      'action' => 'formPost',
      'controller' => 'MPuget\blog\Controllers\PostController'
  ],
  'formPost'
);
$router->generate('formPost');

$router->map(
  'POST',
  'singlePost',
  // target :
  [
      'action' => 'singlePost',
      'controller' => 'MPuget\blog\Controllers\PostController'
  ],
  'singlePost'
);
$router->generate('singlePost');

$router->map(
  'POST',
  'addPost',
  // target :
  [
      'action' => 'addPost',
      'controller' => 'MPuget\blog\Controllers\PostController'
  ],
  'addPost'
);
$router->generate('addPost');

$router->map(
  'post',
  'updatePost',
  // target :
  [
      'action' => 'updatePost',
      'controller' => 'MPuget\blog\Controllers\PostController'
  ],
  'updatePost'
);
$router->generate('updatePost');

$router->map(
  'post',
  'deletePost',
  // target :
  [
      'action' => 'deletePost',
      'controller' => 'MPuget\blog\Controllers\PostController'
  ],
  'deletePost'
);
$router->generate('deletePost');



//*--------------------------
//*   Comment
//*--------------------------

$router->map(
  'POST',
  'addComment',
  // target :
  [
      'action' => 'addComment',
      'controller' => 'MPuget\blog\Controllers\CommentController'
  ],
  'addComment'
);
$router->generate('addComment');


$router->map(
  'post',
  'updateComment',
  // target :
  [
      'action' => 'updateComment',
      'controller' => 'MPuget\blog\Controllers\CommentController'
  ],
  'updateComment'
);
$router->generate('updateComment');


$router->map(
  'POST',
  'formComment',
  // target :
  [
      'action' => 'formComment',
      'controller' => 'MPuget\blog\Controllers\CommentController'
  ],
  'formComment'
);
$router->generate('formComment');


$router->map(
  'post',
  'deleteComment',
  // target :
  [
      'action' => 'deleteComment',
      'controller' => 'MPuget\blog\Controllers\CommentController'
  ],
  'deleteComment'
);
$router->generate('deletePost');


$match = $router->match();

















//* -----------------------------------------------------
//*                     Dispatcher
//* -----------------------------------------------------

// est-ce que notre route existe ? 
if($match) {
  // notre route existe, on va récupérer les données de la route 
  // que l'on a définit précédemment avec $router->map()

  // on récupère le controller
  $controllerName= $match['target']['controller'];

  //$match['target'] = 3ème paramètre défini dans les méthodes $router->map() ci-dessus

  // on récupère la méthode
  $method = $match['target']['action'];

  // on peut instancier notre controller
  $controller = new $controllerName();

  // on peut appeler la méthode de notre controller
  // on va envoyer les paramètres éventuels à notre méthode
  // ces paramètres étant ceux définis avec $router->map() ci dessus ! [i:id]
  $controller->$method($match['params']);
} else {
  // notre route n'existe pas, donc on renvoit sur une 404 !
  $controller = new ErrorController();
  $controller->error404();
}