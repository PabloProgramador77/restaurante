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

        $("#idPlatillo").val($(this).attr('data-id'));
        $("#platilloEditar").val('');
        $("#platilloEditar").attr('disabled', true);
        $("#precioEditar").val('');
        $("#precioEditar").attr('disabled', true);
        $("#actualizar").attr('disabled', true);

        $.ajax({

            type: 'POST',
            url: '/platillos/editar',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#platilloEditar").val('');
                $("#platilloEditar").attr('disabled', false);
                $("#platilloEditar").val( respuesta.nombre );
                $("#precioEditar").val('');
                $("#precioEditar").attr('disabled', false);
                $("#precioEditar").val( respuesta.precio );
                $("#actualizar").attr('disabled', false);
                
            }else{

                Toast.fire({
                    icon:'error',
                    title: respuesta.mensaje
                });

                $("#idPlatillo").val('');

            }

        });

    });

    $(".eliminar").on('click', function(){

        $("#idPlatillo").val($(this).attr('data-id'));
        $("#eliminar").attr('disabled', true);

        $.ajax({

            type: 'POST',
            url: '/platillos/editar',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#platilloEliminar").val('');
                $("#platilloEliminar").val( respuesta.nombre );
                $("#precioEliminar").val('');
                $("#precioEliminar").val( respuesta.precio );
                
            }else{

                Toast.fire({
                    icon:'error',
                    title: respuesta.mensaje
                });

                $("#eliminar").attr('disabled', true);
                $("#idPlatillo").val('');

            }

        });

    });

    $(".platillo").on('click', function(){

        $("#platillo").val('');
        $("#idPlatilloMenu").val( $(this).attr('data-id') );
        $("#ordenar").attr('disabled', true);

        $.ajax({

            type: 'POST',
            url: '/platillos/editar',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#platillo").val('');
                $("#platillo").val( respuesta.nombre );

                $("#ordenar").attr('disabled', false);
                
            }else{

                Toast.fire({
                    icon:'error',
                    title: respuesta.mensaje
                });

                $("#ordenar").attr('disabled', true);
                $("#idPlatilloMenu").val('');

            }

        });        

    });

});