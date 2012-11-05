<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

class Sip_field_textarea extends SipSettingsApi{

	public static function render($key, $value, $args){

		$name = $key . "[" . $args["id"] . "]";
		$size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular' ;

		$html = sprintf( '<textarea rows="5" cols="42" class="%s-text" name="%s">%s</textarea>', $size, $name, $value );
		if(isset($args['desc'])) {
				$html .= sprintf( '<p class="description">%s</p>', $args['desc'] );
		}
		echo $html;

	}
	
}