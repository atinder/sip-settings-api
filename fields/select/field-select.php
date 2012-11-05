<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

class Sip_field_select extends SipSettingsApi{

	public static function render($key, $value, $args){

		$name = $key . "[" . $args["id"] . "]";
		$size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular' ;

		$html = '';
		$html .= sprintf( '<select name="%s">', $name );
		foreach ( $args['options'] as $key => $label ) {
			if(is_numeric($key)) $key = $label;
			$html .= sprintf( '<option class="%s-text" value="%s" %s/>%s</option>', $size, $key, selected( $value, $key, false ), $label );
			$html .= sprintf( '<label> %s', $label );
			$html .= sprintf( '</label><br>' );
		}
		if(isset($args['desc'])) {
				$html .= sprintf( '<p class="description">%s</p>', $args['desc'] );
		}
		echo $html;

	}
	
}