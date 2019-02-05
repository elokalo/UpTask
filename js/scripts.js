
eventListeners();

//Lista de proyectos
var listaProyectos = document.querySelector('ul#proyectos');

function eventListeners(){
    //Boton para crear proyecto
    document.querySelector('.crear-proyecto a').addEventListener('click', nuevoProyecto);

    let btnNuevaTarea = document.querySelector('.nueva-tarea');
    if(btnNuevaTarea){
        btnNuevaTarea.addEventListener('click', agregarTarea);
    }
    
    //Botones para las acciones de las tareas
    document.querySelector('.listado-pendientes').addEventListener('click', accionesTareas);
}

function nuevoProyecto(e){
    e.preventDefault();
    //Crea un <input> para el nombre del nuevo proyecto
    let nuevoProyecto = document.createElement('li');
    nuevoProyecto.innerHTML ='<input type="text" id="nuevo-proyecto">';
    listaProyectos.appendChild(nuevoProyecto);

    //Selecionamos el ID con el nuevo-proyecto
    let inputNuevoProyecto = document.querySelector('#nuevo-proyecto');

    //Al presionar Enter crear el proyecto
    inputNuevoProyecto.addEventListener('keypress', function(e){
        let tecla = e.which || e.keyCode;
        //El 'which' y el 'keyCode' nos muestra el valor decimal del codigo ASCII de la tecla que presionemos
        if(tecla === 13){
            guardarProyectoDB(inputNuevoProyecto.value);
            listaProyectos.removeChild(nuevoProyecto);
        }
    });
}

function guardarProyectoDB(nombreProyecto){
    //Crear llamado AJAX
    let xhr = new XMLHttpRequest();

    //Enviar datos por FormData
    let datos = new FormData();
    datos.append('proyecto', nombreProyecto);
    datos.append('accion', 'crear');

    //Abrir la conexion
    xhr.open('POST', 'inc/modelos/modelo-proyecto.php', true);

    //En la carga
    xhr.onload = function(){
        if(this.status===200){
            //Obtener datos de la respuesta
            let respuesta = JSON.parse(xhr.responseText);
            let proyecto = respuesta.nombre_proyecto,
                id_proyecto = respuesta.id_proyecto,
                tipo = respuesta.tipo,
                resultado = respuesta.respuesta;

            //Comprobamos la insercion
            if(resultado ==='correcto'){
                //Fue exitoso
                if(tipo==='crear'){
                    //Se creo un nuevo proyecto
                    //Insertamos el HTML
                    let nuevoProyecto = document.createElement('li');
                    nuevoProyecto.innerHTML=`
                        <a href="index.php?id_proyecto=${id_proyecto} id="proyecto:${id_proyecto}">
                            ${proyecto}
                        </a>
                    `;
                    listaProyectos.appendChild(nuevoProyecto);

                    //Enviar alerta de exitoso
                    swal({
                        type: 'success',
                        title: 'Proyecto creado!',
                        text: 'El proyecto: '+ proyecto +' se creó correctamente'
                      })//Redireccionamos a 'index.php?id_proyecto'
                      .then(resultado => {
                        if(resultado.value){ //Su valor es 'true'
                            window.location.href = 'index.php?id_proyecto='+id_proyecto;
                        }
                      });
                } else {
                    //Se actualizo o se elimino
                }
            } else {
                //Hubo un error
                swal({
                    type: 'error',
                    title: 'Error!',
                    text: 'Hubo un error',
                });
            }
        } //Fin del if status
    } //Fin de onload

    //Enviar el Request
    xhr.send(datos);
}

//Agregar una nueva tarea al proyecto actual
function agregarTarea(e){
    e.preventDefault();
    let nombreTarea = document.querySelector('.nombre-tarea').value;

    //Validar que el campo tenga algo escrito
    if(nombreTarea===''){
        swal({
            type: 'error',
            title: 'Error!',
            text: 'Una tarea no puede ir vacía',
        });
    } else {
        //La tarea tiene algo, insertar en PHP

        //Crear llamado a AJAX
        let xhr = new XMLHttpRequest();

        //Creamos el FormData
        let datos = new FormData();
        datos.append('tarea', nombreTarea);
        datos.append('accion', 'crear');
        datos.append('id_proyecto', document.querySelector('#id_proyecto').value);

        //Abrir la conexion
        xhr.open('POST', 'inc/modelos/modelo-tarea.php', true);

        //Ejecutarlo y la respuesta
        xhr.onload= function(){
            if(this.status===200){
                let respuesta = JSON.parse(xhr.responseText);
                let tarea = respuesta.tarea,
                    id_proyecto = respuesta.id_proyecto,
                    tipo = respuesta.tipo,
                    resultado = respuesta.respuesta;
                //Asignar valores
                
                if(resultado==='correcto'){
                    //Se agrego correctamente
                    if(tipo==='crear'){
                        //Lanzamos la alerta de tarea creada
                        swal({
                            type: 'success',
                            title: 'Tarea Creada!',
                            text: 'La tarea: '+ tarea +' se creó correctamente'
                        });

                        //Seleccionar el parrafo con la lista vacia
                        let parrafoListaVacia = document.querySelectorAll('.lista-vacia');

                        if(parrafoListaVacia.length > 0){
                            document.querySelector('.lista-vacia').remove();
                        }

                        //Construir en el template
                        let nuevaTarea = document.createElement('li');

                        //Agregamosel ID
                        nuevaTarea.id = 'tarea:'+id_proyecto;

                        //Agregamos la clase tarea
                        nuevaTarea.classList.add('tarea');

                        //Insertar el HTML
                        nuevaTarea.innerHTML=`
                            <p>${tarea}</p>
                            <div class="acciones">
                                <i class="far fa-check-circle"></i>
                                <i class="fas fa-trash"></i>
                            </div>
                        `;

                        //Agregarlo al HTML/DOM
                        let listadoTareas = document.querySelector('.listado-pendientes ul');
                        listadoTareas.appendChild(nuevaTarea);

                        //Limpiamos el formulario
                        document.querySelector('.agregar-tarea').reset();
                    }
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

        //Enviar la consulta
        xhr.send(datos);
    }
}

//Cambia el estado de las tareas o las elimina

function accionesTareas(e){
    e.preventDefault();

    //Delegation en JavaScript utilizanto 'target'
    if(e.target.classList.contains('fa-check-circle')){
        if(e.target.classList.contains('completo')){
            e.target.classList.remove('completo');
            cambiarEstadoTarea(e.target, 0);
        } else {
            e.target.classList.add('completo');
            cambiarEstadoTarea(e.target, 1);
        }
    } 

    if(e.target.classList.contains('fa-trash')){
        //Alerta con boton de confirmacion
        swal({
            title: '¿Estás Seguro(a)?',
            text: "Esta acción no se puede deshacer!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, borrar!',
            cancelButtonText : 'Cancelar'
          }).then((result) => {
            if (result.value) {

                let tareaEliminar = e.target.parentElement.parentElement;
                //Borrar de la BD
                eliminarTareaBD(tareaEliminar);

                //Borra del HTML
                tareaEliminar.remove();  
              swal(
                'Eliminado!',
                'La tarea fue eliminada.',
                'success'
              )
            }
          })
    } 
}

//Completa o descompleta una tarea
function cambiarEstadoTarea(tarea, estado){
    let idTarea = tarea.parentElement.parentElement.id.split(':');

    //Crear llamado a AJAX
    let xhr = new XMLHttpRequest();

    //Informacion del FormData
    let datos = new FormData();
    datos.append('id', idTarea[1]);
    datos.append('accion', 'actualizar');
    datos.append('estado', estado);

    //Abrir la conexion
    xhr.open('POST','inc/modelos/modelo-tarea.php',true);

    //Cargamos la respuesta
    xhr.onload = function(){
        if(this.status===200){
            JSON.parse(xhr.responseText);
        }
    }

    //Enviamos la peticion
    xhr.send(datos);
}

//Elimina las tareas de la BD
function eliminarTareaBD(tarea){
    let idTarea = tarea.id.split(':');

    //Crear llamado a AJAX
    let xhr = new XMLHttpRequest();

    //Informacion del FormData
    let datos = new FormData();
    datos.append('id', idTarea[1]);
    datos.append('accion', 'eliminar');

    //Abrir la conexion
    xhr.open('POST','inc/modelos/modelo-tarea.php',true);

    //Cargamos la respuesta
    xhr.onload = function(){
        if(this.status===200){
            JSON.parse(xhr.responseText);

            //Comprobar que haya tareas restantes

            let listaTareasRestastes = document.querySelectorAll('li.tarea');
            if(listaTareasRestastes.length === 0){
                document.querySelector('.listado-pendientes ul').innerHTML = "<p class='lista-vacia'>No hay tareas en este proyecto</p>";
            }
        }
    }

    //Enviamos la peticion
    xhr.send(datos)
}