<?php

require_once "/usr/local/lib/php/vendor/autoload.php";
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

require_once "bd.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];
    if(verificarUsuario($nickname, $password)){
        session_start();
        $_SESSION['nombreUsuario'] = $nickname;
    }
    header("Location: index.php");
    exit();
}

?>
