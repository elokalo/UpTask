<?php
include 'inc/funciones/sesiones.php';
include 'inc/funciones/funciones.php';  
include 'inc/templates/header.php';
include 'inc/templates/barra.php';

//Obtener el ID de la URL
    $id_proyecto ="";
    if(isset($_GET['id_proyecto'])){
        $id_proyecto = $_GET['id_proyecto'];
    }
?>

<div class="contenedor">
    
    <?php include 'inc/templates/sidebar.php'; ?>

    <main class="contenido-principal">
        <?php 
            $proyecto = obtenerNombreProyecto($id_proyecto);
            if($proyecto){ ?>
        <h1>Proyecto Actual:
                <?php foreach($proyecto as $nombre){ ?>
                    <span><?php echo $nombre['nombre']; ?></span>
                <?php }//Fin for each ?>
        </h1>

        <form action="#" class="agregar-tarea">
            <div class="campo">
                <label for="tarea">Tarea:</label>
                <input type="text" placeholder="Nombre Tarea" class="nombre-tarea"> 
            </div>
            <div class="campo enviar">
                <input type="hidden" id="id_proyecto" value="<?php echo $id_proyecto; ?>" value="id_proyecto">
                <input type="submit" class="boton nueva-tarea" value="Agregar">
            </div>
        </form>
        <?php  
        } else { //Fin del if '$proyecto'
            //Si no hay proyectos seleccionados
            echo "<h1>Selecciona un proyecto a la izquierda</h1>";
        }
        ?>           
        <h2>Listado de tareas:</h2>

        <div class="listado-pendientes">
            <ul>
                <?php 
                    //Obtiene las tareas del proyecto actual
                    $tareas = obtenerTareasProyecto($id_proyecto);
                if($tareas){ //Verificamos si existe tareas primeramente antes de agregar de forma dinamica
                    if($tareas->num_rows > 0 ){
                        //Si hay tareas
                        foreach($tareas as $tarea): ?>
                            <li id="tarea:<?php echo $tarea['id']; ?>" class="tarea">
                            <p><?php echo $tarea['nombre']; ?></p>
                                <div class="acciones">
                                    <i class="far fa-check-circle <?php echo ($tarea['estado']==='1') ? 'completo' : ''; ?>"></i>
                                    <i class="fas fa-trash"></i>
                                </div>
                            </li>  
                        <?php endforeach; 
                    } else {
                        //No hay tareas
                        echo "<p class='lista-vacia'>No hay tareas en este proyecto</p>";
                    }
                } //Fin del if 'isset'
                ?>
                
            </ul>
        </div>
    </main>
</div><!--.contenedor-->

<?php  
include 'inc/templates/footer.php'; 
?>