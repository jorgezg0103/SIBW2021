


var botonC = document.getElementById("botonComentarios"),
    comentarios = document.getElementById("comentarios"),
    main = document.getElementById("main"),
    mostrarC = 0,
    span = document.getElementsByClassName("close")[0];

function desplegar(){

    if(mostrarC == 0){
        comentarios.style.display = "block";
        main.style.marginRight = "1%";
        mostrarC = 1;
        console.log("Comentarios mostrados");
    }
    else{
        comentarios.style.display = "none";
        main.style.marginRight = "15%";
        mostrarC = 0;
        console.log("Comentarios escondidos");
    }

}

botonC.addEventListener("click", desplegar, true);


var botonE = document.getElementById("botonEnviar"),
    nombre = document.getElementById("nombre"),
    fecha = document.getElementById("fecha"),
    hora = document.getElementById("hora"),
    comentario = document.getElementById("comentario"),
    hayElementoEmail = 0,
    denegarEnvio = 0,
    formulario = document.getElementById("formulario"),
    modal = document.getElementById("dialogoError");

    let malsonantes = ["puta", "puto", "gilipollas", "tonto", "tonta", "retrasado", "retrasada", "imbecil"];
    let emails = ["@correo.es", "@correo.com", "@gmail.com", "@hotmail.com", "@ugr.es",];
    

function obtenerDatos(){
    
    // Campos vacios
    if(formulario.nombreF.value === "" || formulario.email.value === "" || formulario.texto.value === ""){
        denegarEnvio = 1;
        console.log("Error: Hay al menos un campo vacio")
    }

    // Comprobar email
    emails.forEach(function(palabra) {
        if( formulario.email.value.indexOf(palabra) > -1 ){
            hayElementoEmail = 1;
        }
        
    })
    if(hayElementoEmail === 0){
        denegarEnvio = 1;
        console.log("Error: No hay elemento email")
    }
    hayElementoEmail = 0;

    // Palabras malsonantes
    malsonantes.forEach(function(palabra) {

        if( formulario.texto.value.indexOf(palabra) > -1 ){
            
            // Hace una var con el mismo num de * que de letras tiene el malsonante
            var asteriscos = "";
            for (var i = 0; i < palabra.length; i++) {
                asteriscos += "*";
            }

            // Reemplazamos
            var textoLimpio = formulario.texto.value.replace(new RegExp(palabra, "g"), asteriscos);
            formulario.texto.value = textoLimpio;
 
        }

    })

    // Cambiar datos por defecto a los enviados
    if(denegarEnvio === 0){

        var hoy = new Date();

        nombre.innerHTML = formulario.nombreF.value;
        fecha.innerHTML = hoy.getDate() + "/" + (hoy.getMonth() + 1) + "/" + hoy.getFullYear();
        hora.innerHTML =  hoy.getHours() + ":" + hoy.getMinutes();
        comentario.innerHTML = formulario.texto.value;

        console.log("Datos cambiados correctamente")

    }
    else{

        modal.style.display = "block";
        modalEnPantalla = 1;

    }
    denegarEnvio = 0;

}

botonE.addEventListener("click", obtenerDatos, true);

span.onclick = function() {
    modal.style.display = "none";
}





