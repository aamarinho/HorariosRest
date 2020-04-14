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
}

$asignaturas = new AsignaturaRest();
URIDispatcher::getInstance()
    ->map("GET","/asignatura/asignaturas", array($asignaturas,"getAsignaturas"));


