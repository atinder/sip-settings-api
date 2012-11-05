<?php

/**
 * Sip Settings API Class
 * @author Atinder <atinder.com>
 * @link http://shopitpress.com
 * @example sip-settings-api.php
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'SipSettingsApi' ) ) {

	class SipSettingsApi {

		/**
		 * Options array
		 */
		protected $options;

		/**
		 * Configuration array
		 */
		private $config = array();

		/**
		 *  Settings Sections Array
		 *
		 * @var array
		 */
		private $sections = array();

		/**
		 * Admin Page Hook
		 */
		private $hook;

		/**
		 * Class Directory
		 */
		private $dir;

		/**
		 * Instantiate class variables and do required actions
		 */
		public function __construct($config,$sections) {

			$defaults = array(
							'root_path' => plugins_url('',__FILE__),
							'optionName' => 'at_settings',
							'page_title' => 'AT Settings',
							'menu_title' => 'AT Settings',
							'menu_slug' => 'at_settings_api',
							'screen_icon' => 'options-general'
			);

			if(!isset($config['parent_slug'])){
				$defaults['icon_url'] = get_admin_url('','images/marker.png');
				$defaults['position'] = null;
			}

			$this->config = wp_parse_args($config,$defaults);
			$this->setSections($sections);
			$this->options = get_option( $this->config['optionName'] );
			$this->dir = trailingslashit(str_replace('\\','/',dirname(__FILE__)));
			
			add_action('admin_menu',array($this,'admin_menu'));
			add_action('admin_init',array($this,'admin_init'));
			add_action('admin_enqueue_scripts', array($this,'admin_enqueue_scripts'));

			add_filter('attribute_escape', array($this,'tbReplace'),10,2);

		}

		/**
		 * Set Settings Sections
		 *
		 * @param array   $setions Settings Sections array
		 */
		public function setSections( $sections ) {
			$this->sections = $sections;
		}

		/**
		 * Generate section Id from title
		 */
		private function genSectionId($title){
			return strtolower(preg_replace('/\s*/', '', $title ));
		}

		public function tbReplace($safe_text, $text) {
		    return str_replace(__('Insert into Post'), __('Use this image'), $text);
		}
		
		/**
		 * Used to create admin menu in dashboard
		 */
		public function admin_menu(){
			if(isset($this->config['parent_slug'])){
				$this->hook = add_submenu_page($this->config['parent_slug'],$this->config['page_title'],$this->config['menu_title'],'manage_options',$this->config['menu_slug'],array($this,'display_page'));
			}
			else{
				$this->hook = add_menu_page($this->config['page_title'],$this->config['menu_title'],'manage_options',$this->config['menu_slug'],array($this,'display_page'),$this->config['icon_url'],$this->config['position']);
			}
		}
		
		/**
		 * Initialize and registers the settings sections and fileds to WordPress
		 *
		 * Usually this should be called at `admin_init` hook.
		 *
		 * This function gets the initiated settings sections and fields. Then
		 * registers them to WordPress and ready for use.
		 */

		public function admin_init() {

			register_setting( $this->config['optionName'], $this->config['optionName'] );

			foreach ( $this->sections as $section ) {

				$section_id = $this->genSectionId($section['title']) ;

				add_settings_section( $section_id , $section['title'],'__return_false', $this->config['menu_slug'] );

				foreach ( $section['fields'] as $id => $field ) {
					$args = $field;
					$args['id'] = $id; //attaching current field id
					$args['section'] = $section_id; //attaching section id with arguments
					add_settings_field( $id, $field['label'], array( $this, 'field_input' ),$this->config['menu_slug'], $section_id, $args );

				}

			}
			

		}

		/**
		 * Creates fields by calling render function in respective field class
		 *
		 * @param unknown $args array arguments for field
		 */
		public function field_input( $args ) {

			$field_class = 'Sip_field_' . $args['type'];

			if(!class_exists($field_class) && file_exists($this->dir.'fields/'.$args['type'].'/field-'.$args['type'].'.php')){
				require_once($this->dir.'fields/'.$args['type'].'/field-'.$args['type'].'.php');
			}

			if(class_exists($field_class) && method_exists($field_class, 'render')){
				$val = (isset($this->options[ $args["id"] ])) ? $this->options[ $args["id"] ] : '';
				$render = call_user_func_array(array($field_class,'render'),array($this->config['optionName'],$val,$args));
			}

		}


		/**
		 * Enqueue scripts and styles
		 * Parent as well as child classes
		 */
		public function admin_enqueue_scripts($hook){

       		if($hook != $this->hook) return;
    		wp_enqueue_script( 'sip-settings-class', $this->config['root_path'] . '/js/custom.js'  );
    		wp_enqueue_style( 'sip-settings-class', $this->config['root_path'] . '/css/style.css'  );

    		foreach ($this->sections as $section) {

    			if(isset($section['fields'])){
				
				foreach($section['fields'] as $field){
					
					if(isset($field['type'])){
					
						$fields[] = $field['type'];

						}
					
					}
			
				}

    		}
    		$fields = array_unique($fields);
    		
    		foreach ($fields as $field) {
    			
	    		$field_class = 'Sip_field_'. $field;

	    		if(!class_exists($field_class) && file_exists($this->dir.'fields/'.$field.'/field-'.$field.'.php')){
					require_once($this->dir.'fields/'.$field.'/field-'.$field.'.php');
				}
						
				if(class_exists($field_class) && method_exists($field_class, 'enqueue')){
					$enqueue = call_user_func(array($field_class,'enqueue'),$this->config['root_path']);
				}
			}
		}

		
		/**
		 * Shows tabbed navigation using section titles
		 */
		public function sections_navigation() {
			$html = '<h2 class="nav-tab-wrapper">';
			foreach ( $this->sections as $section ) {
				$section_id = $this->genSectionId($section['title']);
				$html .= sprintf( '<a href="#%1$s" rel="%1$s" class="nav-tab">%2$s</a>', $section_id , $section['title'] );
			}
			$html .= '</h2>';
			echo $html;
		}

		/**
		 * Displays the section settings forms
		 */
		public function show_form() {
?>
			<form method="post" action="options.php">

				<?php settings_fields( $this->config['optionName'] );

				foreach ( $this->sections as $section ) {

					$section_id = $this->genSectionId( $section['title'] ); //generate section Id from title
?>
					<div class="at-section-wrap" id="<?php echo $section_id; ?>">

						<?php // print_r(get_option($section['id']));
						/*for debugging options uncomment above line */ ?>

					<table class="form-table">
		              <?php  do_settings_fields($this->config['menu_slug'], $section_id); ?>
		            </table>

					</div>
<?php 			}

				submit_button(); ?>
			</form>

<?php }

		/**
		 * Display page with calling in a div with all content
		 */
		public function display_page() { ?>

			<div class="wrap">
				<?php
					screen_icon($this->config['screen_icon']);
					$this->sections_navigation();
					settings_errors();
					$this->show_form();
				?>
			</div>

<?php
		}

	}
}