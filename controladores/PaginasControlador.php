<?php

namespace Controlador;

use MVC\Router;
use Modelo\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasControlador{

    public static function index(Router $router){
        
        $propiedades = Propiedad::limite(3);
        $inicio = true;
        
        $router->mostrar("paginas/index",[
            "propiedades" => $propiedades,
            "inicio" => $inicio
        ]);
    }

    public static function nosotros(Router $router){
        $router->mostrar("paginas/nosotros");
    }

    public static function propiedades(Router $router){
        
        $propiedades = Propiedad::all();

        $router->mostrar("paginas/propiedades", [
            "propiedades" => $propiedades
        ]);
    }

    public static function propiedad(Router $router){
        
        $id = validarORedireccionar("/propiedades");
        
        $propiedad = Propiedad::buscar($id);

        $router->mostrar("paginas/propiedad", [
            "propiedad" => $propiedad
        ]);
    }

    public static function blog(Router $router){
       //hacer dinamico
        $router->mostrar("paginas/blog");
    }

    public static function entrada(Router $router){
        $router->mostrar("paginas/entrada");
    }

    public static function contacto(Router $router){

        $mensaje = null;
        $enviado = null;

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            
            $respuestas = $_POST["contacto"];

            $mail = new PHPMailer();

            // Configurar SMTP (Protocolo para envios de email)
            $mail->isSMTP();
            $mail->Host = "smtp.mailtrap.io";
            $mail->SMTPAuth = true;
            $mail->Username = "a632a22812cd7f";
            $mail->Password = "107eb25b9935c3";
            $mail->SMTPSecure = "tls";
            $mail->Port = 2525;

            // Configurar el contenido del mail
            $mail->setFrom("admin@bienesraices.com");
            $mail->addAddress("admin@bienesraices.com", "BienesRaices");
            $mail->Subject = "Tienes un Nuevo Mensaje";

            // Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = "UTF-8";
            
            // Definir el contenido
            $contenido = "<html>";
            $contenido .= "<p>Tienes un nuevo mensaje</p>";
            $contenido .= "<p>Nombre: " . $respuestas["nombre"] . "</p>";

            $contenido .= "<p>Eligió ser contactado por " . $respuestas["contacto"] . "</p>";
            // Enviar de forma condicional los campos email y telefono
            if($respuestas["contacto"] === "telefono"){
                $contenido .= "<p>Teléfono: " . $respuestas["telefono"] . "</p>";
                $contenido .= "<p>Fecha Contacto: " . $respuestas["fecha"] . "</p>";
                $contenido .= "<p>Hora: " . $respuestas["hora"] . "</p>";

            }else{
                // Es email
                $contenido .= "<p>Email: " . $respuestas["email"] . "</p>";
            }
           
            $contenido .= "<p>Mensaje: " . $respuestas["mensaje"] . "</p>";
            $contenido .= "<p>Vende o Compra: " . $respuestas["tipo"] . "</p>";
            $contenido .= "<p>Precio o Presupuesta: $" . $respuestas["precio"] . "</p>";            
            $contenido .= "</html>";

            $mail->Body = $contenido;
            $mail->AltBody = "Esto es texto alternativo sin HTML";

            // Enviar el email
            if($mail->send()){
                $mensaje = "Mensaje Enviado Correctamente";
                $enviado = true;
            }else{
                $mensaje = "El Mensaje no se pudo Enviar";
                $enviado = false;
            }
        }

        $router->mostrar("paginas/contacto", [
            "mensaje" => $mensaje,
            "enviado" => $enviado
        ]);
    }
}