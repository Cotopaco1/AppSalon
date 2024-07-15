<h1 class="nombre-pagina">Nuevo servicio</h1>
<p class="descripcion-pagina">Crea un nuevo servicio para tu tienda</p>

<?php
    include_once __DIR__ . '/../templates/barra.php';
?>
<?php
    include_once __DIR__ . '/../templates/alertas.php';
?>
<form action="/servicios/crear" method="POST" class="formulario">
    <?php include_once __DIR__ . "/formulario.php" ?>

    <input type="submit" value="Crear Servicio" class="boton">
</form>