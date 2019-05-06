<?php
chdir("../");
require_once ( "auto.php" );

$response = new JSONResponse();

$fid        =       @$_REQUEST[ "fids" ];

/** We check for the username information */
if( $fid === null || $fid === "" || empty( $fid ) ){
	$response->setError( 1  , "Friends IDs Missing");
	$response->setData( $_REQUEST );
	$response->printResponse();
	exit();
}

$friends        =       explode("," , $fid);
$friends        =       array_filter($friends);


/**
 * First we are going to close all user information likes from the database
 */

$friends_string = "'" . implode("','" , $friends ) . "'";

$query = "SELECT DISTINCT (user_id), user_name FROM likes WHERE user_id IN ($friends_string) AND active = 1";
$res = DB::query( $query  );

$data = [];

foreach( $res AS $r ){
	$data[] = ["id"=>$r["user_id"],"name"=>$r["user_name"]];
}

$response->setData([ "success" => true , "friends" => $data ]);

/**
 * We print the response
 */
$response->printResponse();