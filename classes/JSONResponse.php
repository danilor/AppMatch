<?php


class JSONResponse {
	private $status = 0;
	private $error_id = 0;
	private $error_description = '';
	private $data = null;

	public function __construct() {

	}

	public function getStatus() {
		return $this->status;
	}

	public function setStatus( $status ) {
		$this->status = $status;
	}

	public function setError( $id , $desc){
		$this -> error_id = $id;
		$this -> error_description = $desc;
	}

	public function setData( $data ){
		$this -> data = $data;
	}

	public function constructResponse(){
		$r = [];
		$r[ "error" ][ "id" ]           =       $this -> error_id;
		$r[ "error" ][ "desc" ]         =       $this -> error_description;
		$r[ "data" ]                    =       $this -> data;
		return $r;
	}

	public function printResponse( $header = true ){
		if( $header ) header('Content-Type: application/json');
		echo json_encode( $this->constructResponse() );
	}

}