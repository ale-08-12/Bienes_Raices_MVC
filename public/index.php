<?php
    require_once __DIR__ . "/../includes/app.php";

    use MVC\Router;
    use Controlador\PropiedadControlador;
    use Controlador\VendedorControlador;
    use Controlador\PaginasControlador;
    use Controlador\LoginControlador;

    $router = new Router();

    // Zona Privada

    // Propiedades
    $router->get("/admin", [PropiedadControlador::class, "index"]);
    $router->get("/propiedades/crear", [PropiedadControlador::class, "crear"]);
    $router->post("/propiedades/crear", [PropiedadControlador::class, "crear"]);
    $router->get("/propiedades/actualizar", [PropiedadControlador::class, "actualizar"]);
    $router->post("/propiedades/actualizar", [PropiedadControlador::class, "actualizar"]);
    $router->post("/propiedades/eliminar", [PropiedadControlador::class, "eliminar"]);

    // Vendedores
    $router->get("/vendedores/crear", [VendedorControlador::class, "crear"]);
    $router->post("/vendedores/crear", [VendedorControlador::class, "crear"]);
    $router->get("/vendedores/actualizar", [VendedorControlador::class, "actualizar"]);
    $router->post("/vendedores/actualizar", [VendedorControlador::class, "actualizar"]);
    $router->post("/vendedores/eliminar", [VendedorControlador::class, "eliminar"]);

    // Zona Publica
    $router->get("/", [PaginasControlador::class, "index"]);
    $router->get("/nosotros", [PaginasControlador::class, "nosotros"]);
    $router->get("/propiedades", [PaginasControlador::class, "propiedades"]);
    $router->get("/propiedad", [PaginasControlador::class, "propiedad"]);
    $router->get("/blog", [PaginasControlador::class, "blog"]);
    $router->get("/entrada", [PaginasControlador::class, "entrada"]);
    $router->get("/contacto", [PaginasControlador::class, "contacto"]);
    $router->post("/contacto", [PaginasControlador::class, "contacto"]);

    // Login y Autenticación
    $router->get("/login", [LoginControlador::class, "login"]);
    $router->post("/login", [LoginControlador::class, "login"]);
    $router->get("/logout", [LoginControlador::class, "logout"]);

    $router->comprobarRutas();
?>