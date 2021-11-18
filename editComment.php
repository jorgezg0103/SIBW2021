<?php

require_once "/usr/local/lib/php/vendor/autoload.php";
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

require_once "bd.php";

session_start();


if(isset($_POST['texto'])){
    $texto = $_POST['texto'];
    editarComentario($_SESSION['idComentario'], $texto);
    header("Location: index.php");
    exit();
}

$comentario = getComentario($_SESSION['idComentario']);

echo $twig->render('editComment.html', ['comentario' => $comentario]);
?>
