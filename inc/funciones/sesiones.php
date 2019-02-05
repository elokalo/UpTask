<?php 

function usuario_autenticado(){
    if(!revisar_usuario()){
        header('Location:login.php');
        exit();
    }
}

function revisar_usuario(){
    //Revisamos que la sesion exista a traves del nombre de usuario
    return isset($_SESSION['usuario']);
}
//La sesion debemos colocarla en una parte del sitio donde no queramos donde nadie mas entre, es decir en este caso la pagina donde queremos que solo entren usuarios registrados es en 'index.php' 
session_start(); //Arrancamos una sesion
usuario_autenticado();

?>