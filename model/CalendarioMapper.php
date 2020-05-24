<?php
require_once(__DIR__ ."/../core/PDOConnection.php");

class CalendarioMapper {

    private $db;

    public function __construct() {
        $this->db = PDOConnection::getInstance();
    }

    public function registrar(GrupoReducido $grupo) {

        $stmt = $this->db->prepare("SELECT asignatura.cuatrimestre FROM asignatura INNER JOIN gruporeducido ON gruporeducido.id_asignatura=asignatura.id WHERE gruporeducido.id=?");
        $stmt->execute(array($grupo->getId()));
        $resul = $stmt->fetch(PDO::FETCH_ASSOC);
        $cuatrimestre=$resul['cuatrimestre'];

        $stmt = $this->db->prepare("SELECT f_inicio_uno,f_fin_uno,f_inicio_dos,f_fin_dos from configuracion WHERE id=1");
        $stmt->execute();
        $resul2 = $stmt->fetch(PDO::FETCH_ASSOC); //aqui tengo los valores de inicio y fin de cuatrimestre, para iterar entre ellos
        if($cuatrimestre==1){
            $fechainicio=$resul2['f_inicio_uno'];
            $fechafin=$resul2['f_fin_uno'];
        } else if($cuatrimestre==2){
            $fechainicio=$resul2['f_inicio_dos'];
            $fechafin=$resul2['f_fin_dos'];
        } else{
            $fechainicio=$resul2['f_inicio_uno'];
            $fechafin=$resul2['f_fin_uno'];
        }

        $fechafin = strtotime($fechafin);
        $fechas=array();
        for($i = strtotime($grupo->getDia(),strtotime($fechainicio)); $i <= $fechafin; $i = strtotime('+1 week', $i)) {
            array_push($fechas,date('Y-m-d', $i));
        }
        $stmt = $this->db->prepare("SELECT usuariogrupo.email FROM usuariogrupo INNER JOIN gruporeducido ON gruporeducido.id=usuariogrupo.id INNER JOIN usuario ON usuario.email=usuariogrupo.email WHERE usuario.tipo=2 AND usuariogrupo.id=?");
        $stmt->execute(array($grupo->getId()));
        $resul = $stmt->fetch(PDO::FETCH_ASSOC);
        $responsable=$resul['email'];

        foreach($fechas as $fecha){
            $stmt = $this->db->prepare("INSERT INTO horario values ('',?,?,?,?,?,?,?,?)");
            $stmt->execute(array("clase",$grupo->getId(),$grupo->getIdAsignatura(), $fecha ,$grupo->getHoraInicio(),$grupo->getHoraFin(), $responsable ,$grupo->getAula()));
        }
    }

    public function getCalendario($email) {
        $stmt = $this->db->prepare("SELECT nombre,id_grupo,id_asignatura,fecha,hora_inicio,hora_fin,responsable,aula FROM horario INNER JOIN usuariogrupo ON horario.id_grupo=usuariogrupo.id WHERE usuariogrupo.email=?");
        $stmt->execute(array($email));
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function getEventos() {
        $stmt = $this->db->prepare("SELECT id,nombre,id_grupo,id_asignatura,fecha,hora_inicio,hora_fin,responsable,aula from horario");
        $stmt->execute();
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function getGruposSinGenerar(){
        $stmt = $this->db->prepare("SELECT gruporeducido.id,gruporeducido.id_asignatura,gruporeducido.tipo,gruporeducido.dia,gruporeducido.hora_inicio,gruporeducido.hora_fin,gruporeducido.aula FROM gruporeducido WHERE gruporeducido.id NOT IN (SELECT DISTINCT horario.id_grupo FROM horario)");
        $stmt->execute();
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function registrarActividadDocente(Calendario $calendario) {
        $stmt = $this->db->prepare("SELECT asignatura.id FROM asignatura INNER JOIN gruporeducido ON gruporeducido.id_asignatura=asignatura.id WHERE gruporeducido.id=?");
        $stmt->execute(array($calendario->getIdgrupo()));
        $asignatura = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $this->db->prepare("INSERT INTO horario values ('',?,?,?,?,?,?,?,?)");
        $stmt->execute(array($calendario->getNombre(),$calendario->getIdgrupo(),$asignatura['id'],  $calendario->getFecha(), $calendario->getHoraInicio(), $calendario->getHoraFin(),$calendario->getResponsable(),$calendario->getAula()));
    }

    public function getActividadDocenteById($id) {
        $stmt = $this->db->prepare("SELECT * FROM horario where id=?");
        $stmt->execute(array($id));
        $resul = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function eliminar($id) {
        $stmt = $this->db->prepare("DELETE from horario WHERE id=?");
        if ($stmt->execute(array($id))) {
            return 1;
        } else return 0;
    }

    public function editarActividadDocente(Calendario $calendario) {
        $stmt = $this->db->prepare("SELECT asignatura.id FROM asignatura INNER JOIN gruporeducido ON gruporeducido.id_asignatura=asignatura.id WHERE gruporeducido.id=?");
        $stmt->execute(array($calendario->getIdgrupo()));
        $asignatura = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $this->db->prepare("UPDATE horario set nombre=?,id_grupo=?,id_asignatura=?,fecha=?,hora_inicio=?,hora_fin=?,responsable=?,aula=? where id=?");
        if($stmt->execute(array($calendario->getNombre(), $calendario->getIdgrupo(), $asignatura['id'], $calendario->getFecha(),$calendario->getHoraInicio(),$calendario->getHoraFin(),$calendario->getResponsable(),$calendario->getAula(),$calendario->getId()))){
            return true;
        } else return false;
    }

}
