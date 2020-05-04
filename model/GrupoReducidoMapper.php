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

    public function getGrupoById($id) {
        $stmt = $this->db->prepare("SELECT gruporeducido.id,gruporeducido.id_asignatura,gruporeducido.tipo,gruporeducido.dia,gruporeducido.hora_inicio,gruporeducido.hora_fin,gruporeducido.aula,asignatura.nombre FROM gruporeducido INNER JOIN asignatura ON asignatura.id=gruporeducido.id_asignatura WHERE gruporeducido.id=?");
        $stmt->execute(array($id));
        $resul = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function countGrupos($idasignatura) {
        $stmt = $this->db->prepare("SELECT COUNT(gruporeducido.id) AS contador FROM gruporeducido INNER JOIN asignatura ON gruporeducido.id_asignatura=asignatura.id WHERE asignatura.id=? AND gruporeducido.id NOT LIKE '%GG'");
        $stmt->execute(array($idasignatura));
        $resul = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function registrarGrupo(GrupoReducido $grupo) {
        $stmt = $this->db->prepare("INSERT INTO gruporeducido values (?,?,?,?,?,?,?)");
        $stmt->execute(array($grupo->getId(), $grupo->getIdAsignatura(), $grupo->getTipo(),$grupo->getDia(),$grupo->getHoraInicio(), $grupo->getHoraFin(),$grupo->getAula()));
    }

    public function editarGrupo(GrupoReducido $grupo) {
        $stmt = $this->db->prepare("UPDATE gruporeducido set id_asignatura=?,tipo=?,dia=?,hora_inicio=?,hora_fin=?,aula=? where id=?");
        if($stmt->execute(array($grupo->getIdAsignatura(), $grupo->getTipo(), $grupo->getDia(),$grupo->getHoraInicio(),$grupo->getHoraFin(),$grupo->getAula(),$grupo->getId()))){
            return true;
        } else return false;
    }

    public function eliminar($id) {
        $stmt = $this->db->prepare("DELETE from gruporeducido WHERE id=?");
        if ($stmt->execute(array($id))) {
            return 1;
        } else return 0;
    }
}
