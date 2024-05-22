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

        $("#idImpresoraEditar").val($(this).attr('data-id'));
        $("#impresoraEditar").val('');
        $("#impresoraEditar").attr('disabled', true);
        $("#funcionEditar").attr('disabled', true);
        $("#actualizar").attr('disabled', true);

        $.ajax({

            type: 'POST',
            url: '/impresoras/editar',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#impresoraEditar").val('');
                $("#impresoraEditar").attr('disabled', false);
                $("#impresoraEditar").val( respuesta.impresora );

                $("#funcionEditar").attr('disabled', false);
                $("#funcionEditar").prepend('<option value="'+respuesta.funcion+'">'+respuesta.funcion+'</option>');
                $("#funcionEditar").val(respuesta.funcion);
                $("#funcionEditar option[value='"+respuesta.funcion+"']:not(:first)").remove();

                $("#actualizar").attr('disabled', false);
                
            }else{

                Toast.fire({
                    icon:'error',
                    title: respuesta.mensaje
                });

                $("#idimpresoraEditar").val('');

            }

        });

    });

    //Modal de Eliminación
    $(".eliminar").on('click', function(){

        $("#idImpresora").val($(this).attr('data-id'));
        $("#eliminar").attr('disabled', true);

        $.ajax({

            type: 'POST',
            url: '/impresoras/editar',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#impresoraEliminar").val('');
                $("#impresoraEliminar").val( respuesta.impresora );
                
            }else{

                Toast.fire({
                    icon:'error',
                    title: respuesta.mensaje
                });

                $("#impresoraEliminar").attr('disabled', true);
                $("#eliminar").attr('disabled', true);
                $("#idImpresora").val('');

            }

        });

    });

    //Modal de Menú
    $(".menu").on('click', function(){

        $("#tituloimpresora").text('');
        $("#idimpresoraMenu").val($(this).attr('data-id'));

        $.ajax({

            type: 'POST',
            url: '/impresoras/prueba',
            data:{

                '_token': $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#tituloimpresora").text( 'Menú de ' + respuesta.mensaje );

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
                $("#idimpresoraMenu").val('');

            }

        });

    });

});