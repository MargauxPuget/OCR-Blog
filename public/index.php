<?php

require_once __DIR__ . '/../vendor/autoload.php';

// require de nos Controllers
use MPuget\blog\Controllers\CoreController;
use MPuget\blog\Controllers\MainController;
use MPuget\blog\Controllers\ErrorController;

// require de nos Controllers
require_once __DIR__ . '/../app/controllers/CoreController.php';
require_once __DIR__ . '/../app/controllers/MainController.php';
require_once __DIR__ . '/../app/controllers/ErrorController.php';


//* -----------------------------------------------------
//*                Routeur : AltoRouter
//* -----------------------------------------------------

// On commence par instancier un objet AltoRouter
$router = new AltoRouter();

// on donne à AltoRouter la partie de l'URL à ne pas prendre en compte pour faire la 
// comparaison entre l'URL demandée par le visiteur (exemple /categoy/1) et l'URL de notre route
$publicFolder = dirname($_SERVER['SCRIPT_NAME']);
$router->setBasePath($publicFolder);



// On va ensuite pouvoir mapper nos routes
$homr =$router->map(
    'GET',
    '/', // l'URL de cette route
    // target :
    [
        'action' => 'home', // méthode à appeler
        'controller' => 'MainController' // controller concerné
    ],
    'home' // le nom qu'on donne à notre route (pour $router->generate())
);

var_dump($homr);
var_dump($router->generate('home'));
// $router->map(
//     'GET',
//     '/about', // l'URL de cette route
//     // target :
//     [
//         'action' => 'about', // méthode à appeler
//         'controller' => 'MainController' // controller concerné
//     ],
//     'about' // le nom qu'on donne à notre route (pour $router->generate())
// );

// $router->map(
//     'GET',
//     '/product/[i:id_produit]', // l'URL de cette route
//     // target :
//     [
//         'action' => 'product', // méthode à appeler
//         'controller' => 'ProductController' // controller concerné
//     ],
//     'product' // le nom qu'on donne à notre route (pour $router->generate())
// );

// on vient "matcher" l'URL demandée par le visiteur avec nos routes définies ci-dessus !
$match = $router->match();
// $router->match() va retourner false si la route n'existe pas !




//* -----------------------------------------------------
//*                     Dispatcher
//* -----------------------------------------------------
var_dump($match);
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