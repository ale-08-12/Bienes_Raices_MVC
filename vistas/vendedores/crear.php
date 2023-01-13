<main class="contenedor seccion">
    <h1>Regristrar Venderor(a)</h1>

    <a class="boton boton-verde" href="/admin">Volver</a>
    
    <?php foreach($errores as $error){ ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php } ?>
    
    <form class="formulario" method="POST" action="/vendedores/crear">
        
        <?php include __DIR__ . "/formulario.php";  ?>

        <input class="boton boton-verde" type="submit" value="Registrar Vendedor(a)">
    </form>
</main>