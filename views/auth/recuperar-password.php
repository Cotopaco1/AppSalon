<h1 class="nombre-pagina">Reestablece tu password: </h1>
<p class="descripcion-pagina">A continuacion escribe tu nuevo password: </p>
<?php include_once  __DIR__ .'/../templates/alertas.php' ?>
<?php if($error){
    return;
} ?>
<form class="formulario" method="post">
    <div class="campo">
        <label for="password">Nueva Password</label>
        <input type="password" placeholder="password" name="user[password]" id="password">
    </div>
    
    <input type="submit" class="boton" value="Enviar instrucciones">
</form> 

<div class="acciones">
    <a href="/">Ya te acordaste? inicia sesion</a>
</div>