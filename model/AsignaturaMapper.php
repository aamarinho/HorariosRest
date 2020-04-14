<?php
require_once(__DIR__ ."/../core/PDOConnection.php");

class AsignaturaMapper {

    private $db;

    public function __construct() {
        $this->db = PDOConnection::getInstance();
    }

    public function getAsignaturas() {
        $stmt = $this->db->prepare("SELECT id,nombre,email,curso,cuatrimestre from asignatura");
        $stmt->execute();
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;//devuelve el array con la respuesta
    }

}
