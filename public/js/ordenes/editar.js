$(document).ready(function(){

    $(".editar").on('click', function(e){

        e.preventDefault();
    
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
    
        function menu(){
    
            window.location.href = '/menu';
    
        }
    
        function ordenes(){
    
            window.location.href = '/ordenes';
    
        }
    
        let procesamiento;
    
        Swal.fire({
    
            title: 'Iniciando Edición',
            html: 'Un momento por favor.',
            timer: 4975,
            allowOutsideClick: false,
            didOpen: ()=>{
    
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                procesamiento = setInterval(()=>{
    
                }, 1000);
    
                $.ajax({
    
                    type: 'POST',
                    url: '/orden/editar',
                    data:{
    
                        '_token' : $("#token").val(),
                        'id' : $("#idOrden").val()
    
                    },
                    dataType: 'json',
                    encode: true
    
                }).done(function(respuesta){
    
                    if( respuesta.exito ){
    
                        Toast.fire({
                            icon: 'info',
                            title: respuesta.mensaje
                        });
    
                        setTimeout(menu, 1275);
    
                    }else{
    
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
                    title: 'Ocurrio un inconveniente. Reiniciando proceso...'
                });
    
                setTimeout(ordenes, 1275);
    
            }
    
        });
    
    });

});