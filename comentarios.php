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

    $comentarios = getTotalComentarios();
    
    if(isset($_POST['borrar'])){
        $id = $_POST['borrar'];
        borrarComentario($id);
        header("Location: comentarios.php");
        exit();
    }
    
    if(isset($_POST['editar'])){
    $_SESSION['idComentario']= $_POST['editar'];
    header("Location: editComment.php");
    }
    else{
        $_SESSION['idComentario']= -1;
    }
    
    echo $twig->render('comentarios.html', ['usuario' => $user, 'comentarios' => $comentarios]);
?>
