<div class="campo">
    <label for="nombre">Nombre Servicio</label>
    <input type="text" id="nombre" placeholder="Nombre Servicio" name="nombre" value="<?php echo $servicio->nombre ?? '' ?>">
</div>
<div class="campo">
    <label for="precio">Precio servicio</label>
    <input type="number" id="precio" placeholder="Precio del servicio" name="precio" value="<?php echo $servicio->precio ?? '' ?>">
</div>