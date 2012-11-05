<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

class Sip_field_color extends SipSettingsApi{

	public static function render($key, $value, $args){

		$name = $key . "[" . $args["id"] . "]";
		$size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular' ;

		$html = sprintf( '<input style="float:left;" class="%s-text" name="%s" type="color" value="%s" />', $size, $name, $value );
		$html .= sprintf('<input style="margin-left:20px;" type="text" class="small-text" value="%s" />',$value);
		if(isset($args['desc'])) {
				$html .= sprintf( '<p class="description">%s</p>', $args['desc'] );
			}	
		echo $html;

	}
	
}