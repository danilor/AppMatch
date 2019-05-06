<?php

/**
 * This function will include one single block into the page
 * @param $name
 */
function include_block( $name ){
	global $config_blocks;
	include(  $config_blocks[ "path" ] . DIRECTORY_SEPARATOR . $name .  $config_blocks[ "extension" ]  );
}