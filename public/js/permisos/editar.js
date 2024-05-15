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

    //Modal de Edición
    $(".editar").on('click', function(){

        $("#idPermisoEditar").val($(this).attr('data-id'));
        $("#permisoEditar").val('');
        $("#permisoEditar").attr('disabled', true);
        $("#actualizar").attr('disabled', true);

        $.ajax({

            type: 'POST',
            url: '/permisos/editar',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#permisoEditar").val('');
                $("#permisoEditar").attr('disabled', false);
                $("#permisoEditar").val( respuesta.permiso );
                $("#actualizar").attr('disabled', false);
                
            }else{

                Toast.fire({
                    icon:'error',
                    title: respuesta.mensaje
                });

                $("#idPermisoEditar").val('');

            }

        });

    });

    //Modal de Eliminación
    $(".eliminar").on('click', function(){

        $("#idPermisoEliminar").val($(this).attr('data-id'));
        $("#eliminar").attr('disabled', true);

        $.ajax({

            type: 'POST',
            url: '/permisos/editar',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#permisoEliminar").val('');
                $("#permisoEliminar").val( respuesta.permiso );
                
            }else{

                Toast.fire({
                    icon:'error',
                    title: respuesta.mensaje
                });

                $("#permisoEliminar").attr('disabled', true);
                $("#eliminar").attr('disabled', true);
                $("#idPermisoEliminar").val('');

            }

        });

    });

});