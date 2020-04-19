<?php
require_once(__DIR__ ."/../core/PDOConnection.php");

class UsuarioAsignaturasMapper {

    private $db;

    public function __construct() {
        $this->db = PDOConnection::getInstance();
    }

    public function registrar(UsuarioAsignaturas $usuarioasignaturas) {
        $stmt = $this->db->prepare("INSERT INTO usuarioasignatura values (?,?)");
        $stmt->execute(array($usuarioasignaturas->getEmail(), $usuarioasignaturas->getId()));
    }

    public function getUsuariosAsignaturas($email) {
        $stmt = $this->db->prepare("SELECT id FROM usuarioasignatura where email=?");
        $stmt->execute(array($email));
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;
    }
}
