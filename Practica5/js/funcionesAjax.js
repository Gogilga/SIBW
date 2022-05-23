$(document).ready(function() {
    $('#busqueda').on('keyup', function() {
        var key = $(this).val();
        var dataString = 'key='+key;

        var usuario= $('#tipoUsuario').text();

        if(dataString.length > 4){
            $.ajax({
                type: "POST",
                url: "buscarAjax.php",
                data: dataString,
                success: function(data){
                    //Escribimos las sugerencias que nos manda la consulta
                    $('#sugerencias').fadeIn(1000).html(data);
                    procesaRespuestaAjax(data,usuario);
                    //console.log(data);
                }
            });
        }
    });
}); 

function procesaRespuestaAjax(respuesta,usuario) {
    res = "";

    for (i = 0 ; i < respuesta.length ; i++){
        //console.log(respuesta[i].id)
        if(usuario == '1' && respuesta[i].publicado == '0'){
            res += "<div><a href='producto.php?ev="+ respuesta[i].id +"' class='sugerencia-element' data=" + respuesta[i].nombre + " id=" + respuesta[i].id + ">" + respuesta[i].nombre + " -- <i>No publicado</i></a></div>"
        }else if(respuesta[i].publicado == '1'){
            res += "<div><a href='producto.php?ev="+ respuesta[i].id +"' class='sugerencia-element' data=" + respuesta[i].nombre + " id=" + respuesta[i].id + ">" + respuesta[i].nombre + "</a></div>"
        }
        
    }
    
    $("#sugerencias").html(res);
}
