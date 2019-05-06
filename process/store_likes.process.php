<?php
chdir("../");
require_once ( "auto.php" );

$response = new JSONResponse();

$user_id        =       @$_REQUEST[ "user_id" ];
$user_name      =       @$_REQUEST[ "user_name" ];
$likes          =       @$_REQUEST[ "likes" ];

/** We check for the username information */
if( $user_id === null || $user_id === "" || empty( $user_id ) ){
	$response->setError( 1  , "User ID Missing");
	$response->setData( $_REQUEST );
	$response->printResponse();
	exit();
}

/**
 * We check now for the likes information
 */
if( $likes === null || empty( $likes )  ){
	$response->setError( 2  , "Likes Missing");
	$response->printResponse();
	exit();
}

/**
 * First we are going to close all user information likes from the database
 */

DB::update('likes', array(
	'active' => '0'
), "user_id=%s", $user_id); // We close all active likes from the user

/**
 * Now we are inserting the new likes
 */
$inserting_rows = [];
$likes = explode( "[|]" , $likes );

foreach( $likes AS $key => $like ){

	$divided_like = explode( ";;" , $like );

	try{
		if( !is_null( @$divided_like[ 1 ] ) ){
			$inserting_rows[]       =   @[
				"user_id"               =>          $user_id,
				"user_name"             =>          $user_name,
				"like_id"               =>          $divided_like[ 0 ],
				"like_name"             =>          $divided_like[ 1 ],
			];
		}
	}catch (\Exception $e){
		// We wont do nothing in the meantime
	}
}
// Now we insert the information
DB::insert('likes', $inserting_rows);

$response->setData([ "success" => true ]);

/**
 * We print the response
 */
$response->printResponse();