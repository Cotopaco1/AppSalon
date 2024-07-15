<h1 class="nombre-pagina">Recupera tu password</h1>
<p class="descripcion-pagina">restablece tu password escribiendo tu email a continuacion</p>

<?php include_once  __DIR__ .'/../templates/alertas.php' ?>

<form action="/olvide" class="formulario" method="post">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" placeholder="email" name="user[email]" id="email">
    </div>
    
    <input type="submit" class="boton" value="Enviar instrucciones">
</form> 

<div class="acciones">
    <a href="/">Regresar para Iniciar una cuenta</a>
    <a href="/crear-cuenta">Aun no tienes una cuenta? crear una</a>
</div>