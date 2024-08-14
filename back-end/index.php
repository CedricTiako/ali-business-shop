<?php
// index.php
header("Access-Control-Allow-Origin: *"); // Allow requests from all origins
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Activer l'affichage des erreurs pour le développement
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Fonction pour gérer les requêtes
function handleRequest($route, $method) {
   
    $routeParts = explode('/', $route);
    $baseRoute = $routeParts[0];
    $id = isset($routeParts[1]) ? $routeParts[1] : null;

    // Dictionnaire pour mapper les routes aux fichiers PHP
    $routes = [
        'banners'=>'banners.php',
        'products' => 'products.php',
        'categories' => 'categories.php',
        'product_images' => 'product_images.php',
        'sizes' => 'sizes.php',
        'colors' => 'colors.php',
        'reviews' => 'reviews.php',
        'additional_information' => 'additional_information.php',
        'users' => 'users.php',
        'related_products' => 'related_products.php',
        'carts' => 'carts.php',
        'cart_items' => 'cart_items.php',
        'orders' => 'orders.php',
        'order_details' => 'order_details.php',
        'favorites' => 'favorites.php',
    ];

    if (isset($routes[$baseRoute])) {
        $file = $routes[$baseRoute];
        
        // Passer les paramètres à travers les variables d'environnement
        $_GET['id'] = $id;
        $_SERVER['REQUEST_METHOD'] = $method;
        
        // Inclure le fichier correspondant
        include $file;
    } else {
        // Route non trouvée
        header('HTTP/1.1 404 Not Found');
        echo json_encode(['error' => 'Not Found']);
    }
}

// Récupérer l'URL demandée
$requestUri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Nettoyer l'URL et extraire la route
$parts = parse_url($requestUri);
$route = trim($parts['path'], '/');
$route = str_replace('back-end/index.php/', '', $route); // Enlever 'index.php/' du début
$route = str_replace('shop/', '', $route); // Enlever 'index.php/' du début

// Traiter la requête
handleRequest($route, $method);
?>
