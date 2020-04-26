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
        $userArray = $this->userMapper->getEstudiantes();//en $userArray tenemos el array de los estudiantes (usuarios tipo=3)
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');//manda la cabecera server protocol con 200 ok
        header('Content-Type: application/json');//manda la cabecera content-type que es json
        echo(json_encode($userArray)); //devuelve un string del objeto json. ¿como le da el dato?
    }

    public function getProfesores(){
        $userArray = $this->userMapper->getProfesores();
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($userArray));
    }

    public function getUsuarios(){
        $userArray = $this->userMapper->getUsuarios();
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($userArray));
    }

    public function registrar(){
        $data = $_POST['usuario'];
        $data = json_decode($data,true);
        $user = new Usuario($data['email'],$data['nombre'],$data['apellidos'],$data['tipo'],$data['contrasena']);

        $this->userMapper->registrarUsuario($user);
        header($_SERVER['SERVER_PROTOCOL'].' 201 Ok');
        header('Content-Type: application/json');
    }

    public function getEstudiantesProfesor($email){
        $estudiantes = $this->userMapper->getEstudiantesProfesor($email);
        print_r($estudiantes);
        /*header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($estudiantes));*/
    }

}

// URI-MAPPING for this Rest endpoint
$userRest = new UsuarioRest();
URIDispatcher::getInstance()
    ->map("GET","/usuario/$1", array($userRest,"login"))
    ->map("GET","/usuario/estudiantes/",array($userRest,"getEstudiantes"))
    ->map("GET","/usuario/profesores/",array($userRest,"getProfesores"))
    ->map("GET","/usuario/usuarios/",array($userRest,"getUsuarios"))
    ->map("GET","/usuario/get/estudiantes/$1", array($userRest,"getEstudiantesProfesor"))
    ->map("POST","/usuario/registro/",array($userRest,"registrar"));
