$(document).ready(function(){

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    function impresoras(){

        window.location.href = '/impresoras';

    }

    $("#actualizar").on('click', function(e){

        e.preventDefault();
        let procesamiento;

        Swal.fire({

            title: 'Actualizando impresora',
            html: 'Espera un poco: <b></b>',
            timer: 9975,
            allowOutsideClick: false,
            didOpen: ()=>{

                $("#impresoraEditar").attr('disabled', true);
                $("#funcionEditar").attr('disabled', true);
                $("#actualizar").attr('disabled', true);

                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                procesamiento = setInterval(()=>{

                    b.textContent = Swal.getTimerLeft()

                }, 1000);

                $.ajax({

                    type: 'POST',
                    url: '/impresoras/actualizar',
                    data:{

                        '_token' : $("#token").val(),
                        'impresora' : $("#impresoraEditar").val(),
                        'funcion' : $("#funcionEditar").val(),
                        'id' : $("#idImpresoraEditar").val()

                    },
                    dataType:'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Impresora actualizada',
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            timer: 1500
                        });

                        setTimeout(impresoras, 1500);

                    }else{

                        $("#impresoraEditar").attr('disabled', false);
                        $("#funcionEditar").attr('disabled', false);
                        $("#actualizar").attr('disabled', false);

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
                    icon: 'warning',
                    title: 'Hubo un inconveniente. Reiniciando proceso...'
                });

                setTimeout( impresoras, 3000 );                

            }

        });

    });

});