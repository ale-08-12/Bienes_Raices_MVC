<main class="contenedor seccion">
    <h1 data-cy="heading-contacto">Contacto</h1>

    <?php
        if($mensaje){
            if($enviado){ ?>
                <p class="alerta exito" data-cy="alerta-exito-formulario"><?php echo sanitizar($mensaje); ?></p>
    <?php   }else{ ?>
                <p class="alerta error"><?php echo sanitizar($mensaje); ?></p>
    <?php   }}?>
    
    <picture>
        <source srcset="build/img/destacada3.webp" type="image/webp">
        <source srcset="build/img/destacada3.jpg" type="image/jpeg">
        <img loading="lazy" src="build/img/destacada3.jpg" alt="Imagen contacto">
    </picture>

    <h2 data-cy="heading-formulario">Llene el Formulario de Contacto</h2>

    <form class="formulario" action="/contacto" method="POST" data-cy="formulario-contacto">
        <fieldset>
            <legend>Información Personal</legend>

            <label for="nombre">Nombre</label>
            <input type="text" placeholder="Tu Nombre" id="nombre" name="contacto[nombre]" required data-cy="input-nombre">

            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje" name="contacto[mensaje]" required data-cy="input-mensaje"></textarea>
        </fieldset><!-- Información Personal -->

        <fieldset>
            <legend>Información sobre la Propiedad</legend>

            <label for="opciones">Vende o Compra</label>
            <select id="opciones" name="contacto[tipo]" required data-cy="input-opciones">
                <option value="" disabled selected>-- Seleccione --</option>
                <option value="Compra">Compra</option>
                <option value="Vende">Vende</option>
            </select>

            <label for="presupuesto">Precio o Presupuesto</label>
            <input type="number" placeholder="Tu Precio o Presupuesto" id="presupuesto" name="contacto[precio]" required data-cy="input-precio">
        </fieldset><!-- Información sobre la Propiedad -->

        <fieldset>
            <legend>Contacto</legend>

            <p>Como desea ser contactado:</p>

            <div class="forma-contacto">
                <label for="contactar-telefono">Teléfono</label>
                <input type="radio" value="telefono" id="contactar-telefono" name="contacto[contacto]" required data-cy="forma-contacto">

                <label for="contactar-email">E-mail</label>
                <input type="radio" value="email" id="contactar-email" name="contacto[contacto]" required data-cy="forma-contacto">
            </div>

            <div id="contacto"></div>
        </fieldset><!-- Contacto -->

        <input type="submit" value="Enviar" class="boton-verde">
    </form>
</main>