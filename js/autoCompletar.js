 
function mostrarEventos(datos){
    $("#listaEventos").fadeIn();
    $("#listaEventos").html(datos);
}

function ocultarEventos(){
    $("#listaEventos").fadeOut();
}

function pulsarTecla(){
    
    var consulta = $(this).val();
    
    if(consulta != '' && consulta.length > 1){
        configuracion = {
            url: "search.php",
            method: "POST",
            data: {consulta: consulta},
            success: mostrarEventos        
        };
        $.ajax(configuracion);
    }
    else{
        ocultarEventos();
    }
    
    $(document).on('click', 'li', function(){
        $('#evento').val($(this).text());
        ocultarEventos();
    });
    
    
}

function cargarDatos(){
    $('#evento').keyup(pulsarTecla);
}

$(document).ready(cargarDatos);
