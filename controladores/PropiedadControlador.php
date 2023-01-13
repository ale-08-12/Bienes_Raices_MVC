<?php

namespace Controlador;
use MVC\Router;
use Modelo\Propiedad;
use Modelo\Vendedor;
use Intervention\Image\ImageManagerStatic as Imagen;

class PropiedadControlador{

    public static function index(Router $router){

        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        
        // Muestra mensaje condicional
        $resultado = $_GET["resultado"] ?? null;

        $router->mostrar("propiedades/admin", [
            "propiedades" => $propiedades,
            "vendedores" => $vendedores,
            "resultado" => $resultado
        ]);
    }

    public static function crear(Router $router){

        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();

        // Arreglo con mensajes de errores
        $errores = Propiedad::getErrores();

        if($_SERVER["REQUEST_METHOD"]==="POST"){
            $propiedad = new Propiedad($_POST["propiedad"]);

            // Generar nombre único y lo seteo
            if($_FILES["propiedad"]["tmp_name"]["imagen"]){
                $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
                $propiedad->setImagen($nombreImagen);
            }
            
            $errores = $propiedad->validar();

            // Revisamos que el arreglo de errores este vacio
            if(empty($errores)){

                // Crear carpeta
                if(!is_dir(CARPETA_IMAGENES)){
                    mkdir(CARPETA_IMAGENES);
                }

                // Realiza un resize a la imagen con intervention
                $imagen = Imagen::make($_FILES["propiedad"]["tmp_name"]["imagen"])->fit(800,600);
                
                // Guardar la imagen en el servidor
                $imagen->save(CARPETA_IMAGENES . $nombreImagen);

                $propiedad->guardar();   
            }
        }

        $router->mostrar("propiedades/crear", [
            "propiedad" => $propiedad,
            "vendedores" => $vendedores,
            "errores" => $errores
        ]);
    }

    public static function actualizar(Router $router){

        $id = validarORedireccionar("/admin");

        $propiedad = Propiedad::buscar($id);

        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();

        if($_SERVER["REQUEST_METHOD"]==="POST"){
        
            $array = $_POST["propiedad"];
    
            $propiedad->sincronizar($array);
    
            $errores = $propiedad->validar();
    
            // Revisamos que el arreglo de errores este vacio
            if(empty($errores)){
    
                // Crear carpeta
                if(!is_dir(CARPETA_IMAGENES)){
                    mkdir(CARPETA_IMAGENES);
                }
    
                // Eliminamos imagen previa
                if($_FILES["propiedad"]["tmp_name"]["imagen"]){
                    
                    // Generar nombre único y lo seteo
                    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
                    $propiedad->setImagen($nombreImagen);
    
                    // Realiza un resize a la imagen con intervention
                    $imagen = Imagen::make($_FILES["propiedad"]["tmp_name"]["imagen"])->fit(800,600);
                
                    // Guardar la imagen en el servidor
                    $imagen->save(CARPETA_IMAGENES . $nombreImagen);
                }
    
                $propiedad->guardar();            
            }
        }

        $router->mostrar("propiedades/actualizar", [
            "propiedad" => $propiedad,
            "errores" => $errores,
            "vendedores" => $vendedores
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
                    $propiedad = Propiedad::buscar($id);
                    $propiedad->eliminar();
                }
            }
        }
    }
}