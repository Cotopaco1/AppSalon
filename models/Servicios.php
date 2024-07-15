<?php 

namespace Model;

class Servicios extends ActiveRecord{

    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre', 'precio'];

    public $id;
    public $nombre;
    public $precio;

    public  function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? null;
    }
    public function validar(){
        if(!$this->nombre){
            self::setAlerta('error','El Nombre es obligatorio');
        }
        if(!$this->precio){
            self::setAlerta('error','El precio es obligatorio');
        }
        if(!is_numeric($this->precio) && $this->precio){
            self::setAlerta('error','El precio debe ser un numero');
        }
        return self::$alertas;
    }

}