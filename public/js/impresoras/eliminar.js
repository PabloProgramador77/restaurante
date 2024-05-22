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

    function impresoras(){

        window.location.href = '/impresoras';

    }

    $("#eliminar").on('click', function(e){

        e.preventDefault();
        let procesamiento;

        $("#eliminar").attr('disabled', true);

        Swal.fire({

            title: 'Borrando Datos de impresora',
            html: 'Espera un poco: <b></b>',
            timer: 9975,
            allowOutsideClick: false,
            didOpen: ()=>{

                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                procesamiento = setInterval(()=>{

                    b.textContent = Swal.getTimerLeft()

                }, 1000);

                $.ajax({

                    type: 'POST',
                    url: '/impresoras/eliminar',
                    data:{

                        '_token' : $("#token").val(),
                        'id' : $("#idImpresora").val()

                    },
                    dataType:'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Impresora eliminada',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        setTimeout(impresoras, 1225);

                    }else{

                        $("#eliminar").attr('disabled', false);

                        Toast.fire({
                            icon:'error',
                            title: respuesta.mensaje
                        });

                    }

                });

            },
            willClose: ()=>{

                clearInterval(procesamiento);

            }

        }).then((resultado)=>{

            if(resultado.dismiss == Swal.DismissReason.timer){

                Toast.fire({
                    icon: 'info',
                    title: 'Hubo un inconveniente. Reiniciando procedimiento...'
                });

                setTimeout( impresoras, 1500 );

            }

        });

    });

});