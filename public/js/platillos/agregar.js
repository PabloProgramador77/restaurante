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

    function platillos(){

        window.location.href = '/platillos';

    }

    $("#registrar").on('click', function(e){

        e.preventDefault();
        let procesamiento;

        Swal.fire({

            title: 'Agregando Platillo',
            html: 'Espera un poco: <b></b>',
            timer: 9975,
            allowOutsideClick: false,
            didOpen: ()=>{

                $("#platillo").attr('disabled', true);
                $("#precio").attr('disabled', true);
                $("#registrar").attr('disabled', true);

                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                procesamiento = setInterval(()=>{

                    b.textContent = Swal.getTimerLeft()

                }, 1000);

                $.ajax({

                    type: 'POST',
                    url: '/platillos/agregar',
                    data:{

                        '_token' : $("#token").val(),
                        'platillo' : $("#platillo").val(),
                        'precio' : $("#precio").val()

                    },
                    dataType:'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        $("#platillo").attr('disabled', false);
                        $("#platillo").val('');
                        $("#precio").attr('disabled', false);
                        $("#precio").val('');
                        $("#registrar").attr('disabled', false);
                        
                        Swal.fire({
                            icon: 'success',
                            title: respuesta.mensaje,
                            showConfirmButton: false,
                            timer: 1500
                        });

                        setTimeout(platillos, 1250);

                    }else{

                        $("#platillo").attr('disabled', false);
                        $("#precio").attr('disabled', false);
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