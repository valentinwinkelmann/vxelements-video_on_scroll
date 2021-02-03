<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Elementor_VideoOnScroll_Control
 */
class Elementor_VideoOnScroll_Control {


	private static $instance = null;

	/**
	 * @return Elementor_VideoOnScroll_Control|null
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function init() {

		// Add section for settings
		add_action( 'elementor/element/section/section_advanced/after_section_end', [ $this, 'register_section' ] );

		add_action( 'elementor/element/section/vos_section/before_section_end', [ $this, 'register_controls' ], 10, 2 );


		add_action( 'elementor/frontend/section/before_render', [$this, 'section_before_render'], 10, 2);
	}

	public function register_section( $element ) {
		$element->start_controls_section(
			'vos_section',
			[
				'tab'   => Controls_Manager::TAB_ADVANCED,
				'label' => __( 'Video on Scroll', 'vaax-elements' ),
			]
		);
		$element->end_controls_section();
	}

	/**
	 * @param $element \Elementor\Widget_Base
	 * @param $section_id
	 * @param $args
	 */
	public function register_controls( $element, $args ) {

		$element->add_control(
			'vos_enabled', [
				'label'        => __( 'Video on Scroll', 'vaax-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => __( 'Yes', 'vaax-elements' ),
				'label_off'    => __( 'No', 'vaax-elements' ),
				'return_value' => 'yes',
			]
		);
		$element->add_control(
			'important_note',
			[
				'label' => __( 'Video Format', 'vaax-elements' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => __( 'Not all videos are suitable for scrubbing. Stuttering will occur with many video formats. We recommend to use ffmpeg to convert the video into single generic frames before. You can do this in ffmpeg as follows:
					<br><code>ffmpeg -i input.mp4 -g 10 output.mp4</code>', 'vaax-elements' ),
				'content_classes' => 'elementor-descriptor',
				'condition'   => [
					'vos_enabled'     => 'yes'
				],
			]
		);
		$element->add_control(
			'vos_distance',
			[
				'label' => __( 'Distance', 'vaax-elements' ),
				'description' => __( 'How deep must the page be scrolled for the video to have played 100%. You can specify a value in pixels or in percent, with percent 100% corresponds to the height of the actual video element.', 'vaax-elements'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .box' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'   => [
					'vos_enabled'     => 'yes',
				],
			]
		);
		$element->add_control(
			'vos_screenOffset',
			[
				'label' => __( 'Screen Offset', 'vaax-elements' ),
				'description' => __( 'Where is the screen trigger located? 0% is at the top of the screen, 100% is at the bottom of the screen, 50% is in the middle.', 'vaax-elements'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'condition'   => [
					'vos_enabled'     => 'yes',
				],
			]
		);
		$element->add_control(
			'vos_smoothingTime',
			[
				'label' => __( 'Smoothing Time', 'vaax-elements' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 2000,
				'step' => 1,
				'default' => 300,
			]
		);
		$element->add_control(
			'vos_refreshRate',
			[
				'label' => __( 'Refresh Rate', 'vaax-elements' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 200,
				'step' => 1,
				'default' => 30,
			]
		);
	}

	private function get_roles() {
		global $wp_roles;

		if ( ! isset( $wp_roles ) ) {
			$wp_roles = new \WP_Roles();
		}
		$all_roles      = $wp_roles->roles;
		$editable_roles = apply_filters( 'editable_roles', $all_roles );

		$data = [ 'ecl-guest' => 'Guests', 'ecl-user' => 'Logged in users' ];

		foreach ( $editable_roles as $k => $role ) {
			$data[ $k ] = $role['name'];
		}

		return $data;
	}

	public function content_change( $content, $widget ) {

		if ( Plugin::$instance->editor->is_edit_mode() ) {
			return $content;
		}

		// Get the settings
		$settings = $widget->get_settings();

		if ( ! $this->should_render( $settings ) ) {
			return '';
		}

		return $content;

	}

	public function section_should_render( $should_render, $section ) {
		// Get the settings
		$settings = $section->get_settings();

		if ( ! $this->should_render( $settings ) ) {
			return false;
		}

		return $should_render;

	}
	public function section_before_render( \Elementor\Element_Base $element ) {
		// $element['vos_enabled'];
		$settings = $element->get_settings();
		if ( $settings['vos_enabled'] == 'yes' ) {
			$element->add_render_attribute( '_wrapper', [
				'class' => 'vx-vos',
				'data-vos_distance' => $settings['vos_distance']['size'],
				'data-vos_distance_unit' => $settings['vos_distance']['unit'],
				'data-vos_screenOffset' => $settings['vos_screenOffset']['size'],
				'data-vos_smoothingTime' => $settings['vos_smoothingTime'],
				'data-vos_refreshRate' => $settings['vos_refreshRate']
			] );
		} else {
			return;
		}



	}


}

Elementor_VideoOnScroll_Control::get_instance()->init();
