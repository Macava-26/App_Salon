<h1 class="nombre-pagina">Crear cuenta</h1>
<p class="descripcion-pagina"> Llena el siguiente formulario para crear Tu cuenta.</p>




<form class="formulario" method="POST" action="/crear-cuenta">
    <div class="campo">
        <label for="nombre">Nombre:</label>
        <input type="text"
            name="nombre"
            id="nombre"
            placeholder="Tu Nombre">
    </div>
    <div class="campo">
        <label for="apellido">Apellido:</label>
        <input type="text"
            name="apellido"
            id="apellido"
            placeholder="Tu Apellido"
            value="<?php echo s($usuario->nombre); ?>">
    </div>
    <div class="campo">
        <label for="telefono">Télefono:</label>
        <input type="tel"
            name="telefono"
            id="telefono"
            placeholder="Tu Télefono">
    </div>

    <div class="campo">
        <label for="email">E-mail:</label>
        <input type="email"
            name="email"
            id="email"
            placeholder="Tu E-mail">
    </div>

    <div class="campo">
        <label for="password">Contraseña:</label>
        <input type="password"
            name="password"
            id="password"
            placeholder="Tu contraseñad">
    </div>

    <input type="submit" class="boton" value="Crear Cuenta">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/restablecer">Restablecer tu Contraseña?</a>

</div>