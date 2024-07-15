<?php

namespace Model;

class Citas extends ActiveRecord{

    protected static $tabla = 'citas';
    protected static $columnasDB = ['id', 'fecha', 'hora', 'usuariosId'];

    public $id;
    public $fecha;
    public $hora;
    public $usuariosId;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->usuariosId = $args['usuariosId'] ?? null;
    }

}