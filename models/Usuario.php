<?php

namespace Model;

class Usuario extends ActiveRecord{
    //Base de datos

    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id','nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {

        /* self::$db->real_escape_string( $args['id']); */
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
    }

    public function validarNuevaCuenta(){

        $minCharactersPassword = 6;

        if(!$this->nombre){
            self::$alertas['error'][] = 'El nombre es requisito';
        }
        if(!$this->apellido){
            self::$alertas['error'][] = 'El apellido es requisito';
        }
        if(!$this->telefono){
            self::$alertas['error'][] = 'El telefono es requisito';
        }
        if(!$this->email){
            self::$alertas['error'][] = 'El email es requisito';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'El password es requisito';
        }
        if(strlen($this->password)< $minCharactersPassword && $this->password){
            self::$alertas['error'][] = "El password debe tener minimo {$minCharactersPassword} caracteres";
        }
        if(!$this->telefono){
            self::$alertas['error'][] = 'El telefono es requisito';
        }
       
        return self::$alertas;
    }
    public function validarLogin(){
        if(!$this->email){
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'La password es obligatoria';
        }
        return self::$alertas;
    }
    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][] =  'El email es obligatorio';
        }

    }
    public function validarPassword(){
        $minCharactersPassword = 6;
        if(!$this->password){
            self::$alertas['error'][] = 'La password es obligatoria';
        }
        if(strlen($this->password) < $minCharactersPassword && $this->password){
            self::$alertas['error'][] = "La password debe contener minimo {$minCharactersPassword} caracterees";
        }
    }

    public function userExist(){
        $sanitizado = $this->sanitizarAtributos();
        $email = $sanitizado['email'];
        $query = "SELECT * FROM ";
        $query .= self::$tabla;
        $query .= " WHERE email = " . "'$email'";

        $resultado = self::$db->query($query);

        return $resultado;
    }

    public function hashearPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
    public function crearToken(){
        $this->token = uniqid();
    }

    public static function confirmarUsuario($token){
        $user = Usuario::where('token', $token);
        if($user){
            $user->token = NULL;
            $user->confirmado = 1;
            $user->guardar();
            self::setAlerta('exito', 'Cuenta confirmada');
        }
        else{
            self::setAlerta('error', 'Link invalido o la cuenta ya ha sido confirmada...');
        }
        
    }

    public function comprobarPasswordAndVerificado($passwordPost){

        $resultado = password_verify($passwordPost, $this->password);
  
        if(!$resultado || !$this->confirmado){
            self::$alertas['error'][] = 'Tu cuenta no ha sido confirmada o la password es incorrecta';
            return false;
        }else{
            return true;
        }

    }

    /* public function confirmarPassword(){

        $resultado = $this->where('email', $this->email);
        $passwordDB = $resultado->password;
        $this->hashearPassword();

        if($passwordDB === $this->password){
            debuguear('La password es igual');
        }
        else{
            echo $this->password;
            echo '<br>';
            echo $passwordDB;
            debuguear('La password no es la misma');
        }

    } */

}