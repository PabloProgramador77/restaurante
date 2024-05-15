$(document).ready(function(){

    $("#menu").attr('disabled', true);

    var platillos = new Array();

    //Selección de Platillos
    $("input[name=platillo]").on('click', function(){

        if( $(this).is(':checked') == true ){

            platillos.push( $(this).val() );

            if( $("input[name=platillo]:checked").length > 0 ){

                $("#menu").attr('disabled', false);
    
            }else{
    
                $("#menu").attr('disabled', true);
    
            }

        }else{

            var indice = platillos.indexOf( $(this).val() );

            platillos.splice( indice, 1 );

            if( $("input[name=platillo]:checked").length > 0 ){

                $("#menu").attr('disabled', false);
    
            }else{
    
                $("#menu").attr('disabled', true);
    
            }

        }

        console.log( platillos );

    });

    //Crear Menú de Platillos
    $("#menu").on('click', function(e){

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

        function categorias(){

            window.location.href = '/categorias';

        }

        $("#menu").attr('disabled', true);
        $("input[name=platillo]").attr('disabled', true);

        Swal.fire({

            title: 'Creando Menú',
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
                    url: '/categorias/menu',
                    data:{

                        '_token' : $("#token").val(),
                        'idCategoria' : $("#idCategoriaMenu").val(),
                        'platillos' : platillos

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

                        setTimeout(categorias, 1250);

                    }else{

                        $("#menu").attr('disabled', true);

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
                    title: 'Solo un poco mas..'

                });

            }

        });

    });

});