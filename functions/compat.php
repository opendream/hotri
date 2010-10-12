<?php
/**
 * WordPress implementation for PHP functions missing from older PHP versions.
 *
 * @package PHP
 * @access private
 */

// For PHP < 5.2.0
if ( !function_exists('json_encode') ) {
	function json_encode( $string ) {
		global $json_obj;

		if ( !is_a($json_obj, 'Services_JSON') ) {
			require_once( 'class-json.php' );
			$json_obj = new Services_JSON();
		}

		return $json_obj->encodeUnsafe( $string );
	}
}

if ( !function_exists('json_decode') ) {
	function json_decode( $string ) {
		global $json_obj;

		if ( !is_a($json_obj, 'Services_JSON') ) {
			require_once( 'class-json.php' );
			$json_obj = new Services_JSON();
		}

		return $json_obj->decode( $string );
	}
}
