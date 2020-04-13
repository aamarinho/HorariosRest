<?php
//file: core/ValidationException.php

/**
* Class ValidationException
* 
* A simple Exception including an array of errors
* useful for form validation.
* The errors array contains validation errors, normally
* indexed by form named parameters.
*
* @author lipido <lipido@gmail.com>
*/
class ValidationException extends Exception {

	/**
	* Array of errors
	* @var mixed
	*/
	private $error;

	public function __construct(String $error, $msg=NULL){
		parent::__construct($msg);
		$this->error = $error;
	}

	/**
	* Gets the validation errors
	*
	* @return mixed The validation errors
	*/
	public function getError() {
		return $this->error;
	}
}
