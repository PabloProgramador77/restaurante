$(document).ready(function(){

    $("#registrar").attr('disabled', true);
    $("#activar").attr('disabled', true);
    $("#total").val('');

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

    $(".nuevoCorte").on('click', function(e){

        e.preventDefault();

        $.ajax({

            type: 'POST',
            url: '/cortes/calcular',
            data:{
    
                '_token' : $("#token").val(),
    
            },
            dataType: 'json',
            encode: true
    
        }).done(function(respuesta){
    
            if( respuesta.exito ){
    
                $("#contenedorPlatillos tr").remove();
    
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
    
                    $("#contenedorPlatillos").append(html);
    
                });
    
                if( total > 0 ){
    
                    $("#total").val(parseFloat(total));

                    $("#activar").attr('disabled', false);
    
                }
    
            }else{
    
                Toast.fire({
                    icon: 'error',
                    title: respuesta.mensaje
                });
    
            }
    
        });

    });

});