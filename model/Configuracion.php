<?php

class Configuracion implements JsonSerializable {
    private $id;
    private $f_inicio_uno;
    private $f_fin_uno;
    private $f_inicio_dos;
    private $f_fin_dos;

    public function __construct($id = NULL, $f_inicio_uno = NULL, $f_fin_uno = NULL, $f_inicio_dos = NULL, $f_fin_dos = NULL) {
        $this->id = $id;
        $this->f_inicio_uno = $f_inicio_uno;
        $this->f_fin_uno = $f_fin_uno;
        $this->f_inicio_dos = $f_inicio_dos;
        $this->f_fin_dos = $f_fin_dos;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return null
     */
    public function getFInicioUno()
    {
        return $this->f_inicio_uno;
    }

    /**
     * @param null $f_inicio_uno
     */
    public function setFInicioUno($f_inicio_uno)
    {
        $this->f_inicio_uno = $f_inicio_uno;
    }

    /**
     * @return null
     */
    public function getFFinUno()
    {
        return $this->f_fin_uno;
    }

    /**
     * @param null $f_fin_uno
     */
    public function setFFinUno($f_fin_uno)
    {
        $this->f_fin_uno = $f_fin_uno;
    }

    /**
     * @return null
     */
    public function getFInicioDos()
    {
        return $this->f_inicio_dos;
    }

    /**
     * @param null $f_inicio_dos
     */
    public function setFInicioDos($f_inicio_dos)
    {
        $this->f_inicio_dos = $f_inicio_dos;
    }

    /**
     * @return null
     */
    public function getFFinDos()
    {
        return $this->f_fin_dos;
    }

    /**
     * @param null $f_fin_dos
     */
    public function setFFinDos($f_fin_dos)
    {
        $this->f_fin_dos = $f_fin_dos;
    }

    public function jsonSerialize() {
        $vars = get_object_vars($this);
        return $vars;
    }
}
