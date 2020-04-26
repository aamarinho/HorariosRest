<?php
require_once(__DIR__."/../model/AsignaturaMapper.php");
require_once(__DIR__ . "/BaseRest.php");
require_once(__DIR__ . "/../model/Asignatura.php");
require_once(__DIR__."/../core/ValidationException.php");

class AsignaturaRest extends BaseRest
{
    private $asignaturaMapper;

    public function __construct()
    {
        parent::__construct();

        $this->asignaturaMapper = new AsignaturaMapper();
    }

    public function getAsignaturas() {
        $asignaturas = $this->asignaturaMapper->getAsignaturas();
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($asignaturas));
    }

    public function registrar(){
        $data = $_POST['asignatura'];
        $data = json_decode($data,true);
        $asignatura = new Asignatura($data['id'],$data['nombre'],$data['email'],$data['curso'],$data['cuatrimestre']);

        $this->asignaturaMapper->registrarAsignatura($asignatura);
        header($_SERVER['SERVER_PROTOCOL'].' 201 Ok');
        header('Content-Type: application/json');
    }

    public function eliminar($id){
        $resul = $this->asignaturaMapper->eliminar($id);
        if($resul==1){
            header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            echo(json_encode(true));
        }
        else if($resul==0){
            header($_SERVER['SERVER_PROTOCOL'].' 500 Internal Server Error');
            echo("Error al ejecutar la sentencia de eliminacion");

        }
        else{
            header($_SERVER['SERVER_PROTOCOL'].' 406 Not Acceptable');
            echo("Error desconocido al ejecutar la sentencia de eliminacion");
        }
    }
}

$asignaturas = new AsignaturaRest();
URIDispatcher::getInstance()
    ->map("GET","/asignatura/asignaturas", array($asignaturas,"getAsignaturas"))
    ->map("POST","/asignatura/registro",array($asignaturas,"registrar"))
    ->map("DELETE","/asignatura/eliminar/$1",array($asignaturas,"eliminar"));


