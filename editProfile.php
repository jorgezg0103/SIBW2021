<?php

require_once "/usr/local/lib/php/vendor/autoload.php";
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

require_once "bd.php";

session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $nickname = $_SESSION['nombreUsuario'];
    modificarUsuario($nickname, $nombre, $apellidos, $email, $password);
    header("Location: index.php");
    exit();
    
}
echo $twig->render('editProfile.html', []);
?>
