<?php
require_once(__DIR__."/../model/GrupoReducidoMapper.php");
require_once(__DIR__."/../model/UsuarioGrupoMapper.php");
require_once(__DIR__."/../model/UsuarioGrupo.php");
require_once(__DIR__ . "/BaseRest.php");
require_once(__DIR__ . "/../model/GrupoReducido.php");
require_once(__DIR__ . "/../model/CalendarioMapper.php");
require_once(__DIR__ . "/../model/Calendario.php");
require_once(__DIR__."/../core/ValidationException.php");

class CalendarioRest extends BaseRest {
    private $calendarioMapper;

    public function __construct() {
        parent::__construct();

        $this->calendarioMapper = new CalendarioMapper();
    }

    public function registrar() {
        parent::comprobarTipo(1);
        $data = $_POST['grupos'];
        $data = json_decode($data, true);
        foreach ($data as $value) {
            $gruporeducido = new GrupoReducido($value['id'],$value['id_asignatura'],$value['tipo'],$value['dia'],$value['hora_inicio'],$value['hora_fin'],$value['aula']);
            $this->calendarioMapper->registrar($gruporeducido);
        }
        header($_SERVER['SERVER_PROTOCOL'] . ' 201 Ok');
        header('Content-Type: application/json');
    }

    public function getCalendario($email){
        $resul = $this->calendarioMapper->getCalendario($email);
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($resul));
    }

    public function getActividadDocente($id){
        parent::comprobarTipo(2);
        $usuario = $this->calendarioMapper->getActividadDocenteById($id);
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($usuario));
    }

    public function getEventos(){
        parent::comprobarTipo(2);
        $resul = $this->calendarioMapper->getEventos();
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($resul));
    }

    public function getGruposSinGenerar(){
        parent::comprobarTipo(1);
        $resul = $this->calendarioMapper->getGruposSinGenerar();
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($resul));
    }

    public function registrarActividadDocente() {
        parent::comprobarTipo(2);
        $data = $_POST['calendario'];
        $data = json_decode($data, true);
        $calendario = new Calendario('',$data['nombre'],$data['id_grupo'],'',$data['fecha'],$data['hora_inicio'],$data['hora_fin'],$data['responsable'],$data['aula']);
        $this->calendarioMapper->registrarActividadDocente($calendario);

        header($_SERVER['SERVER_PROTOCOL'] . ' 201 Ok');
        header('Content-Type: application/json');
    }

    public function editarActividadDocente(){
        parent::comprobarTipo(2);
        $data = $_POST['calendario'];
        $data = json_decode($data,true);
        $calendario = new Calendario($data['id'],$data['nombre'],$data['id_grupo'],$data['id_asignatura'],$data['fecha'],$data['hora_inicio'],$data['hora_fin'],$data['responsable'],$data['aula']);

        $this->calendarioMapper->editarActividadDocente($calendario);
        header($_SERVER['SERVER_PROTOCOL'].' 201 Ok');
        header('Content-Type: application/json');
    }

    public function eliminar($id){
        parent::comprobarTipo(2);
        $resul = $this->calendarioMapper->eliminar($id);
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

$calendario = new CalendarioRest();
URIDispatcher::getInstance()
    ->map("POST","/calendario/registrar",array($calendario,"registrar"))
    ->map("GET","/calendario/get/$1",array($calendario,"getCalendario"))
    ->map("GET","/calendario/getall",array($calendario,"getEventos"))
    ->map("GET","/calendario/get/grupos/singenerar",array($calendario,"getGruposSinGenerar"))
    ->map("GET","/calendario/get/actividaddocente/$1",array($calendario,"getActividadDocente"))
    ->map("POST","/calendario/registraractividaddocente",array($calendario,"registrarActividadDocente"))
    ->map("POST","/calendario/editar/actividaddocente",array($calendario,"editarActividadDocente"))
    ->map("DELETE","/calendario/eliminar/$1",array($calendario,"eliminar"));

