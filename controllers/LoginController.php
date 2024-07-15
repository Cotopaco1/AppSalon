<?php

namespace Controllers;

use Classes\Email;
use Error;
use Model\Usuario;
use MVC\Router;
class LoginController{


    public static function login(Router $router){
        $alertas = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $userPost = new Usuario($_POST['user']); 

            $alertas = $userPost->validarLogin();

            if(empty($alertas)){
                $userDB = Usuario::where('email', $userPost->email);
                /* $resultado = $userPost->userExist(); */
                if($userDB){
                    //Existe el correo en la db
                    //verificar password
                    
                    $isPasswordAndVerify = $userDB->comprobarPasswordAndVerificado($userPost->password);
                    if($isPasswordAndVerify){
                        session_start();
                        $_SESSION['id'] = $userDB->id;
                        $_SESSION['email'] = $userDB->email;
                        $_SESSION['nombre'] = $userDB->nombre . " " . $userDB->apellido;
                        $_SESSION['login'] = true;

                        if($userDB->admin === '1'){
                            $_SESSION['admin'] = $userDB->admin ?? null;
                            header('location: /admin');
                        }else{
                            header('location: /cita');
                        }
                    }
                }else{
                    //El correo no existe en la db
                    Usuario::setAlerta('error', 'El usuario no existe');
                }
            }
        }
       $alertas = Usuario::getAlertas();
        $router->render('auth/login', [
            'alertas'=> $alertas
        ]);
    }
    public static function logout(){
        
        session_start();

        $_SESSION = [];

        header('location: /');

    }
    public static function olvide(Router $router){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $userPOST = new Usuario($_POST['user']);
           
            $userPOST->validarEmail();
            if(empty(Usuario::getAlertas())){
                $userDB = Usuario::where('email', $userPOST->email);
                if($userDB && $userDB->confirmado === '1'){
                    $userDB->crearToken();
                    $mail = new Email($userDB->email, $userDB->nombre, $userDB->token);
                    $mail->enviarEmail('olvide');
                    $userDB->guardar();
                    echo 'hemos enviado un correo electronico...';
    
                }else{
                    Usuario::setAlerta('error','El email no existe o no esta confirmado..');
                }

            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide', [
            'alertas'=>$alertas
        ]);
        
    }
    public static function recuperar(Router $router){
        $error = false;
        $tokenGET = $_GET['token'];
        $usuarioGET = Usuario::where('token', $tokenGET);

        if(!$usuarioGET){
            Usuario::setAlerta('error', 'El token es invalido...');
            $error = true;
        }   

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuarioPOST = new Usuario($_POST['user']);
            $usuarioPOST->validarPassword();
            if(!$usuarioGET){
                Usuario::setAlerta('error', 'El token es invalido...');
                
            }
            
            if(empty(Usuario::getAlertas())){
                if($usuarioGET){
                    $usuarioGET->password = $usuarioPOST->password;
                    $usuarioGET->hashearPassword();
                    $usuarioGET->token = null;
                    $resultado = $usuarioGET->guardar();
                    
                    if($resultado){
                        header('location: /');
                    }
                }

            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/recuperar-password', [
            'alertas'=> $alertas,
            'error'=> $error
        ]);

    }
    public static function crear(Router $router){

        $usuario = new Usuario();
        $alertas = Usuario::getAlertas();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST['usuario']);
            $alertas = $usuario->validarNuevaCuenta();

            if(empty($alertas)){
                
                $userExist = $usuario->userExist();

                if($userExist->num_rows){
                    //El email ya tiene atado una cuenta.
                    $alertas['error'][] = "El email ya tiene una cuenta atada";
                }
                else{
                    $usuario->hashearPassword();
                    $usuario->crearToken();
                  
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarEmail('confirmacion');
                    $resultado = $usuario->guardar();

                    if($resultado){
                        header('location: /mensaje');
                        /* $alertas['exito'][] = 'Hemos enviado un email de confirmacion, porfavor revisalo'; */
                    }
                    else{
                        $alertas['error'][] = 'Ha ocurrido un error...';
                    }

                }
            }
            
        }
        $router->render('auth/crear', [
            'usuario'=>$usuario,
            'alertas'=>$alertas
        ]);
    }

    public static function confirmar(Router $router){
        $token = s($_GET['token']);

        $resultado = Usuario::confirmarUsuario($token);
       /*  if($resultado){     
            $alertas = Usuario::getAlertas();
        } */

        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar', [
            'alertas'=>$alertas
        ]);
    }
    public static function mensaje(Router $router){
        $router->render('auth/mensaje');
    }
}