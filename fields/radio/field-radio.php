<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

class Sip_field_radio extends SipSettingsApi{

	public static function render($key, $value, $args){

		$name = $key . "[" . $args["id"] . "]";

		$html = '';
		$html = '';
		foreach ( $args['options'] as $key => $label ) {
			$html .= sprintf( '<input class="radio" name="%s" type="radio" value="%s" %s/>', $name, $key, checked( $value, $key, false ) );
			$html .= sprintf( '<label> %s', $label );
			$html .= sprintf( '</label><br>' );
		}

		if(isset($args['desc'])) {
				$html .= sprintf( '<p class="description">%s</p>', $args['desc'] );
		}
		echo $html;

	}
	
}