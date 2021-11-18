<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";
    include("bd.php");
  
    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
    
    session_start();
    $user = [];
  
    if(isset($_SESSION['nombreUsuario'])){
        $user = obtenerUsuario($_SESSION['nombreUsuario']);
    }

    $usuarios = getTotalUsuarios();
    
    if(isset($_POST['id'])){
        $nickname = $_POST['id'];
        $tipo = $_POST['tipo'];
        cambiarPermisos($nickname, $tipo);
        if($nickname == $_SESSION['nombreUsuario']){
            header("Location: index.php");
        }
        else{
            header("Location: usuarios.php");
        }
    }
    
    
    echo $twig->render('usuarios.html', ['user' => $user, 'usuarios' => $usuarios]);
?>
