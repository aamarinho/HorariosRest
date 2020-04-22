<?php
require_once(__DIR__ ."/../core/PDOConnection.php");

class CalendarioMapper {

    private $db;

    public function __construct() {
        $this->db = PDOConnection::getInstance();
    }

    public function registrarCalendario(GrupoReducido $grupo) {
        $stmt = $this->db->prepare("SELECT f_inicio_uno,f_fin_uno,f_inicio_dos,f_fin_dos from configuracion WHERE id=1");
        $stmt->execute();
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC); //aqui tengo los valores de inicio y fin de cuatrimestre, para iterar entre ellos
        //obtener valor de $fecha iterando y obtener valor de $responsable de la tabla usuariogrupo

        $stmt = $this->db->prepare("INSERT INTO calendario values (?,?,?,?,?,?)");
        //$stmt->execute(array($grupo->getId(), $fecha ,$grupo->getHoraInicio(),$grupo->getHoraFin(), $responsable ,$grupo->getAula()));

    }
}
