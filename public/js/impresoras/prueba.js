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

    $(".prueba").on('click', function(e){

        e.preventDefault();

        var id = $(this).attr('data-id');

        let procesamiento;

        Swal.fire({

            title: 'Imprimiendo hoja de prueba',
            html: 'Espera un poco: <b></b>',
            timer: 19975,
            allowOutsideClick: false,
            didOpen: ()=>{

                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                procesamiento = setInterval(()=>{

                    b.textContent = Swal.getTimerLeft()

                }, 1000);

                $.ajax({

                    type: 'POST',
                    url: '/impresoras/prueba',
                    data:{

                        '_token' : $("#token").val(),
                        'id' : id

                    },
                    dataType:'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Impresion enviada',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        setTimeout(impresoras, 1500);

                    }else{

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