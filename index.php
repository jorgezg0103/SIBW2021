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
  
  $eventos = getTotalEventos();
  
  if(isset($_POST['borrar'])){
        $id = $_POST['borrar'];
        borrarEvento($id);
        header("Location: index.php");
        exit();
    }
    
    if(isset($_POST['editar'])){
    $_SESSION['idEvento']= $_POST['editar'];
    header("Location: editEvent.php");
    }
    else{
        $_SESSION['idEvento']= -1;
    }
    
  
  echo $twig->render('index.html', ['eventos' => $eventos, "usuario" => $user]);
?>
