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

    function ordenes(){

        window.location.href = '/ordenes';

    }

    $("#terminar").on('click', function(e){

        e.preventDefault();

        $("#terminar").attr('disabled', true);

        let procesamiento;

        Swal.fire({

            title: 'Terminando Orden',
            html: 'Un momento por favor. <b></b>',
            timer: 4975,
            allowOutsideClick: false,
            didOpen: ()=>{

                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                procesamiento = setInterval(() => {
                    
                    b.textContent = Swal.getTimerLeft()

                }, 1000);

                $.ajax({

                    type: 'POST',
                    url: '/orden/terminar',
                    data:{

                        '_token' : $("#token").val(),
                        'mesa' : $("#mesa").val()

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        $("#terminar").attr('disabled', false);

                        Swal.fire({

                            icon: 'success',
                            title: respuesta.mensaje,
                            allowOutsideClick: false,
                            showConfirmButton: true,
                        
                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = '/ordenes';

                            }

                        });

                    }else{

                        Toast.fire({
                            icon: 'error',
                            title: respuesta.mensaje
                        });

                        $("#terminar").attr('disabled', false);

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