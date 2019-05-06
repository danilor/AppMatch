<?php
chdir("../");
require_once ( "auto.php" );

$response = new JSONResponse();

$user_id        =       @$_REQUEST[ "user_id" ];
$fids           =       @$_REQUEST[ "fids" ];

/** We check for the username information */
if( $user_id === null || $user_id === "" || empty( $user_id ) ){
	$response->setError( 1  , "User ID Missing");
	$response->setData( $_REQUEST );
	$response->printResponse();
	exit();
}
if( $fids === null || $fids === "" || empty( $fids ) ){
	$response->setError( 2  , "Friends IDs Missing");
	$response->setData( $_REQUEST );
	$response->printResponse();
	exit();
}

$friends        =       explode("," , $fids);
$friends        =       array_filter($friends);

$friends_string = "'" . implode("','" , $friends ) . "'";

/**
 * First we get the total likes from the current user
 */
$likes      =       [];
$res = DB::query("SELECT * FROM likes WHERE user_id=%s AND active = %i", $user_id, 1);

foreach( $res AS $r ){
	$likes[] = $r[ "like_id" ];
}
/**
 * Now we get the list of friends and their matchs
 */

$friends_points = [];

$res = DB::query("SELECT * FROM likes WHERE user_id IN ($friends_string) AND active = 1");

foreach( $res AS $r ){
	if( !isset( $friends_points[ $r["user_id"] ] ) ){
		$friends_points[ $r["user_id"] ] = new \stdClass();
		$friends_points[ $r["user_id"] ]->name    =   $r["user_name"];
		$friends_points[ $r["user_id"] ]->id      =   $r["user_id"];
		$friends_points[ $r["user_id"] ]->points  =   0;
	}

	if(  in_array( $r["like_id"] , $likes )  ){
		$friends_points[ $r["user_id"] ]->points++;
	}

}
/**
 * We are sorting the array using the points value. So the highest point values will appear at the beginning of the array
 */
usort($friends_points, function($a, $b){
	return strcmp($b->points, $a->points);
});


DB::insert('matchs', array(
		'user_id'       =>      $user_id,
		'user_name'     =>      'Unkown',
		'friend_id'     =>      $friends_points[0]->id,
		'friend_name'   =>      $friends_points[0]->name,
		'points'        =>      $friends_points[0]->points,
	));


/**
 * And prepare the response to the browser and user
 */

$response->setData([ "success" => true , "points" => $friends_points ]);
/**
 * We print the response
 */
$response->printResponse();