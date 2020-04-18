<?php

class UsuarioAsignaturas implements JsonSerializable{
    private $email;
    private $id;

    public function __construct($email=NULL,$id=NULL) {
        $this->email=$email;
        $this->id=$id;
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

    public function jsonSerialize() {
        $vars = get_object_vars($this);
        return $vars;
    }
}
