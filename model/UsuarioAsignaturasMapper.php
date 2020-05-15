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

    public function registrarImportacion(UsuarioAsignaturas $usuarioasignaturas) {
        $stmt = $this->db->prepare("INSERT INTO usuarioasignatura values (?,?)");
        $stmt->execute(array($usuarioasignaturas->getEmail(), $usuarioasignaturas->getId()));

        $stmt = $this->db->prepare("UPDATE asignatura set email=? where id=?");
        $stmt->execute(array($usuarioasignaturas->getEmail(), $usuarioasignaturas->getId()));

        $stmt = $this->db->prepare("SELECT gruporeducido.id FROM gruporeducido WHERE gruporeducido.id_asignatura=?");
        $stmt->execute(array($usuarioasignaturas->getId()));
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($resul as $grupo){
            $stmt = $this->db->prepare("INSERT INTO usuariogrupo values (?,?)");
            $stmt->execute(array($usuarioasignaturas->getEmail(), $grupo['id']));
        }
    }

    public function getUsuariosAsignaturas($email) {
        $stmt = $this->db->prepare("SELECT id FROM usuarioasignatura where email=?");
        $stmt->execute(array($email));
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function getUsuariosAsignaturasSinAsignados($email) {
        $stmt = $this->db->prepare("SELECT DISTINCT asignatura.id, asignatura.nombre, asignatura.curso FROM asignatura INNER JOIN usuarioasignatura ON usuarioasignatura.id=asignatura.id WHERE asignatura.id NOT IN (SELECT usuarioasignatura.id FROM usuarioasignatura WHERE usuarioasignatura.email=?)");
        $stmt->execute(array($email));
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function eliminar($email,$id) {
        $stmt = $this->db->prepare("DELETE from usuarioasignatura WHERE email=? AND id=?");
        if ($stmt->execute(array($email,$id))) {
            return 1;
        } else return 0;
    }
}
