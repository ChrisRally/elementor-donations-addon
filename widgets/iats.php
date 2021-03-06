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
class iATS extends Widget_Base
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
		return 'iats';
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
		return __('iATS', 'elementor-donations');
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
		
		echo '<div class="donation-form iats">';
		
		if ($settings['formId']) {
			echo '<script type="text/javascript" src="https://www.iatspayments.com/AURA/AURA.aspx?PID=' . $settings['formId'] . '&Country=Canada&HideRecurringEndDate=True"></script>';
		} else {
			echo '<h4><em>iATS - Form ID required.</em></h4>';
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
		?><div class="donation-form iats">
			<script type="text/javascript" src="https://www.iatspayments.com/AURA/AURA.aspx?PID={{{ settings.formId }}}&Country=Canada&HideRecurringEndDate=True"></script>
		</div><?php
	}
}
