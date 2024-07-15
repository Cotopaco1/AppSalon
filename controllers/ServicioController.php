<?php

namespace Controllers;

use Model\Servicios;
use MVC\Router;

class ServicioController{

    public static function index(Router $router){
        isAdmin();

        $servicios = Servicios::all();
        

        $router->render('servicios/index',[
            'nombre'=>$_SESSION['nombre'],
            'servicios'=>$servicios
        ]);

    }
    public static function crear(Router $router){
        isAdmin();

        $servicio = new Servicios();
        $alertas = [];
        
        if($_SERVER["REQUEST_METHOD"]==='POST'){

            // $servicio = new Servicios($_POST);
            $servicio->sincronizar($_POST) ;
            $alertas = $servicio->validar();

            if(empty($alertas)){
                $servicio->guardar();
                header('location: /servicios');
            }
            
        }

        $router->render('servicios/crear',[
            'nombre'=>$_SESSION['nombre'],
            'servicio'=>$servicio,
            'alertas'=>$alertas
        ]);

    }
    public static function actualizar(Router $router){
        isAdmin();
        $alertas = [];
        $id = $_GET['id'];
        if(!is_numeric($id)) return;
        $servicio = Servicios::find($id);
        
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $servicio->sincronizar($_POST);

            $alertas = $servicio->validar();
            if(empty($alertas)){
                $servicio->guardar();
                header('location: /servicios');
            }
            
        }

        $router->render('servicios/actualizar',[
            'nombre'=>$_SESSION['nombre'],
            'id'=>$id,
            'servicio'=>$servicio,  
            'alertas'=> $alertas
        ]);

    }
    public static function eliminar(){
        isAdmin();
        $id = $_POST['id'];
        if(!is_numeric($id)) return;
        $servicio = Servicios::find($id);
        $servicio->eliminar();
        header('location: /servicios');
    }
}