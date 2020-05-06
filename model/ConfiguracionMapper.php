<?php
require_once(__DIR__ ."/../core/PDOConnection.php");

class ConfiguracionMapper {

    private $db;

    public function __construct() {
        $this->db = PDOConnection::getInstance();
    }

    public function getConfiguracion() {
        $stmt = $this->db->prepare("SELECT * FROM configuracion where id=1");
        $stmt->execute();
        $resul = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function editar(Configuracion $configuracion) {
        $stmt = $this->db->prepare("UPDATE configuracion set f_inicio_uno=?,f_fin_uno=?,f_inicio_dos=?,f_fin_dos=? where id=1");
        if($stmt->execute(array($configuracion->getFInicioUno(), $configuracion->getFFinUno(), $configuracion->getFInicioDos(), $configuracion->getFFinDos()))){
            return true;
        } else return false;
    }
}
