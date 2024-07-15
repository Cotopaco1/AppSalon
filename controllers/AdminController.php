<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController{

    public static function index(Router $router){

        session_start();
        
        if(!isset($_SESSION['admin'])){
            header('location: /');
            return;
        }
        // $fecha = ;
        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $fechas = explode('-', $fecha);

        if(!checkdate($fechas[1], $fechas[2], $fechas[0])){
            header('Location: /404');
        }
        // debuguear($fecha);
        // debuguear($_GET['fecha']);

        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuariosId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasservicios ";
        $consulta .= " ON citasservicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON citasservicios.servicioId=servicios.id ";
        $consulta .= " WHERE fecha =  '$fecha' ";

        $citas = AdminCita::SQL($consulta);
        /* debuguear($cita); */

        $router->render('admin/index', [
            'nombre'=>$_SESSION['nombre'],
            'citas'=>$citas,
            'fecha'=>$fecha
        ]);

    }
}