$(document).ready(function(){

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    $(".editar").on('click', function(){

        $("#idMesa").val($(this).attr('data-id'));
        $("#mesaEditar").val('');
        $("#mesaEditar").attr('disabled', true);
        $("#actualizar").attr('disabled', true);

        $.ajax({

            type: 'POST',
            url: '/mesas/editar',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#mesaEditar").val('');
                $("#mesaEditar").attr('disabled', false);
                $("#mesaEditar").val( respuesta.mensaje );
                $("#actualizar").attr('disabled', false);
                
            }else{

                Toast.fire({
                    icon:'error',
                    title: respuesta.mensaje
                });

                $("#idMesa").val('');

            }

        });

    });

    $(".eliminar").on('click', function(){

        $("#idMesa").val($(this).attr('data-id'));
        $("#eliminar").attr('disabled', true);

        $.ajax({

            type: 'POST',
            url: '/mesas/editar',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#mesaEliminar").val('');
                $("#mesaEliminar").val( respuesta.mensaje );
                
            }else{

                Toast.fire({
                    icon:'error',
                    title: respuesta.mensaje
                });

                $("#mesaEliminar").attr('disabled', true);
                $("#eliminar").attr('disabled', true);
                $("#idMesa").val('');

            }

        });

    });

});