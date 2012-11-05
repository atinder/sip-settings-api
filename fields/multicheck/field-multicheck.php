<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

class Sip_field_multicheck extends SipSettingsApi{

	public static function render($key, $value, $args){

		$html = '';
		foreach ( $args['options'] as $k => $label ) {
			$checked = isset( $value[$k] ) ? $value[$k] : '0';

			$name = $key . "[" . $args["id"] . "]" . "[" . $k . "]";
			$html .= sprintf( '<input class="checkbox" name="%s" type="checkbox" value="1" %s/>', $name, checked( '1', $checked, false ) );
			$html .= sprintf( '<label> %s', $label );
			$html .= sprintf( '</label><br>' );
		}

		if(isset($args['desc'])) {
				$html .= sprintf( '<p class="description">%s</p>', $args['desc'] );
		}
		echo $html;

	}
	
}