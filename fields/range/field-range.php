<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

class Sip_field_range extends SipSettingsApi{

	public static function render($key, $value, $args){

		$name = $key . "[" . $args["id"] . "]";
		$size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular' ;

		$html = sprintf( '<input style="float:left;" class="%s-text at-range" name="%s" type="range" value="%s"  min="%s" max="%s" />', $size, $name, $value,$args['min'],$args['max'] );
		$html .= sprintf('<input style="margin-left:20px;" type="text" class="small-text" value="%s" />',$value);
		if(isset($args['desc'])) {
				$html .= sprintf( '<p class="description">%s</p>', $args['desc'] );
		}
		echo $html;

	}

	public static function enqueue(){
 		wp_register_script('range', plugins_url('/range.js', __FILE__), array('jquery'));
  		wp_enqueue_script('range');
	}
	
}