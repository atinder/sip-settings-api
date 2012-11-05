<?php
/*
Plugin Name: Sip Settings API Demo
Plugin URI: http://shopitpress.com
Author: atinder
Version: 1.0
Author URI: http://atinder.com
*/

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

require_once dirname( __FILE__ ) . '/class.sip.settings.api.php';


class SipSettingsApiTest{

	private $config = array();

	private $sections = array();

	public function __construct(){	

		add_action('wp_loaded',array($this,'toplevel_menu_example'));
		
		add_action('wp_loaded',array($this,'submenu_example'));

	}

	public function toplevel_menu_example(){

		$this->config = array(
							'root_path' => plugins_url('',__FILE__), // used for enqueuing scripts and styles
							'optionName' => 'sip_settings',
							'page_title' => 'Sip Settings',
							'menu_title' => 'Sip Settings',
							'menu_slug' => 'sip_settings_api',
							'screen_icon' => 'tools',
							// 'icon_url' => '',
							// 'position' => '99.7'	 
			);

		$this->sections[] = array(
								'title' => __('Basic Settings','sip'),
								'fields' => array(
								'mysetting' => array(
												'label' => __('My Setting','sip'),
												'type' => 'color',
												'std' => '#fff'
												),
								'mysettinag' => array(
												'label' => __('My Setting','sip'),
												'type' => 'range',
												'min' => '0',
												'max' => '20'
												),
								'mysettawing' => array(
												'label' => __('My Setting','sip'),
												'type' => 'range',
												'min' => '0',
												'max' => '20'
												),

								'mysetting2' => array(
												'label' => __('My Setting2','sip'),
												'desc' => __('Some Description2','sip'),
												'type' => 'upload'
												),
								'mysetting3' => array(
												'label' => __('My Setting3','sip'),
												'desc' => __('Some Description3','sip'),
												'type' => 'textarea'
												),
								'mysetting4' => array(
												'label' => __('My Setting4','sip'),
												'desc' => __('Some Description6','sip'),
												'type' => 'select',
												'size' => 'large',
												'options' => array(
														'one' => 'ONE',
														'two' => 'TWO',
														'th' => 'Tsdf',
														'thxf' => 'dsf'
													)
												)
								)
							);

		$this->sections[] =	array(
								'title' => __('Advanced Settings','sip'),
								'fields' => array(
								'mysetting5' => array(
												'label' => __('My Setting5','sip'),
												'desc' => __('Some Description4','sip'),
												'type' => 'multicheck',
												'options' => array(
														'one' => 'ONE',
														'two' => 'TWO',
														'th' => 'TsdfO',
														'thxf' => 'dsf'
													)
												),
								'mysetting6' => array(
												'label' => __('My Setting6','sip'),
												'desc' => __('Some Description5','sip'),
												'type' => 'radio',
												'options' => array(
														'one' => 'ONE',
														'two' => 'TWO',
														'th' => 'TsdfO',
														'thxf' => 'dsf'
													)
												),
								'mysetting7' => array(
												'label' => __('My Setting7','sip'),
												'desc' => __('Some Description6','sip'),
												'type' => 'select',
												'size' => 'large',
												'options' => array(
														'one' => 'ONE',
														'two' => 'TWO',
														'th' => 'Tsdf',
														'thxf' => 'dsf'
													)
												)
								)
							);
		
		$this->sections[] =	array(
								'title' => __('Social Settings','sip'),
								'fields' => array(
									'facebook' => array(
													'label' => __('Facebook','sip'),
													'type' => 'text',
													'std' => 'http://facebook.com'
													),
									'twitter' => array(
													'label' => __('Twitter','sip'),
													'type' => 'text'
													),
									'google_plus' => array(
													'label' => __('Google Plus','sip'),
													'type' => 'text'
													),
									'youtube' => array(
													'label' => __('Youtube','sip'),
													'type' => 'text'
													),
									'social_size' => array(
													'label' => __('Size','sip'),
													'type' => 'select',
													'options' => array('32','48')
													),
									'social_target' => array(
													'label' => __('Target','sip'),
													'type' => 'select',
													'options' => array('same_window','new_window')
													),
									)
							);



		new SipSettingsApi($this->config,$this->sections);

	}

	public function submenu_example(){

		$config = array(
						'optionName' => 'sip_settings2',
						'page_title' => 'Sip Settings',
						'menu_title' => 'Sip Settings',
						'menu_slug' => 'sip_settings_api2',
						'parent_slug' => 'options-general.php',
						'screen_icon' => 'tools'
					);


		$sections[] = array(
								'title' => __('Basic Settings','sip'),
								'fields' => array(
								'mysetting' => array(
												'label' => __('My Setting','sip'),
												'type' => 'color',
												'std' => '#fff'
												),
								'mysettinag' => array(
												'label' => __('My Setting','sip'),
												'type' => 'range',
												'min' => '0',
												'max' => '20'
												),
								
								)
							);

		new SipSettingsApi($config,$sections);

	}


}

new SipSettingsApiTest();