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

    $(".imprimir").attr('disabled', true);

    $(".corte").on('click', function(e){

        e.preventDefault();

        $("#idCorte").val( $(this).attr('data-id') );

        $.ajax({

            type: 'POST',
            url: '/cortes/corte',
            data:{

                '_token' : $("#token").val(),
                'id' : $(this).attr('data-id')

            },
            dataType: 'json',
            encode: true

        }).done(function(respuesta){

            if( respuesta.exito ){

                $("#contenedorPlatillosCorte tr").remove();
    
                var html;
                var total = 0;
    
                delete respuesta.exito;
                
                $.each(respuesta, function(i, platillo){
    
                    html = '<tr>';
                    html += '<td>'+platillo.cantidad+'</td>';
                    html += '<td>'+platillo.nombrePlatillo+'</td>';
                    html += '<td>$ '+parseFloat(platillo.cantidad * platillo.precioPlatillo)+' M.N.</td>';
                    html += '</tr>';
    
                    total += parseFloat(platillo.cantidad * platillo.precioPlatillo);
    
                    $("#contenedorPlatillosCorte").append(html);
    
                });

                $("#contenedorPlatillosCorte").append('<tr><td colspan="3" class="table-success text-center"><b>Total del Corte:</b> $ '+total+' M.N.</td></tr>');

            }else{

                Toast.fire({
                    icon: 'error',
                    title: respuesta.mensaje
                });

                $(".imprimir").attr('disabled', true);
            }

        });

    });

});