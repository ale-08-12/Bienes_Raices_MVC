<?php

namespace Controlador;
use MVC\Router;
use Modelo\Vendedor;

class VendedorControlador{
    
    public static function crear(Router $router){

        $vendedor = new Vendedor;

        // Arreglo con mensajes de errores
        $errores = Vendedor::getErrores();

        if($_SERVER["REQUEST_METHOD"]==="POST"){
            $vendedor = new Vendedor($_POST["vendedor"]);
    
            $errores = $vendedor->validar();
    
            if(empty($errores)){
                $vendedor->guardar();
            }
        }

        $router->mostrar("vendedores/crear", [
            "vendedor" => $vendedor,
            "errores" => $errores
        ]);
    }

    public static function actualizar(Router $router){
        
        $id = validarORedireccionar("/admin");

        // Obtener el vendedor
        $vendedor = Vendedor::buscar($id);

        // Arreglo con mensajes de errores
        $errores = Vendedor::getErrores();

        if($_SERVER["REQUEST_METHOD"]==="POST"){
            $array = $_POST["vendedor"];
    
            $vendedor->sincronizar($array);
    
            $errores = $vendedor->validar();
    
            if(empty($errores)){
                $vendedor->guardar();
            }
        }

        $router->mostrar("vendedores/actualizar", [
            "vendedor" => $vendedor,
            "errores" => $errores
        ]);
    }

    public static function eliminar(){

        if($_SERVER["REQUEST_METHOD"] === "POST"){

            // Validar ID
            $id = $_POST["id"];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id){
                $tipo = $_POST["tipo"];

                if(validarTipoContenido($tipo)){
                    $vendedor = Vendedor::buscar($id);
                    $vendedor->eliminar();
                }
            }
        }
    }
}