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

    function cortes(){

        window.location.href = '/cortes';

    }
    
    $("#registrar").on('click', function(e){

        e.preventDefault();

        $("#activar").attr('disabled', true);
        $("#registrar").attr('disabled', true);

        let procesamiento;

        Swal.fire({

            title: 'Registrando Corte de Caja',
            html: 'Un momento por favor. <b></b>',
            timer: 4975,
            allowOutsideClick: false,
            didOpen: ()=>{

                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                procesamiento = setInterval(() => {
                    
                    b.textContent = getTimerLeft()

                }, 1000);

                $.ajax({

                    type: 'POST',
                    url: '/cortes/agregar',
                    data:{

                        '_token' : $("#token").val(),
                        'total' : $("#total").val()

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Toast.fire({
                            icon: 'success',
                            title: respuesta.mensaje
                        });

                        setTimeout(cortes, 2000);

                    }else{

                        Toast.fire({
                            icon: 'error',
                            title: respuesta.mensaje
                        });

                    }

                });

            },
            willClose: ()=>{
                
                clearInterval(procesamiento);

            }

        }).then((resultado)=>{

            if( resultado.dismiss == Swal.DismissReason.timer ){

                Toast.fire({
                    icon: 'info',
                    title: 'Solo un poco más...'
                });

            }

        });

    });

});