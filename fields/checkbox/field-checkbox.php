<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

class Sip_field_checkbox extends SipSettingsApi{

	public static function render($key, $value, $args){

		$html = '';
			$checked = isset( $value ) ? $value : '0';
			$name = $key . "[" . $args["id"] . "]" ;
			$html .= sprintf( '<input class="checkbox" name="%s" type="checkbox" value="1" %s/>', $name, checked( '1', $checked, false ) );
			if(isset($args['desc'])) {
				$html .= sprintf( '<p class="description">%s</p>', $args['desc'] );
			}
		echo $html;

	}
	
}