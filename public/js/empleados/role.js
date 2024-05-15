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

    function empleados(){

        window.location.href = '/empleados';

    }

    //Activación de botón al cambio de valor de select
    $("#rolRole").change(function(){

        $("#role").attr('disabled', false);

    });

    //Actualización de role
    $("#role").on('click', function(e){

        e.preventDefault();
        let procesamiento;

        Swal.fire({

            title: 'Actualizando Rol de Empleado',
            html: 'Espera un poco: <b></b>',
            timer: 9975,
            allowOutsideClick: false,
            didOpen: ()=>{

                $("#role").attr('disabled', true);

                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                procesamiento = setInterval(()=>{

                    b.textContent = Swal.getTimerLeft()

                }, 1000);

                $.ajax({

                    type: 'POST',
                    url: '/empleados/role',
                    data:{

                        '_token' : $("#token").val(),
                        'id' : $("#idEmpleadoRole").val(),
                        'rol' : $("#rolRole").val(),
                        'role' : $("#roleRole").val()

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

                        setTimeout(empleados, 1225);

                    }else{

                        $("#role").attr('disabled', false);

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

                setTimeout(empleados, 1225);

            }

        });

    });

});