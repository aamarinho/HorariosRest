<?php
require_once(__DIR__ ."/../core/PDOConnection.php");

class UserMapper {

    private $db;
    public function __construct() {
        $this->db = PDOConnection::getInstance();
    }


    public function login($username, $passwd) {
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
        return $resul;
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
        $stmt = $this->db->prepare("INSERT INTO usuario (email,nombre,apellidos,tipo,contrasena) VALUES (?,?,?,?,?) ON DUPLICATE KEY UPDATE email =?");
        $stmt->execute(array($usuario->getEmail(), $usuario->getNombre(), $usuario->getApellidos(), $usuario->getTipo(), $usuario->getContrasena(),$usuario->getEmail()));
    }

    public function registrarUsuarioIndividual(Usuario $usuario) {
        $stmt = $this->db->prepare("INSERT INTO usuario VALUES (?,?,?,?,?)");
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

    public function getEstudiantesProfesor($asignatura) {
        $stmt = $this->db->prepare("SELECT usuario.email,usuario.nombre,usuario.apellidos FROM usuario INNER JOIN usuarioasignatura ON usuarioasignatura.email=usuario.email INNER JOIN asignatura ON usuarioasignatura.id=asignatura.id WHERE asignatura.id=? AND usuario.tipo=3");
        $stmt->execute(array($asignatura));
        $estudiante = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $estudiantes=array();
        foreach ($estudiante as $e){
            array_push($estudiantes,$e);
        }
        return $estudiantes;
    }

    public function getEstudiantesParaMatricular($asignatura) {
        $stmt = $this->db->prepare("SELECT usuario.email,usuario.nombre,usuario.apellidos FROM usuario WHERE usuario.email NOT IN (SELECT usuarioasignatura.email FROM usuarioasignatura INNER JOIN asignatura ON usuarioasignatura.id=asignatura.id WHERE asignatura.id=?) AND usuario.tipo=3");
        $stmt->execute(array($asignatura));
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function getEstudiantesProfesorByEmail($email) {
        $stmt = $this->db->prepare("SELECT DISTINCT usuario.email,usuario.nombre,usuario.apellidos FROM usuario INNER JOIN usuarioasignatura ON usuarioasignatura.email=usuario.email INNER JOIN asignatura ON usuarioasignatura.id=asignatura.id WHERE asignatura.email=? AND usuario.tipo=3");
        $stmt->execute(array($email));
        $estudiante = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $estudiantes=array();
        foreach ($estudiante as $e){
            array_push($estudiantes,$e);
        }
        return $estudiantes;
    }
}
