<?php

$accion = $_POST['accion'];
$proyecto = $_POST['proyecto'];

if(isset($accion)){
    if($accion==='crear'){
        
        //Importar la conexion
        include '../funciones/conexion-bd.php';

        try {
            //Realizamos la consulta a la base de datos
            $stmt = $conn->prepare("INSERT INTO proyectos (nombre) VALUES (?)");
            $stmt->bind_param('s', $proyecto);
            $stmt->execute();
            if($stmt->affected_rows){
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'id_proyecto' => $stmt->insert_id,
                    'tipo' => $accion,
                    'nombre_proyecto' => $proyecto
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
}
?>