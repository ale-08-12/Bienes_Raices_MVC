<?php

namespace Modelo;

class Admin extends ActiveRecord{

    protected static $columnaDB = ["id", "email", "password"];
    protected static $tabla = "usuarios";

    public $id;
    public $email;
    public $password;

    public function __construct($args = []){
        $this->id = $args["id"] ?? NULL;
        $this->email = $args["email"] ?? "";
        $this->password = $args["password"] ?? "";
    }

    // Busca un registro por su email
    public function existeUsuario(){
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1;";
        $resultado = self::$db->query($query);

        if(!$resultado->num_rows){
            self::$errores[] = "El Usuario no existe";
            return;
        }
        return $resultado;
    }

    public function comprobarPassword($resultado){
        $usuario = $resultado->fetch_object();

        $autenticado = password_verify($this->password, $usuario->password);

        if(!$autenticado){
            self::$errores[] = "El Password es incorrecto";
        }
        return $autenticado;
    }

    public function autenticar(){
        session_start();

        $_SESSION["usuario"] = $this->email;
        $_SESSION["login"] = true;

        header("Location: /admin");
    }

    public function validar() : array{
        if(!$this->email){
            self::$errores[] = "El Email es obligatorio";
        }

        if(!$this->password){
            self::$errores[] = "El Password es obligatorio";
        }
        return self::$errores;
    }
}