$(document).ready(function(){

    $("#permisos").attr('disabled', true);

    var permisos = new Array();

    //Selección de Platillos
    $("input[name=permiso]").on('click', function(){

        if( $(this).is(':checked') == true ){

            permisos.push( $(this).val() );

            if( $("input[name=permiso]:checked").length > 0 ){

                $("#permisos").attr('disabled', false);
    
            }else{
    
                $("#permisos").attr('disabled', true);
    
            }

        }else{

            var indice = permisos.indexOf( $(this).val() );

            permisos.splice( indice, 1 );

            if( $("input[name=permiso]:checked").length > 0 ){

                $("#permisos").attr('disabled', false);
    
            }else{
    
                $("#permisos").attr('disabled', true);
    
            }

        }

        console.log( permisos );

    });

    //Crear Menú de Platillos
    $("#permisos").on('click', function(e){

        e.preventDefault();
        let procesamiento;

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

        $("#permisos").attr('disabled', true);
        $("input[name=permiso]").attr('disabled', true);

        Swal.fire({

            title: 'Asignando Permisos',
            html: 'Un momento por favor. <b></b>',
            timer: 4975,
            allowOutsideClick: false,
            didOpen: ()=>{

                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                procesamiento = setInterval(()=>{

                    b.textContent = Swal.getTimerLeft()

                }, 1000);

                $.ajax({

                    type: 'POST',
                    url: '/roles/permisos',
                    data:{

                        '_token' : $("#token").val(),
                        'idRole' : $("#idRole").val(),
                        'permisos' : permisos

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({
                            icon: 'success',
                            title: respuesta.mensaje,
                            showConfirmButton: false,
                            timer: 1500
                        });

                        setTimeout(roles, 1250);

                    }else{

                        $("#permisos").attr('disabled', true);

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
                    title: 'Ha ocurrido un inconveniente. Reiniciando proceso.'

                });

                setTimeout(roles, 1225);

            }

        });

    });

});