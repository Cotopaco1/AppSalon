<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesion con tus datos</p>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>
<form action="/" method="post" class="formulario">
    <div class="campo">
        <label for="email">Correo</label>
        <input type="email" id="email" placeholder="Tu email" name="user[email]">

    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu password" name="user[password]">
    </div>
    
    <input type="submit" class="boton" value="iniciar sesion">
</form>

<div class="acciones">
    <a href="/crear-cuenta">Aun no tienes una cuenta? crear una</a>
    <a href="/olvide">Olvidaste tu password?</a>
</div>
