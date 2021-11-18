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
    $estado = $_POST['estado'];
    editarEvento($_SESSION['idEvento'], $nombre, $lugar, $organizador, $descripcion, $fecha, $ruta1, $ruta2, $tag, $estado);
    header("Location: index.php");
    exit();
}

$evento = getEvento($_SESSION['idEvento']);


echo $twig->render('editEvent.html', ['evento' => $evento]);
?>
