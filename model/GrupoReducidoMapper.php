<?php
require_once(__DIR__ ."/../core/PDOConnection.php");

class GrupoReducidoMapper {

    private $db;

    public function __construct() {
        $this->db = PDOConnection::getInstance();
    }

    public function getGrupos() {
        $stmt = $this->db->prepare("SELECT id,id_asignatura,tipo,dia,hora_inicio,hora_fin,aula from gruporeducido");
        $stmt->execute();
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;//devuelve el array con la respuesta
    }

    public function registrarGrupo(GrupoReducido $grupo) {
        $stmt = $this->db->prepare("INSERT INTO gruporeducido values (?,?,?,?,?,?,?)");
        $stmt->execute(array($grupo->getId(), $grupo->getIdAsignatura(), $grupo->getTipo(),$grupo->getDia(),$grupo->getHoraInicio(), $grupo->getHoraFin(),$grupo->getAula()));
    }

    public function eliminar($id) {
        $stmt = $this->db->prepare("DELETE from gruporeducido WHERE id=?");
        if ($stmt->execute(array($id))) {
            return 1;
        } else return 0;
    }
}
