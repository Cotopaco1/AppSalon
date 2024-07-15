<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function debugear_resultado_json($tipo,$mensaje){

    $resultado = [
        'resultado'=>$tipo,
        'mensaje'=>$mensaje,
    ];

    echo json_encode($resultado);
    return;

}
function isAuth(): void{

    if(!isset($_SESSION['login'])){
        header('location: /');
    }
}
function esUltimo(string $actual, string $proximo): bool{
    if($proximo !== $actual ){
        return true;
    }
    return false;
}
function isAdmin(): void{
    session_start();
        
        if(!isset($_SESSION['admin'])){
            header('location: /');
            exit;
        }
}