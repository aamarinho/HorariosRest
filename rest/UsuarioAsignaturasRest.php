<?php
require_once(__DIR__."/../model/AsignaturaMapper.php");
require_once(__DIR__."/../model/UsuarioAsignaturasMapper.php");
require_once(__DIR__."/../model/UsuarioAsignaturas.php");
require_once(__DIR__ . "/BaseRest.php");
require_once(__DIR__ . "/../model/Asignatura.php");
require_once(__DIR__."/../core/ValidationException.php");

class UsuarioAsignaturasRest extends BaseRest {
    private $usuarioAsignaturasMapper;

    public function __construct() {
        parent::__construct();

        $this->usuarioAsignaturasMapper = new UsuarioAsignaturasMapper();
    }

    public function registrar() {
        $data = $_POST['asignaturas'];
        $data2 = $_POST['email'];
        $data = json_decode($data, true);
        $data2 = json_decode($data2, true);
        foreach ($data as $value){
            $usuarioAsignatura = new UsuarioAsignaturas($data2, $value['id']);
            $this->usuarioAsignaturasMapper->registrar($usuarioAsignatura);
        }

        header($_SERVER['SERVER_PROTOCOL'] . ' 201 Ok');
        header('Content-Type: application/json');
    }
}
$usuarioasignaturas = new UsuarioAsignaturasRest();
URIDispatcher::getInstance()
    ->map("POST","/usuarioasignatura/registrar",array($usuarioasignaturas,"registrar"));

