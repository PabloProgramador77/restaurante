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

    function mesas(){

        window.location.href = '/mesas';

    }

    $("#registrar").on('click', function(e){

        e.preventDefault();
        let procesamiento;

        Swal.fire({

            title: 'Agregando Mesa',
            html: 'Espera un poco: <b></b>',
            timer: 9975,
            allowOutsideClick: false,
            didOpen: ()=>{

                $("#mesa").attr('disabled', true);
                $("#registrar").attr('disabled', true);

                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                procesamiento = setInterval(()=>{

                    b.textContent = Swal.getTimerLeft()

                }, 1000);

                $.ajax({

                    type: 'POST',
                    url: '/mesas/agregar',
                    data:{

                        '_token' : $("#token").val(),
                        'mesa' : $("#mesa").val()

                    },
                    dataType:'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        $("#mesa").attr('disabled', false);
                        $("#mesa").val('');
                        $("#registrar").attr('disabled', false);
                        
                        Swal.fire({
                            icon: 'success',
                            title: respuesta.mensaje,
                            showConfirmButton: false,
                            timer: 1500
                        });

                        setTimeout(mesas, 1250);

                    }else{

                        $("#mesa").attr('disabled', false);
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

                Toast.fire({
                    icon: 'info',
                    title: 'Solo un poco más...'
                });

            }

        });

    });

});