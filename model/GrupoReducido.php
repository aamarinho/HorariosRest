<?php

class GrupoReducido implements JsonSerializable{
    private $id;
    private $id_asignatura;
    private $tipo;
    private $dia;
    private $hora_inicio;
    private $hora_fin;
    private $aula;

    public function __construct($id=NULL,$id_asignatura=NULL,$tipo=NULL,$dia=NULL,$hora_inicio=NULL,$hora_fin=NULL,$aula=NULL) {
        $this->id=$id;
        $this->id_asignatura=$id_asignatura;
        $this->tipo=$tipo;
        $this->dia=$dia;
        $this->hora_inicio=$hora_inicio;
        $this->hora_fin=$hora_fin;
        $this->aula=$aula;
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
    public function getIdAsignatura()
    {
        return $this->id_asignatura;
    }

    /**
     * @param null $id_asignatura
     */
    public function setIdAsignatura($id_asignatura)
    {
        $this->id_asignatura = $id_asignatura;
    }

    /**
     * @return null
     */
    public function getHoraInicio()
    {
        return $this->hora_inicio;
    }

    /**
     * @param null $hora_inicio
     */
    public function setHoraInicio($hora_inicio)
    {
        $this->hora_inicio = $hora_inicio;
    }

    /**
     * @return null
     */
    public function getHoraFin()
    {
        return $this->hora_fin;
    }

    /**
     * @param null $hora_fin
     */
    public function setHoraFin($hora_fin)
    {
        $this->hora_fin = $hora_fin;
    }

    /**
     * @return null
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param null $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @return null
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * @param null $dia
     */
    public function setDia($dia)
    {
        $this->dia = $dia;
    }

    /**
     * @return null
     */
    public function getAula()
    {
        return $this->aula;
    }

    /**
     * @param null $aula
     */
    public function setAula($aula)
    {
        $this->aula = $aula;
    }

    public function jsonSerialize() {
        $vars = get_object_vars($this);
        return $vars;
    }
}
