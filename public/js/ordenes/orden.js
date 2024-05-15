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

    $(".orden").on('click', function(e){

        e.preventDefault();

        $("#idPedido").val( $(this).attr('data-id') );
        $("#idOrden").val( $(this).attr('data-id') );

        $(".cobrar").attr('disabled', true);
        $(".eliminar").attr('disabled', true);
        $(".editar").attr('disabled', true);

        $.ajax({

            type: 'POST',
            url: '/orden/consultar',
            data:{

                '_token' : $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#contenedorPlatillos tr").remove();

                var html;
                var total = 0;

                delete respuesta.exito;

                $.each( respuesta, function(i, platillo) {

                    html = '<tr>';
                    html += '<td>'+platillo.cantidad+'</td>';
                    html += '<td>'+platillo.nombrePlatillo+'</td>';

                    if( platillo.nota === '' || platillo.nota === null ){

                        html += '<td class="text-secondary">Sin nota de preparación</td>';

                    }else{

                        html += '<td>'+platillo.nota+'</td>';

                    }

                    html += '<td>$ '+platillo.precioPlatillo+' M.N.</td>';
                    html += '</tr>';

                    total += parseFloat(platillo.precioPlatillo * platillo.cantidad);

                    $("#contenedorPlatillos").append(html);

                });

                $("#contenedorPlatillos").append('<tr class="table-success"><td>Total: </td><td colspan="4">$ '+total+' M.N.</td></tr>');

                $(".cobrar").attr('disabled', false);
                $(".eliminar").attr('disabled', false);
                $(".editar").attr('disabled', false);

            }else{

                Toast.fire({
                    icon: 'error',
                    title: respuesta.mensaje
                });

                $(".cobrar").attr('disabled', true);
                $(".eliminar").attr('disabled', true);
                $(".editar").attr('disabled', true);

            }

        });

    });

});