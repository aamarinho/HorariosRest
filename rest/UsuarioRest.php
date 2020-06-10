<?php
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__."/../core/ValidationException.php");
require_once(__DIR__."/../model/UserMapper.php");
require_once(__DIR__ . "/BaseRest.php");

/**
* Class UsuarioRest
*
* It contains operations for adding and check users credentials.
* Methods gives responses following Restful standards. Methods of this class
* are intended to be mapped as callbacks using the URIDispatcher class.
*
*/
class UsuarioRest extends BaseRest {
	private $userMapper;

	public function __construct() {
		parent::__construct();

		$this->userMapper = new UserMapper();
	}

	public function login($email) {
		$currentLogged = parent::usuarioAutenticado();
		if ($currentLogged->getEmail() != $email) {
			header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
			echo("You are not authorized to login as anyone but you");
		} else {
			header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            header('Content-Type: application/json');
            echo(json_encode($currentLogged->jsonSerialize()));
		}
	}

    public function getEstudiantes(){
        parent::comprobarTipo(1);
        $userArray = $this->userMapper->getEstudiantes();//en $userArray tenemos el array de los estudiantes (usuarios tipo=3)
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');//manda la cabecera server protocol con 200 ok
        header('Content-Type: application/json');//manda la cabecera content-type que es json
        echo(json_encode($userArray)); //devuelve un string del objeto json. ¿como le da el dato?
    }

    public function getProfesores(){
        parent::comprobarTipo(1);
        $userArray = $this->userMapper->getProfesores();
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($userArray));
    }

    public function getUsuarios(){
        parent::comprobarTipo(1);
        $userArray = $this->userMapper->getUsuarios();
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($userArray));
    }

    public function registrar(){
        parent::comprobarTipo(1);
        $data = $_POST['usuario'];
        $data = json_decode($data,true);
        $user = new Usuario($data['email'],$data['nombre'],$data['apellidos'],$data['tipo'],$data['contrasena']);

        $this->userMapper->registrarUsuario($user);
        header($_SERVER['SERVER_PROTOCOL'].' 201 Ok');
        header('Content-Type: application/json');
    }

    public function registrarIndividual(){
        parent::comprobarTipo(1);
        $data = $_POST['usuario'];
        $data = json_decode($data,true);
        $user = new Usuario($data['email'],$data['nombre'],$data['apellidos'],$data['tipo'],$data['contrasena']);

        $this->userMapper->registrarUsuarioIndividual($user);
        header($_SERVER['SERVER_PROTOCOL'].' 201 Ok');
        header('Content-Type: application/json');
    }

    public function editar(){
        $data = $_POST['usuario'];
        $data = json_decode($data,true);
        $usuario = new Usuario($data['email'],$data['nombre'],$data['apellidos'],$data['tipo'],$data['contrasena']);

        $this->userMapper->editarUsuario($usuario);
        header($_SERVER['SERVER_PROTOCOL'].' 201 Ok');
        header('Content-Type: application/json');
    }

    public function getEstudiantesProfesor($asignatura){
        parent::comprobarTipo(2);
        $estudiantes = $this->userMapper->getEstudiantesProfesor($asignatura);
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($estudiantes));
    }

    public function getEstudiantesParaMatricular($asignatura){
        parent::comprobarTipo(2);
        $estudiantes = $this->userMapper->getEstudiantesParaMatricular($asignatura);
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($estudiantes));
    }

    public function getEstudiantesProfesorByEmail($email){
	    parent::comprobarVariosTipos(1,2);
        $estudiantes = $this->userMapper->getEstudiantesProfesorByEmail($email);
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($estudiantes));
    }

    public function getUsuario($email){
        $usuario = $this->userMapper->getUsuarioByEmail($email);
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($usuario));
    }

    public function eliminar($email){
        parent::comprobarTipo(1);
        $resul = $this->userMapper->eliminar($email);
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

// URI-MAPPING for this Rest endpoint
$userRest = new UsuarioRest();
URIDispatcher::getInstance()
    ->map("GET","/usuario/$1", array($userRest,"login"))
    ->map("GET","/usuario/estudiantes/",array($userRest,"getEstudiantes"))
    ->map("GET","/usuario/profesores/",array($userRest,"getProfesores"))
    ->map("GET","/usuario/usuarios/",array($userRest,"getUsuarios"))
    ->map("GET","/usuario/get/estudiantes/$1/", array($userRest,"getEstudiantesProfesor"))
    ->map("GET","/usuario/get/estudiantes/paramatricular/$1/", array($userRest,"getEstudiantesParaMatricular"))
    ->map("GET","/usuario/get/estudiantes/profesor/$1/", array($userRest,"getEstudiantesProfesorByEmail"))
    ->map("GET","/usuario/getusuarios/$1", array($userRest,"getUsuario"))
    ->map("POST","/usuario/registro/",array($userRest,"registrar"))
    ->map("POST","/usuario/registro/individual/",array($userRest,"registrarIndividual"))
    ->map("POST","/usuario/editar/",array($userRest,"editar"))
    ->map("DELETE","/usuario/eliminar/$1",array($userRest,"eliminar"));
