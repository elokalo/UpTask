<?php
//Obtiene la pagina actual que se ejecuta
function obtenerPaginaActual() {
     $archivo = basename($_SERVER['PHP_SELF']);
     $pagina = str_replace(".php", "", $archivo);
     return $pagina;
}

//-------CONSULTAS--------

//Obtener todos los proyetos para mostrarlos en sidebar
//Esta funcion sera de manera estatica a diferencia de utilizar JS con AJAX,por lo que la pagina si se recargara cada vez que eligamos un proyecto,sin embargo esto lo hace mas sencillo y no es absolutamente necesario utilizar AJAX
function obtenerProyectos(){
     include 'conexion-bd.php';
     try {
        return $conn->query('SELECT id, nombre FROM proyectos');
     } catch (Exception $e) {
        echo "Error!: " . $e->getMessage();
        return false;
     }
}

//Obtener el nombre del Proyecto, solo el nombre
function obtenerNombreProyecto($id=null){
    include 'conexion-bd.php';
    try {
       return $conn->query("SELECT nombre FROM proyectos WHERE id={$id}");
    } catch (Exception $e) {
       echo "Error!: " . $e->getMessage();
       return false;
    }
}

//Obtener las tareas del Proyecto
function obtenerTareasProyecto($id=null){
    include 'conexion-bd.php';
    try {
       return $conn->query("SELECT id, nombre, estado FROM tareas WHERE id_proyecto={$id}");
    } catch (Exception $e) {
       echo "Error!: " . $e->getMessage();
       return false;
    }
}
?>