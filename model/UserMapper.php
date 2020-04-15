<?php
require_once(__DIR__ ."/../core/PDOConnection.php");

class UserMapper {

    private $db;
    public function __construct() {
        $this->db = PDOConnection::getInstance();
    }


    public function login($username, $passwd) { //cambiar
        $stmt = $this->db->prepare("SELECT count(email) FROM usuario where email=? and contraseña=?");
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

    public function registrarUsuario(Usuario $usuario) {
        $stmt = $this->db->prepare("INSERT INTO usuario values (?,?,?,?,?)");
        $stmt->execute(array($usuario->getEmail(), $usuario->getNombre(), $usuario->getApellidos(), $usuario->getTipo(), $usuario->getContrasena()));
    }
}
