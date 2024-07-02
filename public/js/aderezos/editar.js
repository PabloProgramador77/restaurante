$(document).ready(function(){

    //Modal de Edición
    $(".editar").on('click', function(){

        $("#idAderezoEditar").val($(this).attr('data-id'));
        $("#aderezoEditar").val('');
        $("#aderezoEditar").attr('disabled', true);
        $("#descripcionEditar").val('');
        $("#descripcionEditar").attr('disabled', true);
        $("#actualizar").attr('disabled', true);

        $.ajax({

            type: 'POST',
            url: '/aderezos/editar',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#aderezoEditar").val('');
                $("#aderezoEditar").attr('disabled', false);
                $("#aderezoEditar").val( respuesta.aderezo );
                $("#descripcionEditar").val('');
                $("#descripcionEditar").attr('disabled', false);
                $("#descripcionEditar").val( respuesta.descripcion );
                $("#actualizar").attr('disabled', false);
                
            }else{

                Swal.fire({
                    icon: 'warning',
                    title: respuesta.mensaje,
                    showConfirmButton: false,
                    timer: 2500
                });

                $("#idAderezoEditar").val('');

            }

        });

    });

    //Modal de Eliminación
    $(".eliminar").on('click', function(){

        $("#idAderezoEliminar").val($(this).attr('data-id'));
        $("#eliminar").attr('disabled', true);

        $.ajax({

            type: 'POST',
            url: '/aderezos/editar',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#aderezoEliminar").val('');
                $("#aderezoEliminar").val( respuesta.aderezo );
                $("#descripcionEliminar").val('');
                $("#descripcionEliminar").val( respuesta.descripcion );
                
            }else{

                Swal.fire({
                    icon: 'warning',
                    title: respuesta.mensaje,
                    showConfirmButton: false,
                    timer: 2500
                });

                $("#aderezoEliminar").attr('disabled', true);
                $("#eliminar").attr('disabled', true);
                $("#idAderezoEliminar").val('');

            }

        });

    });

    //Modal de Permisos
    $(".asignar").on('click', function(){

        $("#tituloaderezo").text('');
        $("#idAderezo").val( $(this).attr('data-id') );

        $.ajax({

            type: 'POST',
            url: '/aderezos/editar',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#tituloaderezo").text('Platillos con aderezo ' + respuesta.aderezo);

                $("input[type=checkbox][name=platillo]").attr('checked', false);

                $.each(respuesta.platillos, function(i, platillo){

                    $('input[type=checkbox][value='+platillo.id+']').attr('checked', true);

                });
                
            }else{

                Swal.fire({
                    icon: 'warning',
                    title: respuesta.mensaje,
                    showConfirmButton: false,
                    timer: 2500
                });

                $("#asignar").attr('disabled', true);
                $("#idAderezo").val('');

            }

        });

    });

});