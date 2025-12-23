<h1 class="nombre-pagina"><strong>Agendar Cita</strong></h1>

<?php
    include_once __DIR__ . '/../templates/barra.php';
?>

<div id="app">
    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Datos del Cliente</button>
        <button type="button" data-paso="3">Verificar Datos</button>
    </nav>
    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Lista de servicios: </p>
        <div id="servicios" class="listado-servicios"></div>
    </div>
    <div id="paso-2" class="seccion">
        <h2>Datos del cliente:</h2>

        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre:</label>
                <input
                    id="nombre"
                    type="text"
                    placeholder="Tu nombre"
                    value="<?php echo $nombre  ?>"
                    disabled>
            </div>
            <div class="campo">
                <label for="fecha">Fecha:</label>
                <input
                    id="fecha"
                    type="date"
                    min=<?php echo date('Y-m-d'); ?>>
            </div>
            <div class="campo">
                <label for="hora">Hora:</label>
                <input
                    id="hora"
                    type="time"
                    min="09:50"
                    max="21:00">
            </div>
            <input type="hidden" id='id' value="<?php echo $id; ?>">
        </form>
    </div>
    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Verifica tus Datos</h2>

    </div>
    <div class="paginacion">
        <button
            id="anterior"
            class="boton">
            &laquo; anterior
        </button>
        <button
            id="siguiente"
            class="boton">
            siguiente &raquo;
        </button>
    </div>
</div>

    <?php
        // Apuntar al archivo compilado que está dentro de la carpeta pública (public/build/js/app.js)
        // Usar barras '/' para rutas web y ruta absoluta desde la raíz pública
        $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='/build/js/app.js'></script>
        ";
    ?>