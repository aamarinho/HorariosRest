<?php
require_once(__DIR__ . "/../model/GrupoReducido.php");
require_once(__DIR__."/../model/GrupoReducidoMapper.php");
require_once(__DIR__ . "/BaseRest.php");

class GrupoReducidoRest extends BaseRest {
    private $grupoMapper;

    public function __construct() {
        parent::__construct();

        $this->grupoMapper = new GrupoReducidoMapper();
    }

    public function getGrupos(){
        $gruposArray = $this->grupoMapper->getGrupos();
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($gruposArray));
    }

    public function getGrupoById($id) {
        $grupos = $this->grupoMapper->getGrupoById($id);
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($grupos));
    }

    public function countGrupos($idasignatura) {
        $grupos = $this->grupoMapper->countGrupos($idasignatura);
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($grupos));
    }

    public function registrar(){
        parent::comprobarTipo(1);
        $data = $_POST['grupo'];
        $data = json_decode($data,true);
        $grupo = new GrupoReducido($data['id'],$data['id_asignatura'],$data['tipo'],$data['dia'],$data['hora_inicio'],$data['hora_fin'],$data['aula']);

        $this->grupoMapper->registrarGrupo($grupo);
        header($_SERVER['SERVER_PROTOCOL'].' 201 Ok');
        header('Content-Type: application/json');
    }

    public function editarGrupo(){
        parent::comprobarTipo(1);
        $data = $_POST['grupo'];
        $data = json_decode($data,true);
        $grupo = new GrupoReducido($data['id'],$data['id_asignatura'],$data['tipo'],$data['dia'],$data['hora_inicio'],$data['hora_fin'],$data['aula']);

        $this->grupoMapper->editarGrupo($grupo);
        header($_SERVER['SERVER_PROTOCOL'].' 201 Ok');
        header('Content-Type: application/json');
    }

    public function eliminar($id){
        parent::comprobarTipo(1);
        $resul = $this->grupoMapper->eliminar($id);
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

$grupoRest = new GrupoReducidoRest();
URIDispatcher::getInstance()
    ->map("GET","/grupo/grupos",array($grupoRest,"getGrupos"))
    ->map("GET","/grupo/getgrupo/$1", array($grupoRest,"getGrupoById"))
    ->map("GET","/grupo/countgrupos/$1", array($grupoRest,"countGrupos"))
    ->map("POST","/grupo/registro",array($grupoRest,"registrar"))
    ->map("POST","/grupo/editar/",array($grupoRest,"editarGrupo"))
    ->map("DELETE","/grupo/eliminar/$1",array($grupoRest,"eliminar"));
