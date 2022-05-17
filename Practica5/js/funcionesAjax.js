$(document).ready(function() {
    $('#busqueda').on('keyup', function() {
        var key = $(this).val();
        var dataString = 'key='+key;

        if(dataString.length > 4){
            $.ajax({
                type: "POST",
                url: "buscarAjax.php",
                data: dataString,
                success: function(data){
                    //Escribimos las sugerencias que nos manda la consulta
                    $('#sugerencias').fadeIn(1000).html(data);
                    procesaRespuestaAjax(data);
                    console.log(data);
                }
            });
        }
    });
}); 

function procesaRespuestaAjax(respuesta) {
    res = "";

    for (i = 0 ; i < respuesta.length ; i++){
        res += "<div><a class='sugerencia-element' data=" + respuesta[i].nombre + " id=" + respuesta[i].id + ">" + respuesta[i].nombre + "</a></div>"
    }
    
    $("#sugerencias").html(res);
}
