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
        $userArray = $this->userMapper->getEstudiantes();
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($userArray));
    }

}

// URI-MAPPING for this Rest endpoint
$userRest = new UsuarioRest();
URIDispatcher::getInstance()
    ->map("GET","/usuario/$1", array($userRest,"login"))
    ->map("GET","/usuario/estudiantes/",array($userRest,"getEstudiantes"));
