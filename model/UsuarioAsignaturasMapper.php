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
}
