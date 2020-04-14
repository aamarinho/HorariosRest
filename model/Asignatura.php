<?php

class Asignatura implements JsonSerializable{
    private $id;
    private $nombre;
    private $email;
    private $curso;
    private $cuatrimestre;

    public function __construct($id=NULL,$nombre=NULL,$email=NULL,$curso=NULL,$cuatrimestre=NULL) {
        $this->id=$id;
        $this->nombre=$nombre;
        $this->email=$email;
        $this->curso=$curso;
        $this->cuatrimestre=$cuatrimestre;
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param null $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return null
     */
    public function getCurso()
    {
        return $this->curso;
    }

    /**
     * @param null $curso
     */
    public function setCurso($curso)
    {
        $this->curso = $curso;
    }

    /**
     * @return null
     */
    public function getCuatrimestre()
    {
        return $this->cuatrimestre;
    }

    /**
     * @param null $cuatrimestre
     */
    public function setCuatrimestre($cuatrimestre)
    {
        $this->cuatrimestre = $cuatrimestre;
    }

    public function jsonSerialize() {
        $vars = get_object_vars($this);
        return $vars;
    }
}
