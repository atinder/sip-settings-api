<?php

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

class Sip_field_upload extends SipSettingsApi{

	public function __construct(){
			add_filter('attribute_escape', array($this,'tbReplace'),10,2);

	}

	public static function render($key, $value, $args){

		$name = $key . "[" . $args["id"] . "]";
		$size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular' ;
$html = '';
		$html .= sprintf('<input id="%s" type="text" class="regular-text" name="%s" value="%s" />',$args['id'],$name,$value);
		$html .= sprintf('<input class="at-upload button" rel-id="%s" type="submit" value="Upload" />',$args["id"]);
		if(!empty($value)){
			$html .= sprintf('<input rel-id="%s" name="%s" type="submit" class="at-remove button" value="Delete">',$args["id"],$args["id"] . '_delete');
			$html .= sprintf('<br/><img width="300px" src="%s" alt="" />',$value);
		}
		if(isset($args['desc'])) {
				$html .= sprintf( '<p class="description">%s</p>', $args['desc'] );
		}
		echo $html;

	}

	public static function enqueue($root_path){
		wp_enqueue_script('media-upload');
 		wp_enqueue_script('thickbox');
 		wp_enqueue_style('thickbox');
 		wp_register_script('upload', $root_path . '/fields/upload/upload.js', array('jquery','media-upload','thickbox'));
  		wp_enqueue_script('upload');
	}

	public function tbReplace($safe_text, $text) {
		    return str_replace(__('Insert into Post'), __('Use this image'), $text);
	}

	public function delete_attachment( $attachment_url ) {
		global $wpdb;
		// We need to get the attachment's meta ID.
		$query = "SELECT ID FROM wp_posts where guid = '" . esc_url($attachment_url) . "' AND post_type = 'attachment'";
		$results = $wpdb->get_results($query);
		// And delete it
		foreach ( $results as $row ) {
			wp_delete_attachment( $row->ID );
		}
}

	
}
new Sip_field_upload();
