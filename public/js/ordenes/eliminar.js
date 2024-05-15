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

    $(".eliminar").on('click', function(e){

        e.preventDefault();

        $(".eliminar").attr('disabled', true);
        $(".cobrar").attr('disabled', true);

        Swal.fire({

            title: '¿En verdad deseas cancelar la orden?',
            showDenyButton: true,
            confirmButtonText: 'Cancelar Orden',
            denyButtonText: 'No cancelar'

        }).then((resultado)=>{

            if( resultado.isConfirmed ){

                let procesamiento;

                Swal.fire({

                    title: 'Cancelando Orden',
                    html: 'Un momento por favor. <b></b>',
                    timer: 4975,
                    allowOutsideClick: false,
                    didOpen: ()=>{

                        Swal.showLoading()
                        const b = Swal.getHtmlContainer().querySelector('b')
                        procesamiento = setInterval(() => {
                            
                            b.textContent = Swal.getTimerLeft()

                        }, 100);

                        $.ajax({

                            type: 'POST',
                            url: '/orden/eliminar',
                            data: {

                                '_token' : $("#token").val(),
                                'id' : $("#idOrden").val()

                            },
                            dataType: 'json',
                            encode: true

                        }).done(function(respuesta){

                            if( respuesta.exito ){

                                Toast.fire({
                                    icon: 'success',
                                    title: respuesta.mensaje
                                });

                                setTimeout(ordenes, 2000);

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

            }else{

                Toast.fire({
                    icon: 'info',
                    title: 'Orden no cancelada.'
                });

            }

        });

    });

});