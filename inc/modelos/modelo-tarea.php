<?php
$accion = $_POST['accion'];
//if(isset($_POST['accion'])){
    if($accion==='crear'){ 

        $id_proyecto = (int) $_POST['id_proyecto'];
        $tarea = $_POST['tarea'];

        //Importar la conexion
        include '../funciones/conexion-bd.php';

        try {
            //Realizamos la consulta a la base de datos
            $stmt = $conn->prepare("INSERT INTO tareas (nombre, id_proyecto) VALUES (?,?)");
            $stmt->bind_param('si', $tarea, $id_proyecto);
            $stmt->execute();
            if($stmt->affected_rows){
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'id_proyecto' => $stmt->insert_id,
                    'tipo' => $accion,
                    'tarea' => $tarea
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error'
                );
            }
            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            //En el caso de un error, tomar una excepcion
            $respuesta = array(
                'error' => $e->getMessage()
            );
        }

        echo (json_encode($respuesta));
    
    } //Fin if crear

    if($accion==='actualizar'){

        $estado = $_POST['estado'];
        $id_tarea = (int) $_POST['id'];
 
        //Importar la conexion
        include '../funciones/conexion-bd.php';

        try {
            //Realizamos la consulta a la base de datos
            $stmt = $conn->prepare("UPDATE tareas SET estado = ? WHERE id=?");
            $stmt->bind_param('ii', $estado, $id_tarea);
            $stmt->execute();
            if($stmt->affected_rows){
                $respuesta = array(
                    'respuesta' => 'correcto'
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error'
                );
            }
            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            //En el caso de un error, tomar una excepcion
            $respuesta = array(
                'error' => $e->getMessage()
            );
        }

        echo (json_encode($respuesta));
    } //Fin if actualizar

    if($accion==='eliminar'){

        $id_tarea = (int) $_POST['id'];

        //Importar la conexion
        include '../funciones/conexion-bd.php';

        try {
            //Realizamos la consulta a la base de datos
            $stmt = $conn->prepare("DELETE FROM tareas WHERE id=?");
            $stmt->bind_param('i', $id_tarea);
            $stmt->execute();
            if($stmt->affected_rows){
                $respuesta = array(
                    'respuesta' => 'correcto'
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error'
                );
            }
            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            //En el caso de un error, tomar una excepcion
            $respuesta = array(
                'error' => $e->getMessage()
            );
        }

        echo (json_encode($respuesta));
    } //Fin if eliminar
//} //Fin del if ('isset')
?>