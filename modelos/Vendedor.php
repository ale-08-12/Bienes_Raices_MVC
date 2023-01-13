<?php

namespace Modelo;

class Vendedor extends ActiveRecord{
    
    protected static $columnasDB = ["id", "nombre", "apellido", "telefono"];
    protected static $tabla = "vendedores";

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($args = []){
        $this->id = $args["id"] ?? NULL;
        $this->nombre = $args["nombre"] ?? "";
        $this->apellido = $args["apellido"] ?? "";
        $this->telefono = $args["telefono"] ?? "";
    }

    // Validacion
    public function validar() : array{
        
        if(!$this->nombre){
            self::$errores[] = "El nombre es obligatorio";
        }

        if(!$this->apellido){
            self::$errores[] = "El apellido es obligatorio";
        }

        if(!$this->telefono){
            self::$errores[] = "El telefono es obligatorio";
        }

        if(!preg_match("/[0-9]{9}/", $this->telefono) || !(strlen($this->telefono) < 10)){
            self::$errores[] = "Formato no Válido";
        }

        return self::$errores;
    }
}