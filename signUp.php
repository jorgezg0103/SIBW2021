<?php

require_once "/usr/local/lib/php/vendor/autoload.php";
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

require_once "bd.php";


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nickname = $_POST['nickname'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    insertarUsuario($nickname, $nombre, $apellidos, $email, $password);
    
    header("Location: index.php");
    exit();
    
}
echo $twig->render('signUp.html', []);
?>
