<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina"> Iniciar Sesión</p>

<?php
include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="email">E-mail:</label>
        <input type="email"
            name="email"
            id="email"
            placeholder="Tu Email">
    </div>

    <div class="campo">
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" placeholder="Tu Contraseña">
    </div>
    <input type="submit" class="boton" value="Iniciar Sesión">
</form>

<div class="acciones">
    <a href="/crear-cuenta">Aun no tienes una cuenta? Registrate aqui</a>
    <a href="/restablecer">Olvidaste tu Contraseña?</a>

</div>