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

    public function getUsuariosGruposEstudiante($email,$email2) {
        $stmt = $this->db->prepare("SELECT asignatura.id FROM asignatura INNER JOIN usuarioasignatura ON usuarioasignatura.id=asignatura.id  INNER JOIN usuario ON usuarioasignatura.email=usuario.email WHERE usuario.email=?");
        $stmt->execute(array($email));
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $grupos=array();
        $filtro=array();
        foreach ($resul as $value){
            $stmt = $this->db->prepare("SELECT usuariogrupo.id FROM usuariogrupo INNER JOIN gruporeducido ON gruporeducido.id=usuariogrupo.id INNER JOIN asignatura ON asignatura.id=gruporeducido.id_asignatura WHERE usuariogrupo.email=? AND asignatura.id=?");
            $stmt->execute(array($email2,$value['id']));
            $grupo = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $temp=0;
            foreach ($grupo as $g){
                if(!array_key_exists($temp,$filtro)){
                    array_push($filtro,$g['id']);
                    array_push($grupos,$g);
                }
                $temp++;
            }
        }
        return $grupos;
    }

    public function getUsuariosGruposProfesor($email) {
        $stmt = $this->db->prepare("SELECT DISTINCT asignatura.id FROM usuarioasignatura INNER JOIN asignatura ON asignatura.id=usuarioasignatura.id WHERE asignatura.email=?");
        $stmt->execute(array($email));
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $grupos=array();
        $filtro=array();
        foreach ($resul as $value){
            $stmt = $this->db->prepare("SELECT DISTINCT gruporeducido.id,gruporeducido.tipo,gruporeducido.id_asignatura FROM usuariogrupo INNER JOIN gruporeducido ON gruporeducido.id=usuariogrupo.id INNER JOIN asignatura ON asignatura.id=gruporeducido.id_asignatura WHERE asignatura.id=?");
            $stmt->execute(array($value['id']));
            $grupo = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $temp=0;
            foreach ($grupo as $g){
                if(!array_key_exists($temp,$filtro)){
                    array_push($filtro,$g['id']);
                    array_push($grupos,$g);
                }
                $temp++;
            }
        }
        return $grupos;
    }
}
