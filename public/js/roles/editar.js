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

        $("#idRolEditar").val($(this).attr('data-id'));
        $("#rolEditar").val('');
        $("#rolEditar").attr('disabled', true);
        $("#actualizar").attr('disabled', true);

        $.ajax({

            type: 'POST',
            url: '/roles/editar',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#rolEditar").val('');
                $("#rolEditar").attr('disabled', false);
                $("#rolEditar").val( respuesta.rol );
                $("#actualizar").attr('disabled', false);
                
            }else{

                Toast.fire({
                    icon:'error',
                    title: respuesta.mensaje
                });

                $("#idRolEditar").val('');

            }

        });

    });

    //Modal de Eliminación
    $(".eliminar").on('click', function(){

        $("#idRolEliminar").val($(this).attr('data-id'));
        $("#eliminar").attr('disabled', true);

        $.ajax({

            type: 'POST',
            url: '/roles/editar',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#rolEliminar").val('');
                $("#rolEliminar").val( respuesta.rol );
                
            }else{

                Toast.fire({
                    icon:'error',
                    title: respuesta.mensaje
                });

                $("#rolEliminar").attr('disabled', true);
                $("#eliminar").attr('disabled', true);
                $("#idRolEliminar").val('');

            }

        });

    });

    //Modal de Permisos
    $(".asignar").on('click', function(){

        $("#tituloRole").text('');
        $("#idRole").val( $(this).attr('data-id') );

        $.ajax({

            type: 'POST',
            url: '/roles/editar',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#tituloRole").text('Permisos de ' + respuesta.rol);

                $("input[type=checkbox][name=permiso]").attr('checked', false);

                $.each(respuesta.permisos, function(i, permiso){

                    $('input[type=checkbox][id='+permiso.name+']').attr('checked', true);

                });
                
            }else{

                Toast.fire({
                    icon:'error',
                    title: respuesta.mensaje
                });

                $("#permisos").attr('disabled', true);
                $("#idRole").val('');

            }

        });

    });

});