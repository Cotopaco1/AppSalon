<h1 class="nombre-pagina">Crear nueva cita</h1>

<?php
include_once __DIR__ . '/../templates/barra.php';
?>
<p class="descripcion-pagina">Elige tus servicios a continuacion</p>

<nav class="tabs">
    <button type="button" data-paso="1">Servicios</button>
    <button type="button" data-paso="2">Informacion cita</button>
    <button type="button" data-paso="3">Resumen</button>
</nav>

<div id="app">

    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuacion</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>
    
    <div id="paso-2" class="seccion formulario">
        <h2>Tus datos y cita</h2>
        <p class="text-center">Coloca tus datos y fecha de tu cita</p>
        <form class="nombre">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $nombre ?>" disabled>
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input type="date" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" id="fecha" name="fecha">
            </div>
            <div class="campo">
                <label for="hora">Hora</label>
                <input type="time" id="hora" name="hora">
            </div>
        </form>
    </div>
    <div id="paso-3" class="seccion">
        
        
    </div>

    <div class="paginacion">
        <button class="boton" id="anterior">&laquo; Anterior </button>
        <button class="boton" id="siguiente"> siguiente &raquo;</button>
        <input type="hidden" id="id" value="<?php echo $id ?>">
    </div>

</div>

<?php $script = "
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script src='build/js/app.js'></script>
 "; ?>