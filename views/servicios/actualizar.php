<h1 class="nombre-pagina">Actualizar servicio</h1>
<p class="descripcion-pagina">Llena el formulario para actualizar el registro</p>

<?php
    include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form method="POST">
    <?php include_once __DIR__ . '/formulario.php' ?>
    <input type="hidden" name="id" value="<?php echo $servicio->id ?>">
    <input type="submit" value="Actualizar" class="boton">
</form>