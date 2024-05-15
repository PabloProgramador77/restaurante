$(document).ready(function(){

    $("#registrar").attr('disabled', true);

    $("#activar").on('click', function(){

        if( $("#activar").is(':checked') ){

            $("#registrar").attr('disabled', false);

        }else{

            $("#registrar").attr('disabled', true);

        }
        
    });

});