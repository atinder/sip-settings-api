<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

class Sip_field_text extends SipSettingsApi{

	public static function render($key, $value, $args){

		$name = $key . "[" . $args["id"] . "]";
		$size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular' ;

		$html = sprintf( '<input class="%s-text" name="%s" type="text" value="%s" />', $size, $name, $value );
		if(isset($args['desc'])) {
				$html .= sprintf( '<p class="description">%s</p>', $args['desc'] );
		}
		echo $html;

	}
	
}