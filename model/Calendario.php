<?php

class Calendario implements JsonSerializable {
    private $id;
    private $nombre;
    private $idgrupo;
    private $idasignatura;
    private $fecha;
    private $hora_inicio;
    private $hora_fin;
    private $responsable;
    private $aula;

    public function __construct($id = NULL, $nombre = NULL,$idgrupo = NULL, $idasignatura = NULL,$fecha = NULL, $hora_inicio = NULL, $hora_fin = NULL,$responsable = NULL, $aula = NULL)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->idgrupo = $idgrupo;
        $this->idasignatura = $idasignatura;
        $this->fecha = $fecha;
        $this->hora_inicio = $hora_inicio;
        $this->hora_fin = $hora_fin;
        $this->responsable = $responsable;
        $this->aula = $aula;
    }

    /**
     * @return null
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param null $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return null
     */
    public function getIdasignatura()
    {
        return $this->idasignatura;
    }

    /**
     * @param null $idasignatura
     */
    public function setIdasignatura($idasignatura)
    {
        $this->idasignatura = $idasignatura;
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
    public function getIdgrupo()
    {
        return $this->idgrupo;
    }

    /**
     * @param null $idgrupo
     */
    public function setIdgrupo($idgrupo)
    {
        $this->idgrupo = $idgrupo;
    }

    /**
     * @return null
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param null $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
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
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * @param null $responsable
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;
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
