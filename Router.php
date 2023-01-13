<?php 

namespace MVC;

class Router {

    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn){
        $this->rutasGET[$url] = $fn;
    }

    public function post($url, $fn){
        $this->rutasPOST[$url] = $fn;
    }

    // Comprueba que se puede acceder a la ruta
    public function comprobarRutas(){

        session_start();
        $auth = $_SESSION["login"] ?? NULL;

        // Arreglo de rutas protegidas
        $rutas_protegidas = ["/admin", "/propiedades/crear", "/propiedades/actualizar", "/propiedades/eliminar", "/vendedores/crear", "/vendedores/actualizar", "/vendedores/eliminar"];

        //$urlActual = $_SERVER["PATH_INFO"] ?? "/"; // Local
        $urlActual = $_SERVER["REQUEST_URI"]==="" ? "/" : $_SERVER["REQUEST_URI"]; // Deployment
        $metodo = $_SERVER["REQUEST_METHOD"];

        if($metodo === "GET"){
            $fn = $this->rutasGET[$urlActual] ?? NULL;
        }else{
            $fn = $this->rutasPOST[$urlActual] ?? NULL;
        }

        // Proteger las rutas
        if(in_array($urlActual, $rutas_protegidas) && !$auth){
            header("Location: /");
        }

        if($fn){
            call_user_func($fn, $this);
        }else{
            echo "Pagina no encontrada";
        }
    }

    // Muestra las Vistas
    public function mostrar($vista, $datos = []){

        foreach($datos as $key => $value){
            $$key = $value;
        }

        ob_start(); // Almacenamos en memoria lo siguiente
        include __DIR__ . "/vistas/$vista.php";
        $contenido = ob_get_clean(); // Guardamos y limpiamos 
        include __DIR__ . "/vistas/layout.php";
    }
}