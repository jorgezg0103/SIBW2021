<?php

require_once "/usr/local/lib/php/vendor/autoload.php";
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

require_once "bd.php";

session_start();


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nombre = $_POST['nombre'];
    $lugar = $_POST['lugar'];
    $organizador = $_POST['organizador'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];
    $ruta1 = $_POST['ruta1'];
    $ruta2 = $_POST['ruta2'];
    $tag = $_POST['tag'];
    addEvento($nombre, $lugar, $organizador, $descripcion, $fecha, $ruta1, $ruta2, $tag);
    header("Location: index.php");
    exit();
}


echo $twig->render('addEvent.html', []);
?>
