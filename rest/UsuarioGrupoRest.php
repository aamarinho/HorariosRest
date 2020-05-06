<?php
require_once(__DIR__."/../model/GrupoReducidoMapper.php");
require_once(__DIR__."/../model/UsuarioGrupoMapper.php");
require_once(__DIR__."/../model/UsuarioGrupo.php");
require_once(__DIR__ . "/BaseRest.php");
require_once(__DIR__ . "/../model/GrupoReducido.php");
require_once(__DIR__."/../core/ValidationException.php");

class UsuarioGrupoRest extends BaseRest {
    private $usuarioGrupoMapper;

    public function __construct() {
        parent::__construct();

        $this->usuarioGrupoMapper = new UsuarioGrupoMapper();
    }

    public function getUsuariosGrupos($email){
        $usuariosgrupos = $this->usuarioGrupoMapper->getUsuariosGrupos($email);
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($usuariosgrupos));
    }

    public function getUsuariosGruposSinAsignados($email){
        $usuariosgrupos = $this->usuarioGrupoMapper->getGruposSinAsignados($email);
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($usuariosgrupos));
    }


    public function getUsuariosGruposEstudiante($asignatura,$email2){
        $estudiantes = $this->usuarioGrupoMapper->getUsuariosGruposEstudiante($asignatura,$email2);
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($estudiantes));
    }

    public function getUsuariosGruposProfesor($asignatura){
        $estudiantes = $this->usuarioGrupoMapper->getUsuariosGruposProfesor($asignatura);
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($estudiantes));
    }

    public function registrar() {
        $data = $_POST['grupos'];
        $data2 = $_POST['email'];
        $data = json_decode($data, true);
        $data2 = json_decode($data2, true);
        foreach ($data as $value){
            $usuarioGrupo = new UsuarioGrupo($data2, $value['id']);
            $this->usuarioGrupoMapper->registrar($usuarioGrupo);
        }

        header($_SERVER['SERVER_PROTOCOL'] . ' 201 Ok');
        header('Content-Type: application/json');
    }

    public function registrarImportacion() {
        $data = $_POST['grupos'];
        $data2 = $_POST['email'];
        $data = json_decode($data, true);
        $data2 = json_decode($data2, true);
        foreach ($data as $value){
            $usuarioGrupo = new UsuarioGrupo($data2, $value);
            $this->usuarioGrupoMapper->registrar($usuarioGrupo);
        }

        header($_SERVER['SERVER_PROTOCOL'] . ' 201 Ok');
        header('Content-Type: application/json');
    }

    public function eliminar($email,$id){
        $resul = $this->usuarioGrupoMapper->eliminar($email,$id);
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
$usuariogrupo = new UsuarioGrupoRest();
URIDispatcher::getInstance()
    ->map("GET","/usuariogrupo/get/$1", array($usuariogrupo,"getUsuariosGrupos"))
    ->map("GET","/usuariogrupo/get/sinasignados/$1", array($usuariogrupo,"getUsuariosGruposSinAsignados"))
    ->map("GET","/usuariogrupo/getgrupos/$1/$2", array($usuariogrupo,"getUsuariosGruposEstudiante"))
    ->map("GET","/usuariogrupo/getgrupos/profesor/$1/", array($usuariogrupo,"getUsuariosGruposProfesor"))
    ->map("POST","/usuariogrupo/registrar",array($usuariogrupo,"registrar"))
    ->map("POST","/usuariogrupo/registrar/importacion",array($usuariogrupo,"registrarImportacion"))
    ->map("DELETE","/usuariogrupo/eliminar/$1/$2",array($usuariogrupo,"eliminar"));

