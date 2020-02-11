<?php

namespace ElementorDonations\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
	exit;
} // Exit if accessed directly

/**
 * Elementor Online Express
 *
 * Elementor widget for Online Express.
 *
 * @since 1.0.0
 */
class Online_Express extends Widget_Base
{
	
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 */
	public function get_name()
	{
		return 'online-express';
	}
	
	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 */
	public function get_title()
	{
		return __('Online Express', 'elementor-donations');
	}
	
	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 */
	public function get_icon()
	{
		return 'eicon-form-horizontal';
	}
	
	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @return array Widget categories.
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 */
	public function get_categories()
	{
		return ['donations'];
	}
	
	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @return array Widget scripts dependencies.
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 */
	public function get_script_depends()
	{
		return ['elementor-donations'];
	}
	
	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls()
	{
		$this->start_controls_section(
			'section_content',
			[
				'label' => __('Settings', 'elementor-donations'),
			]
		);
		
		$this->add_control(
			'formId',
			[
				'label' => __('Form ID', 'elementor-donations'),
				'type' => Controls_Manager::TEXT,
			]
		);

		// SmartTRACK product.
        $this->add_control(
            'smartTrack_description',
            [
                'raw' => __(
                    'If you want to enable SmartTrack, please provide your product credentials below.',
                    'elementor-donations'
                ),
                'type' => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-descriptor',
                'separator' => 'before',
            ]
        );

		$this->add_control(
			'smartTrackClient',
			[
				'label' => __('SmartTRACK Client', 'elementor-donations'),
				'type' => Controls_Manager::TEXT,
			]
		);
		
		$this->add_control(
			'smartTrackId',
			[
				'label' => __('SmartTRACK ID', 'elementor-donations'),
				'type' => Controls_Manager::TEXT,
			]
		);

		// SmartZIP Product.
        $this->add_control(
            'smartZip_description',
            [
                'raw' => __(
                    'If you want to enable SmartZIP, please provide your product credentials below.',
                    'elementor-donations'
                ),
                'type' => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-descriptor',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'smartZipClient',
            [
                'label' => __('SmartZIP Client', 'elementor-donations'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'smartZipId',
            [
                'label' => __('SmartZIP ID', 'elementor-donations'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'loqateApiKey',
            [
                'label' => __('Loqate API Key', 'elementor-donations'),
                'type' => Controls_Manager::TEXT,
            ]
        );
		
		$this->end_controls_section();
	}
	
	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render()
	{
		$settings = $this->get_settings_for_display();
		
		echo '<div class="donation-form online-express">';
		
		if ($settings['formId']) {
			echo '<div id="bbox-root"></div>';
			echo '<script type="text/javascript">';
			echo 'window.bboxInit = function () { bbox.showForm("' . $settings['formId'] . '"); };';
			echo '(function () {';
			echo 'var e = document.createElement("script"); e.async = true;';
			echo 'e.src = "https://bbox.blackbaudhosting.com/webforms/bbox-min.js";';
			echo 'document.getElementsByTagName("head")[0].appendChild(e);';
			echo '}  ());';
			echo '</script>';
			echo '<script type="text/javascript">var SmartTRACKOLXSettings = {"redirecturl":"","NewSKU":true,"product":"SmartTRACKOLX","client":"' . $settings['smartTrackClient'] . '"}</script>';
			echo '<script type="text/javascript" src="https://www.smartthing2.com/download/file.php?jsformat=1&olx=1&f=-js.html&c=' . $settings['smartTrackClient'] . '&k=' . $settings['smartTrackId'] . '"></script>';

            // Enable SmartZIP if credentials are provided.
            if ($settings['smartZipClient'] && $settings['smartZipId'] && $settings['loqateApiKey']) {
                echo '<script type="text/javascript">var SmartZIPOLXSettings = {"pcaKey":"' . $settings['loqateApiKey'] . '","findAddressPrompt":"Find my address","manualPrompt":"Add address manually","product":"SmartZIPOLX","client":"' . $settings['smartZipClient'] . '"}</script>';
                echo '<script type="text/javascript"src="https://www.smartthing2.com/download/file.php?jsformat=1&olx=1&f=-js.html&c=' . $settings['smartZipClient'] . '&k=' . $settings['smartZipId'] . '"></script>';
            }
		} else {
			echo '<h4><em>Online Express - Form ID required.</em></h4>';
		}
		
		echo '</div>';
	}
	
	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _content_template()
	{
		?><div class="donation-form online-express">
			<div id="bbox-root"></div>
			<script type="text/javascript">
				window.bboxInit = function () {
					bbox.showForm("{{{ settings.formId }}}");
				};
				(function () {
					var e = document.createElement("script");
					e.async = true;
					e.src = "https://bbox.blackbaudhosting.com/webforms/bbox-min.js";
					document.getElementsByTagName("head")[0].appendChild(e);
				}());
			</script>
		</div><?php
	}
}
