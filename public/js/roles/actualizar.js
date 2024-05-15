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

    function roles(){

        window.location.href = '/roles';

    }

    $("#actualizar").on('click', function(e){

        e.preventDefault();
        let procesamiento;

        Swal.fire({

            title: 'Actualizando Rol',
            html: 'Espera un poco: <b></b>',
            timer: 9975,
            allowOutsideClick: false,
            didOpen: ()=>{

                $("#rolEditar").attr('disabled', true);
                $("#actualizar").attr('disabled', true);

                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                procesamiento = setInterval(()=>{

                    b.textContent = Swal.getTimerLeft()

                }, 1000);

                $.ajax({

                    type: 'POST',
                    url: '/roles/actualizar',
                    data:{

                        '_token' : $("#token").val(),
                        'rol' : $("#rolEditar").val(),
                        'id' : $("#idRolEditar").val()

                    },
                    dataType:'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){
                        
                        Swal.fire({
                            icon: 'success',
                            title: respuesta.mensaje,
                            showConfirmButton: false,
                            timer: 1500
                        });

                        setTimeout(roles, 1225);

                    }else{

                        $("#rolEditar").attr('disabled', false);
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
                    icon: 'info',
                    title: 'Ocurrio un inconveniente. Reiniciando proceso.'
                });

                setTimeout(roles, 1225);

            }

        });

    });

});