$(document).ready(function(){

    $('.borrar').on('click', function(){

        var id = $(this).attr('id');

        console.log( id );

        $.ajax({

            type: 'POST',
            url: '/orden/platillo/borrar',
            data:{

                'token' : $("#token").val(),
                'id' : id,

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                Swal.fire({
                    icon: 'success',
                    title: 'Platillo Borrado',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });

                window.location.href = '/menu';

            }else{

                Swal.fire({
                    icon: 'success',
                    title: respuesta.mensaje,
                    allowOutsideClick: false,
                    showConfirmButton: true,
                });

            }

        });

    });

});