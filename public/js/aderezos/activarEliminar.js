$(document).ready(function(){

    $("#eliminar").attr('disabled', true);

    $("#borrar").on('click', function(){

        if( $("#borrar").is(':checked') ){

            $("#eliminar").attr('disabled', false);

        }else{

            $("#eliminar").attr('disabled', true);

        }
        
    });

});