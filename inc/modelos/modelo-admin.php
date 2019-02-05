<?php

$accion = $_POST['accion'];
$password = $_POST['password'];
$usuario = $_POST['usuario'];

if(isset($accion)){
    if($accion==='crear'){
        //Codigo para crear los administradores
        /*Hashear passwords, esto hace que no se guarden las contraseñas tal cual en la
        base de datos si no que se puedan guardar como un 'hash' encriptado mediante PHP
        Entre mas 'costo' otorguemos mas caracteres se mostraran en el 'hash', en el caso de
        'cost'=12 va a 'haseharlo' y encriptarlo con 60 caracteres*/
        $opciones =array(
            'cost' => 12
        );

        $hash_password= password_hash($password, PASSWORD_BCRYPT, $opciones);

        //Importar la conexion
        include '../funciones/conexion-bd.php';

        try {
            //Realizamos la consulta a la base de datos
            $stmt = $conn->prepare("INSERT INTO usuarios (usuario,password) VALUES (?,?)");
            $stmt->bind_param('ss', $usuario, $hash_password);
            $stmt->execute();
            /*
            $respuesta = array(
                'respuesta' => $stmt->affected_rows, //Si es 1, se agrego un registro correctamente
                'error' => $stmt->error,
                'error_list' => $stmt->error_list
            );
            //Con este codigo verificamos si existe algun error
            */
            if($stmt->affected_rows){
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'id_insertado' => $stmt->insert_id,
                    'tipo' => $accion
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

    if($accion === 'login'){
        //Codigo para logear a los administradores
        include '../funciones/conexion-bd.php';

        try {
            //Seleccionamos el usuario para acceder a la BD
            $stmt = $conn->prepare('SELECT usuario, id, password FROM usuarios WHERE usuario=?');
            $stmt->bind_param('s', $usuario);
            $stmt->execute();
            //Logear el usuario
            $stmt->bind_result($nombre_usuario, $id_usuario, $password_usuario); //Hacemos la consulta a la BD asignamos a los 3 campos de la tabla, 3 variables para poder manipular los datos
            $stmt->fetch(); //Traemos los resultados

            if($nombre_usuario){
                //El usuario existe verificamos el password con la funcion password_verify
                if(password_verify($password, $password_usuario)){
                    //Iniciar la sesion
                    session_start();
                    $_SESSION['usuario'] = $usuario;
                    $_SESSION['id'] = $id_usuario;
                    $_SESSION['login'] = true; 
                    //Login correcto
                    $respuesta = array(
                        'respuesta' => 'correcto',
                        'nombre' => $nombre_usuario,
                        'tipo' => $accion
                    );
                } else {
                    //Login incorrecto, enviar error
                    $respuesta = array(
                        'respuesta' => 'password_incorrecto'
                    );
                }
                /*$respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre' => $nombre_usuario,
                    'id' => $id_usuario,
                    'pass' => $password_usuario
                );*/
            } else {
                $respuesta = array(
                    'error' => 'usuario_noexiste'
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
    }
}



