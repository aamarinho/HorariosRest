<?php
require_once(__DIR__ ."/../core/PDOConnection.php");

class UserMapper {

    private $db;
    public function __construct() {
        $this->db = PDOConnection::getInstance();
    }


    public function login($username, $passwd) { //cambiar
        $stmt = $this->db->prepare("SELECT count(email) FROM usuario where email=? and contrasena=?");
        $stmt->execute(array($username, $passwd));
        if ($stmt->fetchColumn() > 0) {
            return true;
        }
    }

    public function getUsuarioByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM usuario where email=?");
        $stmt->execute(array($email));
        $resul = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function getEstudiantes() {
        $stmt = $this->db->prepare("SELECT email,nombre,apellidos,tipo from usuario WHERE tipo=3");
        $stmt->execute();
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;//devuelve el array con la respuesta
    }

    public function getProfesores() {
        $stmt = $this->db->prepare("SELECT email,nombre,apellidos,tipo from usuario WHERE tipo=2");
        $stmt->execute();
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function getUsuarios() {
        $stmt = $this->db->prepare("SELECT email,nombre,apellidos,tipo from usuario");
        $stmt->execute();
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function registrarUsuario(Usuario $usuario) {
        $stmt = $this->db->prepare("INSERT INTO usuario values (?,?,?,?,?)");
        $stmt->execute(array($usuario->getEmail(), $usuario->getNombre(), $usuario->getApellidos(), $usuario->getTipo(), $usuario->getContrasena()));
    }

    public function editarUsuario(Usuario $usuario) {
        $stmt = $this->db->prepare("UPDATE usuario set nombre=?,apellidos=?,tipo=?,contrasena=? where email=?");
        if($stmt->execute(array($usuario->getNombre(), $usuario->getApellidos(), $usuario->getTipo(), $usuario->getContrasena(),$usuario->getEmail()))){
         return true;
        } else return false;
    }

    public function eliminar($email) {
        $stmt = $this->db->prepare("DELETE from usuario WHERE email=?");
        if ($stmt->execute(array($email))) {
            return 1;
        } else return 0;
    }

    public function getEstudiantesProfesor($email) {//REVISAAAAAAAAAAAR

        $stmt = $this->db->prepare("SELECT asignatura.id FROM asignatura INNER JOIN usuarioasignatura ON usuarioasignatura.id=asignatura.id  INNER JOIN usuario ON usuarioasignatura.email=usuario.email WHERE usuario.email=?");
        $stmt->execute(array($email));
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $estudiantes=array();
        foreach ($resul as $value){
            $stmt = $this->db->prepare("SELECT usuario.email,usuario.nombre,usuario.apellidos FROM usuario INNER JOIN usuarioasignatura ON usuarioasignatura.email=usuario.email INNER JOIN asignatura ON usuarioasignatura.id=asignatura.id WHERE asignatura.id=? AND usuario.tipo=3");
            $stmt->execute(array($value['id']));
            $estudiante = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($estudiante as $e){
                if(!array_key_exists($e['email'],$estudiantes)){
                    array_push($estudiantes,$estudiante);
                }
            }

        }
        return $estudiantes;
    }
}
