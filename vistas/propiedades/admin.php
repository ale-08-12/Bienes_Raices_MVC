    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>
        
        <?php
            if($resultado){
                $mensaje = mostrarNotificacion(intval($resultado));

                if($mensaje){ ?>
                    <p class="alerta exito"><?php echo sanitizar($mensaje); ?></p>
            <?php } 
            } 
        ?>

        <a class="boton boton-verde" href="/propiedades/crear">Nueva Propiedad</a>
        <a class="boton boton-amarillo" href="/vendedores/crear">Nuevo(a) Vendedor</a>

        <h2>Propiedades</h2>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody><!-- Mostrar los Resultados de la BD -->
                <?php foreach($propiedades as $propiedad){ ?>
                    <tr>
                        <td> <?php echo $propiedad->id; ?> </td>
                        <td> <?php echo $propiedad->titulo; ?> </td>
                        <td> <img src="../imagenes/<?php echo $propiedad->imagen; ?>" alt="Imagen Tabla" class="imagen-tabla"> </td>
                        <td>$ <?php echo $propiedad->precio; ?> </td>
                        <td>
                            <form class="w-100" method="POST" action="/propiedades/eliminar">
                                <input type="hidden" name="id" value=" <?php echo $propiedad->id; ?> ">
                                <input type="hidden" name="tipo" value="propiedad">
                                <input class="boton-rojo-block" type="submit" value="Eliminar">
                            </form>
                            <a class="boton-amarillo-block" href="/propiedades/actualizar?id=<?php echo $propiedad->id; ?>">Actualizar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h2>Vendedores</h2>
        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody><!-- Mostrar los Resultados de la BD -->
                <?php foreach($vendedores as $vendedor){ ?>
                    <tr>
                        <td> <?php echo $vendedor->id; ?> </td>
                        <td> <?php echo $vendedor->nombre . " " . $vendedor->apellido; ?> </td>
                        <td> <?php echo $vendedor->telefono; ?> </td>
                        <td>
                            <form class="w-100" method="POST" action="/vendedores/eliminar">
                                <input type="hidden" name="id" value=" <?php echo $vendedor->id; ?> ">
                                <input type="hidden" name="tipo" value="vendedor">
                                <input class="boton-rojo-block" type="submit" value="Eliminar">
                            </form>
                            <a class="boton-amarillo-block" href="/vendedores/actualizar?id=<?php echo $vendedor->id; ?>">Actualizar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>