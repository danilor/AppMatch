<?php
function get_current_url($strip = true) {
	static $filter, $scheme, $host;
	if (!$filter) {
		// sanitizer
		$filter = function($input) use($strip) {
			$input = trim($input);
			if ($input == '/') {
				return $input;
			}

			// add more chars if needed
			$input = str_ireplace(["\0", '%00', "\x0a", '%0a', "\x1a", '%1a'], '',
				rawurldecode($input));

			// remove markup stuff
			if ($strip) {
				$input = strip_tags($input);
			}

			// or any encoding you use instead of utf-8
			$input = htmlspecialchars($input, ENT_QUOTES, 'utf-8');

			return $input;
		};

		$host = $_SERVER['SERVER_NAME'];
		$scheme = isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME']
			: ('http'. (($_SERVER['SERVER_PORT'] == '443') ? 's' : ''));
	}

	return sprintf('%s://%s%s', $scheme, $host, $filter($_SERVER['REQUEST_URI']));
}