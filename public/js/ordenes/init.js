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

    $("#terminar").attr('disabled', true);

    $(".orden").on('click', function(){

        $.ajax({

            type: 'POST',
            url: '/orden/ver',
            data:{

                '_token' : $("#token").val()

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if(respuesta.exito){

                $("#contenedorPlatillos tr").remove();

                var html;
                var total = 0;
                delete respuesta.exito;

                $.each(respuesta, function(i, platillo){

                    html = '<tr>';
                    html += '<td>'+platillo.cantidad+'</td>';
                    html += '<td>$ '+platillo.precioPlatillo+' M.N.</td>';
                    html += '<td>'+platillo.nombrePlatillo+'</td>';

                    if( platillo.nota === '' || platillo.nota === null ){

                        html+='<td class="text-secondary">Sin nota de preparación</td>'

                    }else{

                        html += '<td>'+platillo.nota+'</td>';

                    }

                    
                    html += '<td>';
                    html += '<a href="/orden/platillo/borrar/'+platillo.id+'" class="btn btn-danger borrar" role="button" title="Borrar platillo" name="borrar"><i class="fas fa-trash"></i></a>';
                    html += '</td>';
                    html += '</tr>';

                    total += parseFloat(platillo.precioPlatillo * platillo.cantidad);

                    $("#contenedorPlatillos").append(html);

                });

                $("#contenedorPlatillos").append('<tr class="table-success"><td>Total: </td><td colspan="4">$ '+total+' M.N.</td></tr>');

                $("#terminar").attr('disabled', false);

            }else{

                Toast.fire({
                    icon: 'error',
                    title: respuesta.mensaje
                });

                $("#terminar").attr('disabled', true);

            }

        });

    });

});