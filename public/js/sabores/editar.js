$(document).ready(function(){

    //Modal de Edición
    $(".editar").on('click', function(){

        $("#idSaborEditar").val($(this).attr('data-id'));
        $("#saborEditar").val('');
        $("#saborEditar").attr('disabled', true);
        $("#descripcionEditar").val('');
        $("#descripcionEditar").attr('disabled', true);
        $("#actualizar").attr('disabled', true);

        $.ajax({

            type: 'POST',
            url: '/sabores/editar',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#saborEditar").val('');
                $("#saborEditar").attr('disabled', false);
                $("#saborEditar").val( respuesta.sabor );
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

                $("#idSaborEditar").val('');

            }

        });

    });

    //Modal de Eliminación
    $(".eliminar").on('click', function(){

        $("#idSaborEliminar").val($(this).attr('data-id'));
        $("#eliminar").attr('disabled', true);

        $.ajax({

            type: 'POST',
            url: '/sabores/editar',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#saborEliminar").val('');
                $("#saborEliminar").val( respuesta.sabor );
                $("#descripcionEditar").val('');
                $("#descripcionEditar").val( respuesta.descripcion );
                
            }else{

                Swal.fire({
                    icon: 'warning',
                    title: respuesta.mensaje,
                    showConfirmButton: false,
                    timer: 2500
                });

                $("#saborEliminar").attr('disabled', true);
                $("#eliminar").attr('disabled', true);
                $("#idSaborEliminar").val('');

            }

        });

    });

    //Modal de Permisos
    $(".asignar").on('click', function(){

        $("#tituloSabor").text('');
        $("#idSabor").val( $(this).attr('data-id') );

        $.ajax({

            type: 'POST',
            url: '/sabores/editar',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#tituloSabor").text('Platillos de Sabor ' + respuesta.sabor);

                $("input[type=checkbox][name=platillo]").attr('checked', false);

                $.each(respuesta.platillos, function(i, platillo){

                    $('input[type=checkbox][id='+platillo.nombre+']').attr('checked', true);

                });
                
            }else{

                Swal.fire({
                    icon: 'warning',
                    title: respuesta.mensaje,
                    showConfirmButton: false,
                    timer: 2500
                });

                $("#platillos").attr('disabled', true);
                $("#idSabor").val('');

            }

        });

    });

});