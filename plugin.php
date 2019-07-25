<?php

namespace ElementorDonations;

/**
 * Class Plugin
 *
 */
class Plugin
{
	private static $_instance = null;
	
	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @return Plugin An instance of the class.
	 *
	 */
	public static function instance()
	{
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}
	
	/**
	 * widget_scripts
	 *
	 * Load required plugin core files.
	 *
	 */
	public function widget_scripts()
	{
		//
	}
	
	/**
	 * Include Widgets files
	 *
	 * Load widgets filesElementor - Online Express
	 */
	private function include_widgets_files()
	{
		require_once(__DIR__ . '/widgets/online-express.php');
		require_once(__DIR__ . '/widgets/iats.php');
	}
	
	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 */
	public function register_widgets()
	{
		// Its is now safe to include Widgets files
		$this->include_widgets_files();
		
		// Register Widgets
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Online_Express());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\iATS());
	}
	
	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 */
	public function __construct()
	{
		add_action('elementor/frontend/after_register_scripts', [$this, 'widget_scripts']);
		add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);
	}
}

// Instantiate Plugin Class
Plugin::instance();
