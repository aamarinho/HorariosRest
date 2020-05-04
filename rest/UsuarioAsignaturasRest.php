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

    public function registrarAsignaturas() {//importacion
        $data = $_POST['asignaturas'];
        $data2 = $_POST['email'];
        $data = json_decode($data, true);
        $data2 = json_decode($data2, true);
        foreach ($data as $value){
            $usuarioAsignatura = new UsuarioAsignaturas($data2, $value);
            $this->usuarioAsignaturasMapper->registrar($usuarioAsignatura);
        }

        header($_SERVER['SERVER_PROTOCOL'] . ' 201 Ok');
        header('Content-Type: application/json');
    }

    public function registrarUsuarioAsignatura() {
        $data = $_POST['asignatura'];
        $data2 = $_POST['email'];
        $data = json_decode($data, true);
        $data2 = json_decode($data2, true);
        echo $data;
        echo $data2;
        $usuarioAsignatura = new UsuarioAsignaturas($data2,$data);
        $this->usuarioAsignaturasMapper->registrar($usuarioAsignatura);
        header($_SERVER['SERVER_PROTOCOL'] . ' 201 Ok');
        header('Content-Type: application/json');
    }

    public function getUsuariosAsignaturas($email){
        $usuariosasignaturas = $this->usuarioAsignaturasMapper->getUsuariosAsignaturas($email);
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($usuariosasignaturas));
    }

    public function eliminar($email,$id){
        $resul = $this->usuarioAsignaturasMapper->eliminar($email,$id);
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
$usuarioasignaturas = new UsuarioAsignaturasRest();
URIDispatcher::getInstance()
    ->map("GET","/usuarioasignatura/get/$1", array($usuarioasignaturas,"getUsuariosAsignaturas"))
    ->map("POST","/usuarioasignatura/registrar",array($usuarioasignaturas,"registrar"))
    ->map("POST","/usuarioasignatura/registrar/importacion",array($usuarioasignaturas,"registrarAsignaturas"))
    ->map("POST","/usuarioasignatura/registrar/individual",array($usuarioasignaturas,"registrarUsuarioAsignatura"))
    ->map("DELETE","/usuarioasignatura/eliminar/$1/$2",array($usuarioasignaturas,"eliminar"));

