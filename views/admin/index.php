<h1 class="nombre-pagina">Panel de administracion</h1>
<?php 
include_once __DIR__ . '/../templates/barra.php';
?>

<h2>Buscar citas</h2>
<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha" class="campo">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha ?? '' ?>">
        </div>
    </form>
</div>
<?php
if(count($citas) === 0){
    echo "<h2> No hay citas en esta fecha </h2>";
}
?>
<div id="citas-admin">
    <ul class="citas">

    <?php
    $idCita = 0;
    
    foreach($citas as $key=>$cita){
        
    ?>
      
    <?php
        
        if($idCita !== $cita->id){
            $monto_total = 0;
            ?>
            <li>  
            <p>ID: <span><?php echo $cita->id ?></span></p>
            <p>Hora: <span> <?php echo $cita->hora ?> </span></p>
            <p>Cliente: <span><?php echo $cita->cliente ?></span></p>
            <p>Email: <span><?php echo $cita->email ?></span></p>
            
            <h3>Servicios</h3>
            <?php

            $idCita = $cita->id;
        }
    ?>
    
       <p class="servicio"> <?php echo $cita->servicio ?> </p>
    <?php
        $monto_total += $cita->precio;
        $index = $key;
        $idActual = $cita->id;
        $proximo = $citas[$index +1]->id ?? 0;

        if(esUltimo($idActual, $proximo)){
            ?>
            <p class="total">Total: <span><?php echo $monto_total ?></span></p>

            <form action="/api/eliminar" method="POST">
                <input type="hidden" name="id" value="<?php echo $cita->id ?>">
                <input type="submit" class="boton-eliminar" value="Eliminar"> 
            </form>
            <?php
        };
        
        /* 
        debuguear($proximo->id ==! $cita->id); */
        
    
        }
    
    ?>
    
    </ul>
</div>
  
<?php 
$script = "<script src='build/js/buscador.js'></script>"
 ?>