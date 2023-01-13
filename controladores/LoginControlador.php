<?php

namespace Controlador;

use MVC\Router;
use Modelo\Admin;

class LoginControlador{

    public static function login(Router $router){

        $errores = Admin::getErrores();

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            
            $auth = new Admin($_POST);
            $errores = $auth->validar();

            if(empty($errores)){
                $resultado = $auth->existeUsuario();

                // Verificar si el usuario existe
                if(!$resultado){
                    $errores = Admin::getErrores();
                }else{
                    // Verificar el password
                    $autenticado = $auth->comprobarPassword($resultado);

                    if($autenticado){
                        // Autenticar al usuario
                        $auth->autenticar();
                    }else{
                        $errores = Admin::getErrores();
                    }
                }
            }
        }

        $router->mostrar("auth/login", [
            "errores" => $errores
        ]);
    }

    public static function logout(){
        session_start();
        $_SESSION = [];
        header("Location: /");
    }
}