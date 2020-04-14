<?php

class GrupoReducido implements JsonSerializable{
    private $id;
    private $id_asignatura;
    private $hora_inicio;
    private $hora_fin;

    public function __construct($id=NULL,$id_asignatura=NULL,$hora_inicio=NULL,$hora_fin=NULL) {
        $this->id=$id;
        $this->id_asignatura=$id_asignatura;
        $this->hora_inicio=$hora_inicio;
        $this->hora_fin=$hora_fin;
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

    public function jsonSerialize() {
        $vars = get_object_vars($this);
        return $vars;
    }
}
