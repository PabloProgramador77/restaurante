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

        $("#idCategoriaEditar").val($(this).attr('data-id'));
        $("#categoriaEditar").val('');
        $("#categoriaEditar").attr('disabled', true);
        $("#actualizar").attr('disabled', true);

        $.ajax({

            type: 'POST',
            url: '/categorias/editar',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#categoriaEditar").val('');
                $("#categoriaEditar").attr('disabled', false);
                $("#categoriaEditar").val( respuesta.mensaje );
                $("#actualizar").attr('disabled', false);
                
            }else{

                Toast.fire({
                    icon:'error',
                    title: respuesta.mensaje
                });

                $("#idCategoriaEditar").val('');

            }

        });

    });

    //Modal de Eliminación
    $(".eliminar").on('click', function(){

        $("#idCategoria").val($(this).attr('data-id'));
        $("#eliminar").attr('disabled', true);

        $.ajax({

            type: 'POST',
            url: '/categorias/editar',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#categoriaEliminar").val('');
                $("#categoriaEliminar").val( respuesta.mensaje );
                
            }else{

                Toast.fire({
                    icon:'error',
                    title: respuesta.mensaje
                });

                $("#categoriaEliminar").attr('disabled', true);
                $("#eliminar").attr('disabled', true);
                $("#idCategoria").val('');

            }

        });

    });

    //Modal de Menú
    $(".menu").on('click', function(){

        $("#tituloCategoria").text('');
        $("#idCategoriaMenu").val($(this).attr('data-id'));

        $.ajax({

            type: 'POST',
            url: '/categorias/editar',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#tituloCategoria").text( 'Menú de ' + respuesta.mensaje );

                if( respuesta.platillos.length > 0 ){

                    $("input[type='checkbox'][name='platillo']").prop('checked', false);

                    respuesta.platillos.forEach(function(platillo){

                        $('input[type="checkbox"][name="platillo"][id="'+platillo.nombrePlatillo+'"]').prop('checked', true);

                    });

                }

                $("#menu").attr('disabled', false);
                
            }else{

                Toast.fire({
                    icon:'error',
                    title: respuesta.mensaje
                });

                $("#menu").attr('disabled', true);
                $("#idCategoriaMenu").val('');

            }

        });

    });

});