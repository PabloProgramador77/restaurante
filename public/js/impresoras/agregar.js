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

    $("#registrar").on('click', function(e){

        e.preventDefault();
        let procesamiento;

        Swal.fire({

            title: 'Agregando Impresora',
            html: 'Espera un poco: <b></b>',
            timer: 9975,
            allowOutsideClick: false,
            didOpen: ()=>{

                $("#impresora").attr('disabled', true);
                $("#funcion").attr('disabled', true);
                $("#registrar").attr('disabled', true);

                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                procesamiento = setInterval(()=>{

                    b.textContent = Swal.getTimerLeft()

                }, 1000);

                $.ajax({

                    type: 'POST',
                    url: '/impresoras/agregar',
                    data:{

                        '_token' : $("#token").val(),
                        'impresora' : $("#impresora").val(),
                        'funcion' : $("#funcion").val(),

                    },
                    dataType:'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        $("#impresora").attr('disabled', false);
                        $("#impresora").val('');
                        $("#funcion").attr('disabled', false);
                        $("#registrar").attr('disabled', false);
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Impresora Agregada',
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            timer: 750
                        });

                        window.location.href='/impresoras';

                    }else{

                        $("#impresora").attr('disabled', false);
                        $("#funcion").attr('disabled', false);
                        $("#registrar").attr('disabled', false);

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

                Swal.fire({
                    icon: 'warning',
                    title: 'Hubo un inconveniente. Reiniciando proceso...',
                    allowOutsideClick: false,
                });

                window.location.href='/impresoras';

            }

        });

    });

});