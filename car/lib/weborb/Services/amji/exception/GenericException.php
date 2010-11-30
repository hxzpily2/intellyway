<?php

class GenericException extends Exception{
	public $code;

	public function __construct($message,$code)
	{
		$this->code = $code;
		$this->message = $message;
	}
}

?>