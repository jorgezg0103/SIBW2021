<?php

    function iniciarConexion(){
        $mysqli = new mysqli("mysql", "jorgezg", "jorge", "SIBW");
        if($mysqli->connect_errno){
            echo("Fallo al conectar: " . $mysqli->connect_error);
        }
        return $mysqli;
    }
    
    function consultarEvento($nombre){
        $conexion = iniciarConexion();
        $conexion->set_charset("utf-8");
        
        if(isset($nombre)){
            $consulta = "SELECT * FROM eventos WHERE nombre LIKE '%$nombre%'";
            $res = mysqli_query($conexion, $consulta);
            $listaEventos = [];
            if(mysqli_num_rows($res) > 0){
                while($fila = mysqli_fetch_array($res)){
                    array_push($listaEventos, $fila);
                }
            }
        }
        return $listaEventos;
    }
    
    
    /*####################################################################################################################################*/
    /*#### GESTION EVENTOS ####*/
    /*####################################################################################################################################*/
    
    function getEvento($idEv){
        $bd = iniciarConexion();
        
        $stmt = $bd->prepare("SELECT nombre, lugar, organizador, descripcion, fecha FROM eventos WHERE id=?");
        $stmt->bind_param("i", $idEv);
        
        $stmt->execute();
        $arrEv = $stmt->get_result()->fetch_assoc();
        if(!$arrEv) exit('No existe la fila');
        $stmt->close();
        
        
        $stmt = $bd->prepare("SELECT rutaImagen1, rutaImagen2 FROM imagenes WHERE id=?");
        $stmt->bind_param("i", $idEv);
        
        $stmt->execute();
        $arrImg = $stmt->get_result()->fetch_assoc();
        if(!$arrImg) exit('No existe la fila');
        $stmt->close();
        
        
        $evento = array('id' => $idEv, 'nombre' => $arrEv['nombre'], 'lugar' => $arrEv['lugar'], 'organizador' => $arrEv['organizador'], 'descripcion' => $arrEv['descripcion'], 'fecha' => $arrEv['fecha'], 'rutaImagen1' => $arrImg['rutaImagen1'], 'rutaImagen2' => $arrImg['rutaImagen2']);
        
        return $evento;
    }
    
    function getTotalEventos(){
        $consulta = "SELECT eventos.id, nombre, lugar, organizador, descripcion, fecha, rutaImagen1, rutaImagen2, publicado from eventos JOIN imagenes ON eventos.id = imagenes.id;";
        
        $bd = iniciarConexion();
        
        $res = $bd->query($consulta);
        if($res->num_rows > 0){
            $eventos = $res->fetch_all();
        }

        return $eventos;
    }
    
    function buscarEventos($valorBusqueda){
        if($valorBusqueda == ''){
            $eventos = getTotalEventos();
        }
        else{
            $consulta = "SELECT eventos.id, nombre, lugar, organizador, descripcion, fecha, tag from eventos JOIN etiquetas ON eventos.id = etiquetas.id
                            WHERE nombre LIKE '".$valorBusqueda."%' OR tag LIKE '".$valorBusqueda."%';";
            $bd = iniciarConexion();
            $res = $bd->query($consulta);
            if($res->num_rows > 0){
                $eventos = $res->fetch_all();
            }
        }
        return $eventos;
    }
    /*buscarEventos('Jayena');*/
    
    function addEvento($nombre, $lugar, $organizador, $descripcion, $fecha, $ruta1, $ruta2, $tag){
        $insercionEv = "INSERT INTO eventos (nombre, lugar, organizador, descripcion, fecha) VALUES('".$nombre."' , '".$lugar."' , '".$organizador."' , '".$descripcion."' , '".$fecha."')";
        
        $bd = iniciarConexion();
        
        $bd->query($insercionEv);
        
        $id = $bd->insert_id;
        $insercionImg = "INSERT INTO imagenes VALUES('".$id."' , '".$ruta1."' , '".$ruta2."')";
        $insercionTag = "INSERT INTO etiquetas VALUES ('".$id."' , '".$tag."')";
        
        $bd->query($insercionImg);
        $bd->query($insercionTag);
    }
    /*addEvento('prueba','prueba','prueba','probando','2020-01-03','prueba','prueba2','test');*/
    
    function borrarEvento($id){
        $borradoEv = "DELETE FROM eventos WHERE id = '$id'";
        $borradoImg = "DELETE FROM imagenes WHERE id = '$id'";
        $borradoTag = "DELETE FROM etiquetas WHERE id = '$id'";
        $bd = iniciarConexion();
        if($bd->query($borradoEv) === TRUE){
            /*echo "Borrado evento correctamente";*/
        }
        if($bd->query($borradoImg) === TRUE){
            /*echo "Borrado imagenes correctamente";*/
        }
        if($bd->query($borradoTag) === TRUE){
            /*echo "Borrado tags correctamente";*/
        }
    }
    
    function editarEvento($id, $nombre, $lugar, $organizador, $descripcion, $fecha, $ruta1, $ruta2, $tag, $estado){
        $updateEv = "UPDATE eventos SET nombre = '$nombre', lugar = '$lugar', organizador = '$organizador', descripcion = '$descripcion', fecha = '$fecha', publicado = '$estado' WHERE id = '$id'";
        $updateImg = "UPDATE imagenes SET rutaImagen1 = '$ruta1', rutaImagen2 = '$ruta2' WHERE id = '$id'";
        $updateTag = "UPDATE etiquetas SET tag = '$tag' WHERE id = '$id'";
        $bd = iniciarConexion();
        if($bd->query($updateEv) === TRUE){
            /*echo "Edicion evento hecha correctamente";*/
        }
        if($bd->query($updateImg) === TRUE){
            /*echo "Edicion img hecha correctamente";*/
        }
        if($bd->query($updateTag) === TRUE){
            /*echo "Edicion img hecha correctamente";*/
        }
    }
    /*editarEvento('1', 'Grazalema Sound', 'Grazalema', 'Fox2','El mejor festival de todos', '2021-05-04', 'img/grazalema.jpg', 'img/fest1.jpg');*/

    
    /*####################################################################################################################################*/
    /*#### GESTION USUARIOS ####*/
    /*####################################################################################################################################*/
    
    function insertarUsuario($nickname, $nombre, $apellidos, $email ,$password){
        $insercion = "INSERT INTO usuarios VALUES('".$nickname."' , '".$nombre."' , '".$apellidos."' , '".$email."' , '".password_hash($password, PASSWORD_DEFAULT)."' , '1')";
        
        $bd = iniciarConexion();
        
        $res = $bd->query($insercion);
        /*
        if($res == TRUE){
            echo("Se ha insertado la fila");
        }
        else{
            echo("Error al insertar la fila: \n" .$bd->error);
            echo($insercion);
            echo("<br><br>");
        }
        */
    }
    
    function modificarUsuario($nickname, $nombre, $apellidos, $email, $password){
        $update = "UPDATE usuarios SET nombre = '".$nombre."' , apellidos = '".$apellidos."' , email = '".$email."' , password = '".password_hash($password, PASSWORD_DEFAULT)."' WHERE nickname = '".$nickname."' ";
        $bd = iniciarConexion();
        $res = $bd->query($update);
    }
    
    function verificarUsuario($nickname, $password){
        $datos = obtenerUsuario($nickname);
        
        if(password_verify($password, $datos['password'])){
            /* echo("<br>Iniciada Sesión"); */
            return true;
        }
        else{
            /*echo("<br>Error: Nickname y/o contraseña incorrecta");*/
            return false;
        }
    }
    /* verificarUsuario('califa', 'califato'); */

    
    function obtenerUsuario($nickname){
        $consulta = "SELECT nombre, password, tipo FROM usuarios WHERE nickname = '$nickname'";
        
        $bd = iniciarConexion();

        $res = $bd->query($consulta);
        
        if($res->num_rows > 0){
            $fila = $res->fetch_assoc();
            $password = $fila['password'];
            $tipo = $fila['tipo'];
            
            /* echo("<br>" . $nickname . "<br>Pass: " . $password . "<br>Tipo: " .$tipo); */
        }
        else{
        /*
            echo("Error en la consulta" . $bd->error);
            echo($consulta);
            echo("<br><br>");
        */
        }
        return $fila;
    }
    /* obtenerUsuario('califa'); */
    
    function getTotalUsuarios(){
        $consulta = "SELECT nickname, nombre, apellidos, email, tipo FROM usuarios";
        
        $bd = iniciarConexion();
        
        $res = $bd->query($consulta);
        if($res->num_rows > 0){
            $usuarios = $res->fetch_all();
        }

        return $usuarios;
    }
    
    function cambiarPermisos($nickname, $tipo){

        $update = "UPDATE usuarios SET tipo = '".$tipo."' WHERE nickname = '".$nickname."' ";

        $bd = iniciarConexion();
        
        if(comprobarCambio($nickname) == 'true'){
            $res = $bd->query($update);
        }
        
    }
    
    function comprobarCambio($nickname){
        $consultarTipo = "SELECT tipo FROM usuarios WHERE nickname = '".$nickname."' ";
        $consultarNumSuper = "SELECT COUNT(*) AS total FROM usuarios WHERE tipo = '4'";
        $aceptado = 'false';
        
        $bd = iniciarConexion();
        
        $res = $bd->query($consultarTipo);
        $tipoActual = $res->fetch_object();
        if($tipoActual->tipo == 4){   // Se esta intentando cambiar a un superUsuario
            $res = $bd->query($consultarNumSuper);
            $numSuper = $res->fetch_object();
            if($numSuper->total > 1){    // Si hay mas de un super entonces podemos cambiar su tipo, sino no
                $aceptado = 'true';
            }
        }
        else{
            $aceptado = 'true';
        }
        return $aceptado;
    }
    
    /*####################################################################################################################################*/
    /*#### GESTION COMENTARIOS ####*/
    /*####################################################################################################################################*/
    
    function insertarComentario($idEv, $nombre, $texto){
        $fecha = date("Y/m/d");
        $hora = date("H:i");
    
        $insercion = "INSERT INTO comentarios (idEvento, nombre, fecha, hora, texto) 
        VALUES('".$idEv."' , '".$nombre."' , '".$fecha."' , '".$hora."' , '".$texto."')";
        
        $bd = iniciarConexion();
        
        $res = $bd->query($insercion);
    }
    /*insertarComentario('1', 'Jorge', 'Me encanta!');*/
    
    function getComentarios($idEv){
        $consulta = "SELECT nombre, fecha, hora, texto, idComentario, modificado FROM comentarios WHERE idEvento = '$idEv'";
        
        $bd = iniciarConexion();
        
        $res = $bd->query($consulta);
        if($res->num_rows > 0){
            $comentarios = $res->fetch_all();
        }

        return $comentarios;
    }
    
    function getComentario($idComentario){
        $consulta = "SELECT nombre, fecha, hora, texto FROM comentarios WHERE idComentario = '$idComentario'";
        $bd = iniciarConexion();
        
        $res = $bd->query($consulta);
        if($res->num_rows > 0){
            $comentario = $res->fetch_assoc();
        }
        return $comentario;
    }
    
    function getTotalComentarios(){
        $consulta = "SELECT nombre, fecha, hora, texto, idComentario, modificado FROM comentarios";
        
        $bd = iniciarConexion();
        
        $res = $bd->query($consulta);
        if($res->num_rows > 0){
            $comentarios = $res->fetch_all();
        }

        return $comentarios;
    }
    
    function borrarComentario($id){
        $borrado = "DELETE FROM comentarios WHERE idComentario = '$id'";
        $bd = iniciarConexion();
        if($bd->query($borrado) === TRUE){
            /*echo "Borrado correctamente";*/
        }
    }
    
    function editarComentario($id, $texto){
        $update = "UPDATE comentarios SET texto = '$texto', modificado = true WHERE idComentario = '$id'";
        $bd = iniciarConexion();
        if($bd->query($update) === TRUE){
            /*echo "Edicion hecha correctamente";*/
        }
    }
    

    
?>
