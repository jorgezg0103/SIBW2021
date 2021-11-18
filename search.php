<?php

require_once "/usr/local/lib/php/vendor/autoload.php";

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

require_once "bd.php";

session_start();

$user = [];
  
if(isset($_SESSION['nombreUsuario'])){
$user = obtenerUsuario($_SESSION['nombreUsuario']);
}

if(isset($_POST["consulta"])){
    $lista = consultarEvento($_POST["consulta"]);
}


echo $twig->render('lista.html', ["listaEventos" => $lista, "usuario" => $user]);

?>
