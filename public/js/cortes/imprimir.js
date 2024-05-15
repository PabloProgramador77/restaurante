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

    $(".imprimir").on('click', function(e){

        e.preventDefault();

        let procesamiento;

        $(".imprimir").attr('disabled', true);

        Swal.fire({

            title: 'Generando Impresión',
            html:'Un momento por favor. <b></b>',
            timer: 9975,
            allowOutsideClick: false,
            didOpen: ()=>{

                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                procesamiento = setInterval(() => {
                    
                    b.textContent = Swal.getTimerLeft()

                }, 1000);

                $.ajax({

                    type: 'POST',
                    url: '/cortes/imprimir',
                    data:{

                        '_token' : $("#token").val(),
                        'id' : $("#idCorte").val()

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({
                            
                            icon: 'success',
                            title: respuesta.mensaje,
                            allowOutsideClick: false,
                            showConfirmButton: true,

                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = '/corte/imprimir/' + $("#idCorte").val();

                            }

                        });

                        

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