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
            $stmt = $this->db->prepare("INSERT INTO calendario values ('',?,?,?,?,?,?)");
            $stmt->execute(array($grupo->getId(), $fecha ,$grupo->getHoraInicio(),$grupo->getHoraFin(), $responsable ,$grupo->getAula()));
        }
    }
}