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
    
    if(isset($_GET['ev'])){
        $idEv = $_GET['ev'];
    }
    else{
        $idEV = -1;
    }
    $evento = getEvento($idEv);
    
    if(isset($_POST['texto'])){
        $texto = $_POST['texto'];
        insertarComentario($idEv, $user['nombre'], $texto);
    }
    $comentarios = getComentarios($idEv);
    
    if(isset($_POST['borrar'])){
        $id = $_POST['borrar'];
        borrarComentario($id);
        header("Location: evento.php?ev=$idEv");
        exit();
    }
    
    if(isset($_POST['editar'])){
    $_SESSION['idComentario']= $_POST['editar'];
    header("Location: editComment.php");
    }
    else{
        $_SESSION['idComentario']= -1;
    }
    
    echo $twig->render('evento.html', ['evento' => $evento, 'usuario' => $user, 'comentarios' => $comentarios]);
?>
