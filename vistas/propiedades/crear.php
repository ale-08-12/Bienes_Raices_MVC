<main class="contenedor seccion">
    <h1>Crear</h1>

    <?php foreach($errores as $error){ ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php } ?>

    <a class="boton boton-verde" href="/admin">Volver</a>

    <form class="formulario" method="POST" enctype="multipart/form-data" action="/propiedades/crear">
        <?php include __DIR__ . "/formulario.php"; ?>

        <input class="boton boton-verde" type="submit" value="Crear Propiedad">
    </form>
</main>