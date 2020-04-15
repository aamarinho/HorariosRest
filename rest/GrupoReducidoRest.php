<?php
require_once(__DIR__ . "/../model/GrupoReducido.php");
require_once(__DIR__."/../core/ValidationException.php");
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

    public function registrar(){
        $data = $_POST['grupo'];
        $data = json_decode($data,true);
        $grupo = new GrupoReducido($data['id'],$data['id_asignatura'],$data['hora_inicio'],$data['hora_fin']);

        $this->grupoMapper->registrarGrupo($grupo);
        header($_SERVER['SERVER_PROTOCOL'].' 201 Ok');
        header('Content-Type: application/json');
    }

}

$grupoRest = new GrupoReducidoRest();
URIDispatcher::getInstance()
    ->map("GET","/grupo/grupos",array($grupoRest,"getGrupos"))
    ->map("POST","/grupo/registro",array($grupoRest,"registrar"));
