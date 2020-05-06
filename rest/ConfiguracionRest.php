<?php
require_once(__DIR__ . "/../model/Configuracion.php");
require_once(__DIR__."/../core/ValidationException.php");
require_once(__DIR__."/../model/ConfiguracionMapper.php");
require_once(__DIR__ . "/BaseRest.php");

class ConfiguracionRest extends BaseRest {
    private $configuracionMapper;

    public function __construct() {
        parent::__construct();

        $this->configuracionMapper = new ConfiguracionMapper();
    }

    public function getConfiguracion(){
        $configuracion = $this->configuracionMapper->getConfiguracion();
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($configuracion));
    }

    public function editar(){
        $data = $_POST['configuracion'];
        $data = json_decode($data,true);
        $configuracion = new Configuracion($data['id'],$data['f_inicio_uno'],$data['f_fin_uno'],$data['f_inicio_dos'],$data['f_fin_dos']);

        $this->configuracionMapper->editar($configuracion);
        header($_SERVER['SERVER_PROTOCOL'].' 201 Ok');
        header('Content-Type: application/json');
    }

}

// URI-MAPPING for this Rest endpoint
$configuracion = new ConfiguracionRest();
URIDispatcher::getInstance()
    ->map("GET","/configuracion/get", array($configuracion,"getConfiguracion"))
    ->map("POST","/configuracion/editar",array($configuracion,"editar"));
