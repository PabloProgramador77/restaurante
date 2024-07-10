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

                if( respuesta.sabores.length > 0 ){

                    var filas = '<p class="col-lg-12 col-md-12 col-sm-12 p-2 border-bottom"><b>Sabor(es) disponible(s)</b></p>';

                    respuesta.sabores.forEach(function(sabor){

                        filas += '<div class="col-lg-4 col-md-6 col-sm-12">'+
                                    '<label for="'+sabor.id+'">'+sabor.nombre+'</label>'+
                                    '<input class="custom-control" type="checkbox" name="sabor" id="'+sabor.id+'" value="'+sabor.nombre+'">'+
                                '</div>';

                    });

                    $("#contenedorSabores").empty().append( filas );

                }else{

                    var filas = '<p class="col-lg-12 col-md-12 col-sm-12 p-2 border-bottom"><b>Sabor(es) disponible(s)</b></p>';

                    filas += '<p class="text-center text-danger fw-semibold p-2 bg-light">Sin sabores</p>';

                    $("#contenedorSabores").empty().append( filas );

                }

                if( respuesta.aderezos.length > 0 ){

                    var filas = '<p class="col-lg-12 col-md-12 col-sm-12 p-2 border-bottom"><b>Aderezo(s) disponible(s)</b></p>';

                    respuesta.aderezos.forEach(function(aderezo){

                        filas += '<div class="col-lg-4 col-md-6 col-sm-12">'+
                                    '<label for="'+aderezo.id+'">'+aderezo.nombre+'</label>'+
                                    '<input class="custom-control" type="checkbox" name="aderezo" id="'+aderezo.id+'" value="'+aderezo.nombre+'">'+
                                '</div>';

                    });

                    $("#contenedorAderezos").empty().append( filas );

                }else{

                    var filas = '<p class="col-lg-12 col-md-12 col-sm-12 p-2 border-bottom"><b>Aderezo(s) disponible(s)</b></p>';

                    filas += '<p class="text-center text-danger fw-semibold p-2 bg-light">Sin aderezos</p>';

                    $("#contenedorAderezos").empty().append( filas );

                }

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