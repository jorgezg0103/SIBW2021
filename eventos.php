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

    
    
    if(isset($_POST['borrar'])){
        $id = $_POST['borrar'];
        borrarEvento($id);
        header("Location: eventos.php");
        exit();
    }
    
    if(isset($_POST['editar'])){
    $_SESSION['idEvento']= $_POST['editar'];
    header("Location: editEvent.php");
    }
    else{
        $_SESSION['idEvento']= -1;
    }
    
    if(isset($_POST['buscar'])){
        $_SESSION['valorBusqueda'] = $_POST['buscar'];
        $eventos = buscarEventos($_SESSION['valorBusqueda']);
    }else{
        $eventos = getTotalEventos();
    }
    
    
    echo $twig->render('eventos.html', ['usuario' => $user, 'eventos' => $eventos]);
?>
