<h1 class="nombre-pagina">Crea una cuenta</h1>
<p class="descripcion-pagina"> Llena el siguiente formulario para crear una cuenta</p>

<?php include_once  __DIR__ .'/../templates/alertas.php' ?>

<form action="/crear-cuenta" method="post" class="formulario">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" placeholder="Tu nombre" name="usuario[nombre]" value="<?php echo s($usuario->nombre) ?>">
    </div>
    <div class="campo">
        <label for="apellido">apellido</label>
        <input type="text" id="apellido" placeholder="Tu apellido" name="usuario[apellido]" value="<?php echo s($usuario->apellido) ?>">
    </div>
    <div class="campo">
        <label for="telefono">telefono</label>
        <input type="tel" id="telefono" placeholder="Tu telefono" name="usuario[telefono]" value="<?php echo s($usuario->telefono) ?>">
    </div>
   
    <div class="campo">
        <label for="email">Correo</label>
        <input type="email" id="email" placeholder="Tu email" name="usuario[email]" value="<?php echo s($usuario->email) ?>">

    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu password" name="usuario[password]" >
    </div>

    <input type="submit" class="boton" value="crear Cuenta">
</form>
<div class="acciones">
    <a href="/">Regresar para Iniciar una cuenta</a>
    <a href="/olvide">Olvidaste tu password?</a>
</div>