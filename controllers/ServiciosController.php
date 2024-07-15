<?php

namespace Controllers;

use Model\Citas;
use Model\citasServicios;
use Model\Servicios;

class ServiciosController{

    public static  function servicios(){

        $servicios = Servicios::all();
        echo json_encode($servicios);
    }
    public static function guardar(){
        $cita = new Citas($_POST);
        /* $servicios = $_POST['servicios'];
        $datos = explode(',', $servicios); */
        $resultado = $cita->guardar();

        if(!$resultado['resultado']) debugear_resultado_json('error', 'No se pudo guardar la cita..');

        $citaServicio = new citasServicios();
        $citaServicio->citaId = $resultado['id'];

        $serviciosPOST = explode(",", $_POST['servicios']);

        foreach ($serviciosPOST as $servicio) {
            $citaServicio->servicioId = $servicio;
            $resultado = $citaServicio->guardar();

        }
       /*  $respuesta = [
            'respuesta' => $resultado
        ]; */
        echo json_encode($resultado);

        /* if($_SERVER['REQUEST_METHOD'] === 'POST'){

        } */
    }
    public static function eliminar(){

        if($_SERVER['REQUEST_METHOD']=== 'POST'){
            $id = $_POST['id'];

            $cita = Citas::find($id);
            $cita->eliminar();

            header('Location: '. $_SERVER['HTTP_REFERER']);
        }
    }
}