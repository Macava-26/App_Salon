<h1 class="nombre-pagina">Restablecer contraseña</h1>
<p class="descripcion-pagina"> Introduzca la dirección de correo electrónico
    para Recuperar su Contraseña</p>

<?php
include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" method="POST" action="/restablecer">
    <div class="campo">
        <label for="email">E-mail:</label>
        <input type="email"
            name="email"
            id="email"
            placeholder="Tu Email">
    </div>

<input type="submit" class="boton" value="Restablecer Constraseña ">

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">Aun no tienes una cuenta? Registrate aqui</a>
</div>