<?php
require_once(__DIR__ ."/../core/PDOConnection.php");

class GrupoReducidoMapper {

    private $db;

    public function __construct() {
        $this->db = PDOConnection::getInstance();
    }

    public function getGrupos() {
        $stmt = $this->db->prepare("SELECT id,id_asignatura,hora_inicio,hora_fin from gruporeducido");
        $stmt->execute();
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;//devuelve el array con la respuesta
    }

    public function registrarGrupo(GrupoReducido $grupo) {
        $stmt = $this->db->prepare("INSERT INTO gruporeducido values (?,?,?,?)");
        $stmt->execute(array($grupo->getId(), $grupo->getIdAsignatura(), $grupo->getHoraInicio(), $grupo->getHoraFin()));
    }
}
