<?php

namespace Modelo;

class ActiveRecord{
    
    // Base de Datos
    protected static $db;
    protected static $columnasDB = [""];
    protected static $tabla = "";

    // Errores
    protected static $errores = [];

    public static function setDB($database) : void{
        self::$db = $database;
    }

    public function eliminar() : void{
        //Eliminar la propiedad
        $query = "DELETE FROM " . static::$tabla . " WHERE id = ". self::$db->escape_string($this->id) . " LIMIT 1;";

        $resultado = self::$db->query($query);

        if($resultado){
            $this->eliminarImagen();
            header("location: /admin?resultado=3");
        }
    }

    public function guardar() : void{
        if(is_null($this->id)){
            $this->crear();
        }else{
            $this->actualizar();
        }
    }

    public function crear() : void{
        //Sanitiza los Datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la Base de Datos
        $query = "INSERT INTO " . static::$tabla . " (";
        $query .= join(", ", array_keys($atributos));
        $query .= ") VALUES ('";
        $query .= join("', '", array_values($atributos));
        $query .= "');";

        $resultado = self::$db->query($query);
        
        // Mensaje de exito y Redireccionar al usuario
        if($resultado){
            header("Location: /admin?resultado=1");
        }
    }

    public function actualizar() : void{
        //Sanitiza los Datos
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        // Actualizar en la Base de Datos
        foreach($atributos as $key => $value){
            $valores[] = "${key} = '${value}'";
        }
        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(", ", $valores);
        $query .= " WHERE id = " . self::$db->escape_string($this->id);
        $query .= " LIMIT 1;";

        $resultado = self::$db->query($query);

        if($resultado){
            // Redireccionar al usuario
            header("Location: /admin?resultado=2");
        }
    }

    // Sanitizamos los atributos
    public function sanitizarAtributos() : array{
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach($atributos as $key => $value){
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // Identificar y unir los atributos de la BD
    public function atributos() : array{
        $atributos = [];
        
        foreach(static::$columnasDB as $columna){
            if($columna === "id") continue;
            $atributos[$columna] = $this->$columna;
        }
        //Recordad this tiene la direccion de memoria del objeto
        return $atributos;
    }

    // Busca un registro por su id
    public static function buscar($id) : object{
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = ${id};";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    // Lista todas la tabla
    public static function all() : array{
        $query = "SELECT * FROM " . static::$tabla . ";";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    
    // Obtiene determinada cantidad de registros.
    public static function limite($cantidad) : array{
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad . ";";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function consultarSQL($query) : array{
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $vector = [];
        while ($registro = $resultado->fetch_assoc()) {
            $vector[] = static::crearObjeto($registro);
        }

        // Liberar la memoria
        $resultado->free();

        // Retonar los resultados
        return $vector;
    }

    protected static function crearObjeto($registro) : object{
        $objeto = new static;
        foreach($registro as $key => $value){
            if(property_exists($objeto, $key)){
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    // Sincroniza el objeto en memoria con los cambios realizados
    public function sincronizar($array = []) : void{
        foreach($array as $key => $value){
            if(property_exists($this, $key) && !is_null($value)){
                $this->$key = $value;
            }
        }
    }

    // Subida de Archivo Imagen
    public function setImagen($imagen) : void{
        if(!is_null($this->id)){
            $this->eliminarImagen();
        }
        
        if($imagen){
            $this->imagen = $imagen;
        }
    }

    // Eliminacion de Archivo Imagen
    public function eliminarImagen() : void{
        if(file_exists(CARPETA_IMAGENES . $this->imagen)){
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }
    
    public static function getErrores() : array{
        return static::$errores;
    }

    // Validacion
    public function validar() : array{
        static::$errores = [];
        return static::$errores;
    }    
}