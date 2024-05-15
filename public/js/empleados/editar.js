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

        $("#idEmpleadoEditar").val($(this).attr('data-id'));
        $("#nombreEditar").val('');
        $("#nombreEditar").attr('disabled', true);
        $("#emailEditar").val('');
        $("#emailEditar").attr('disabled', true);
        $("#actualizar").attr('disabled', true);

        $.ajax({

            type: 'POST',
            url: '/empleados/editar',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#nombreEditar").val('');
                $("#nombreEditar").attr('disabled', false);
                $("#nombreEditar").val( respuesta.mensaje );
                $("#emailEditar").attr('disabled', false);
                $("#emailEditar").val( respuesta.email );
                $("#actualizar").attr('disabled', false);
                
            }else{

                Toast.fire({
                    icon:'error',
                    title: respuesta.mensaje
                });

                $("#idEmpleadoEditar").val('');

            }

        });

    });

    //Modal de Eliminación
    $(".eliminar").on('click', function(){

        $("#idEmpleadoEliminar").val($(this).attr('data-id'));
        $("#eliminar").attr('disabled', true);

        $.ajax({

            type: 'POST',
            url: '/empleados/editar',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#nombreEliminar").val('');
                $("#nombreEliminar").val( respuesta.mensaje );
                $("#emailEliminar").val( respuesta.email );
                
            }else{

                Toast.fire({
                    icon:'error',
                    title: respuesta.mensaje
                });

                $("#eliminar").attr('disabled', true);
                $("#idEmpleadoEliminar").val('');

            }

        });

    });

    /**Modal de Cambio de Role */
    $(".role").on('click', function(){

        $("#idEmpleadoRole").val( $(this).attr('data-id') );
        $("#role").attr('disabled', true);

        $.ajax({

            type: 'POST',
            url: '/empleados/editar',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#nombreRole").val('');
                $("#nombreRole").val( respuesta.mensaje );
                $("#roleRole").val('');
                $("#roleRole").val(respuesta.rol);
                
            }else{

                Toast.fire({
                    icon:'error',
                    title: respuesta.mensaje
                });

                $("#role").attr('disabled', true);
                $("#idEmpleadoRole").val('');

            }

        });

    });

});