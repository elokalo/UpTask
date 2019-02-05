
eventListeners();

function eventListeners(){
    document.querySelector('#formulario').addEventListener('submit', validarRegistro);
}

function validarRegistro(e){
    e.preventDefault(); //Evitamos que el formulario se envie por default
    
    let usuario = document.querySelector('#usuario').value;
    let password = document.querySelector('#password').value;
    let tipo = document.querySelector('#tipo').value;

    if(usuario === '' || password === ''){
        //La validacion fallo, utilizamos la libreria de JS de SweetAlert
        swal({
            type: 'error',
            title: 'Error!!',
            text: 'Ambos campos son obligatorios!',
          });
    } else {
       //Ambos campos son correctos, mandar ejecutar AJAX

       //Datos que se envian al servidor
       let datos = new FormData(); //Obtenemos los datos del Form
       datos.append('usuario', usuario);
       datos.append('password', password);
       datos.append('accion', tipo);

       //Creamos el llamado a AJAX

       //Llamado a la conexion al servidor
       let xhr = new XMLHttpRequest();

       //Abrir la conexion al servidor
       xhr.open('POST', 'inc/modelos/modelo-admin.php', true);

       //Retorno de datos del servidor
       xhr.onload = function(){
           if(this.status===200){
               let respuesta = JSON.parse(xhr.responseText);

               //Si la respuesta es 'correcto'
               if(respuesta.respuesta === 'correcto'){
                   //Si es un nuevo usuario
                   if(respuesta.tipo==='crear'){
                    swal({
                        type: 'success',
                        title: 'Usuario Creado!',
                        text: 'El usuario se creó correctamente',
                      });
                   } else if (respuesta.tipo ==='login'){
                    swal({
                        type: 'success',
                        title: 'Login Correcto!',
                        text: 'Presiona OK para abrir el dashboard',
                      })
                      //Redireccionamos a 'index.php'
                      .then(resultado => {
                        if(resultado.value){ //Su valor es 'true'
                            window.location.href = 'index.php';
                        }
                      });
                   } 
                } else if (respuesta.respuesta === 'password_incorrecto'){
                    swal({
                        type: 'error',
                        title: 'Password Incorrecto!',
                        text: 'Contraseña incorrecta, intente de nuevo',
                    });
                }else if (respuesta.error==='usuario_noexiste'){
                        swal({
                            type: 'error',
                            title: 'Login Incorrecto!',
                            text: 'El usuario no existe',
                        });
                } else {
                    //Hubo un error
                    swal({
                        type: 'error',
                        title: 'Error!',
                        text: 'Hubo un error',
                    });
                }
           }
       }

       //Enviamos la peticion
       xhr.send(datos); //Mandamos el FormData
    }
}