<?php
/**
 * Plugin Name: Elementor - Donations Addon
 * Description: Elementor plugin for donations via Online Express/iATS Payments.
 * Version:     1.1.1
 * Author:      Chris Southam
 * Author URI:  https://www.rallyagency.co.uk
 * Text Domain: elementor-donations
 */

if (!defined('ABSPATH')) {
	exit;
} // Exit if accessed directly

define('ELEMENTOR_DONATIONS', '1.1.1');
define('ELEMENTOR_DONATIONS_GITHUB_ENDPOINT', 'ChrisRally/elementor-donations-addon');
define('ELEMENTOR_DONATIONS_GITHUB_TOKEN', 'c3ef67756f480a3651fb544cd17a4572e9d1b965');

require __DIR__ . '/includes/puc/plugin-update-checker.php';

/*
 * Plugin update checker
 * Via GitHub repo
 */
$updateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/' . ELEMENTOR_DONATIONS_GITHUB_ENDPOINT,
	__FILE__,
	'elementor-donations'
);

$updateChecker->setAuthentication(ELEMENTOR_DONATIONS_GITHUB_TOKEN);
$updateChecker->setBranch('master');

final class Elementor_Donations
{
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
	const MINIMUM_PHP_VERSION = '7.1';
	
	public function __construct()
	{
		add_action('init', [$this, 'i18n']);
		add_action('plugins_loaded', [$this, 'init']);
	}
	
	public function i18n()
	{
		load_plugin_textdomain('elementor-donations');
	}
	
	/**
	 * Initialize the plugin
	 */
	public function init()
	{
		// Check if Elementor installed and activated
		if (!did_action('elementor/loaded')) {
			add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
			
			return;
		}
		
		// Check for required Elementor version
		if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
			add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
			
			return;
		}
		
		// Check for required PHP version
		if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
			add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
			
			return;
		}
		
		// Once we get here, We have passed all validation checks so we can safely include our plugin
		require_once('plugin.php');
	}
	
	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin()
	{
		if (isset($_GET['activate'])) {
			unset($_GET['activate']);
		}
		
		$message = sprintf(
		/* translators: 1: Plugin name 2: Elementor */
			esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'elementor-donations'),
			'<strong>' . esc_html__('Elementor - Online Express', 'elementor-donations') . '</strong>',
			'<strong>' . esc_html__('Elementor', 'elementor-donations') . '</strong>'
		);
		
		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}
	
	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version()
	{
		if (isset($_GET['activate'])) {
			unset($_GET['activate']);
		}
		
		$message = sprintf(
		/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-donations'),
			'<strong>' . esc_html__('Elementor - Online Express', 'elementor-donations') . '</strong>',
			'<strong>' . esc_html__('Elementor', 'elementor-donations') . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);
		
		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}
	
	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version()
	{
		if (isset($_GET['activate'])) {
			unset($_GET['activate']);
		}
		
		$message = sprintf(
		/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-donations'),
			'<strong>' . esc_html__('Elementor - Online Express', 'elementor-donations') . '</strong>',
			'<strong>' . esc_html__('PHP', 'elementor-donations') . '</strong>',
			self::MINIMUM_PHP_VERSION
		);
		
		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}
}

new Elementor_Donations();
