<?php
require_once(__DIR__ ."/../core/PDOConnection.php");

class UsuarioGrupoMapper {

    private $db;

    public function __construct() {
        $this->db = PDOConnection::getInstance();
    }

    public function getUsuariosGrupos($email) {
        $stmt = $this->db->prepare("SELECT id FROM usuariogrupo where email=?");
        $stmt->execute(array($email));
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function registrar(UsuarioGrupo $usuariogrupo) {
        $stmt = $this->db->prepare("INSERT INTO usuariogrupo values (?,?)");
        $stmt->execute(array($usuariogrupo->getEmail(), $usuariogrupo->getId()));
    }

    public function eliminar($email,$id) {
        $stmt = $this->db->prepare("DELETE from usuariogrupo WHERE email=? AND id=?");
        if ($stmt->execute(array($email,$id))) {
            return 1;
        } else return 0;
    }

    public function getUsuariosGruposEstudiante($asignatura,$email2) {
        $stmt = $this->db->prepare("SELECT usuariogrupo.id FROM usuariogrupo INNER JOIN gruporeducido ON gruporeducido.id=usuariogrupo.id INNER JOIN asignatura ON asignatura.id=gruporeducido.id_asignatura WHERE usuariogrupo.email=? AND asignatura.id=?");
        $stmt->execute(array($email2,$asignatura));
        $grupo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $grupos=array();
        foreach ($grupo as $g){
            array_push($grupos,$g);
        }
        return $grupos;
    }

    public function getUsuariosGruposProfesor($asignatura) {
        $stmt = $this->db->prepare("SELECT DISTINCT gruporeducido.id,gruporeducido.tipo,gruporeducido.id_asignatura FROM usuariogrupo INNER JOIN gruporeducido ON gruporeducido.id=usuariogrupo.id INNER JOIN asignatura ON asignatura.id=gruporeducido.id_asignatura WHERE asignatura.id=?");
        $stmt->execute(array($asignatura));
        $grupo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $grupos=array();
        foreach ($grupo as $g){
            array_push($grupos,$g);
        }
        return $grupos;
    }
}
