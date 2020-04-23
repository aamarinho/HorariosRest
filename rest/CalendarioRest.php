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
}

$calendario = new CalendarioRest();
URIDispatcher::getInstance()
    ->map("POST","/calendario/registrar",array($calendario,"registrar"))
    ->map("GET","/calendario/get/$1",array($calendario,"getCalendario"));

