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
        return $resul;
    }

    public function getAsignaturaById($id) {
        $stmt = $this->db->prepare("SELECT asignatura.id,asignatura.nombre as nombrea,asignatura.email,asignatura.curso,asignatura.cuatrimestre, usuario.nombre AS nombreu, usuario.apellidos FROM asignatura  INNER JOIN usuario ON asignatura.email=usuario.email WHERE asignatura.id=?");
        $stmt->execute(array($id));
        $resul = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function getAsignaturasProfesor($email) {
        $stmt = $this->db->prepare("SELECT DISTINCT asignatura.id,asignatura.nombre,asignatura.curso,asignatura.cuatrimestre FROM asignatura INNER JOIN usuarioasignatura ON asignatura.id=usuarioasignatura.id WHERE asignatura.email=?");
        $stmt->execute(array($email));
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function registrarAsignatura(Asignatura $asignatura) { //registra la asignatura, y además añade a la tabla usuarioasignatura el profesor junto con la asignatura asignada.
        $stmt = $this->db->prepare("INSERT INTO asignatura values (?,?,?,?,?)");
        $stmt->execute(array($asignatura->getId(), $asignatura->getNombre(), $asignatura->getEmail(), $asignatura->getCurso(), $asignatura->getCuatrimestre()));
        $stmt2 = $this->db->prepare("INSERT INTO usuarioasignatura values (?,?)");
        $stmt2->execute(array($asignatura->getEmail(),$asignatura->getId()));
    }

    public function editarAsignatura(Asignatura $asignatura) {
        $stmt = $this->db->prepare("UPDATE asignatura set nombre=?,email=?,curso=?,cuatrimestre=? where id=?");
        if($stmt->execute(array($asignatura->getNombre(), $asignatura->getEmail(), $asignatura->getCurso(),$asignatura->getCuatrimestre(),$asignatura->getId()))){
            return true;
        } else return false;
    }

    public function eliminar($id) {
        $stmt = $this->db->prepare("DELETE from asignatura WHERE id=?");
        if ($stmt->execute(array($id))) {
            return 1;
        } else return 0;
    }
}
