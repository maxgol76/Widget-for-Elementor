<?php
namespace TheGem_Elementor\Widgets\StyledImage;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

use Elementor\Utils;
use Elementor\Group_Control_Css_Filter;


if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Elementor widget for StyledImage.
 */
class TheGem_StyledImage extends Widget_Base {

	/**
	 * Presets
	 * @access protected
	 * @var array $presets Array objects presets.
	 */

	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );

		if( ! defined( 'THEGEM_ELEMENTOR_WIDGET_STYLED_IMAGE_DIR' ) ){
			define( 'THEGEM_ELEMENTOR_WIDGET_STYLED_IMAGE_DIR', rtrim( __DIR__, ' /\\' ) );
		}

		if ( ! defined( 'THEGEM_ELEMENTOR_WIDGET_STYLED_IMAGE_URL' ) ) {
			define( 'THEGEM_ELEMENTOR_WIDGET_STYLED_IMAGE_URL', rtrim( plugin_dir_url( __FILE__ ), ' /\\' ) );
		}

        wp_register_style( 'thegem-styled-image', THEGEM_ELEMENTOR_WIDGET_STYLED_IMAGE_URL . '/assets/css/thegem-styled-image.css', array(), 1.2 );

	}


	/**
	 * Retrieve the widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'thegem-styled-image';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Styled Image', 'thegem' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-featured-image';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'thegem_widgets' ];
	}

	public function get_style_depends() {
		return [ 'thegem-wrapboxes', 'thegem-styled-image' ];
	}

	/*Show reload button*/
	public function is_reload_preview_required() {
		return true;
	}


	/**
	 * Retrieve the value setting
	 * @access public
	 *
	 * @param string $control_id Control id
	 * @param string $control_sub Control value name (size, unit)
	 *
	 * @return string
	 */
	public function get_val( $control_id, $control_sub = null ) {
		if ( empty( $control_sub ) ) {
			return $this->get_settings()[ $control_id ];
		} else {
			return $this->get_settings()[ $control_id ][ $control_sub ];
		}
	}

	/**
	 * Create presets options for Select
	 *
	 * @access protected
	 * @return array
	 */
	protected function get_presets_options() {
		$out = array(
			'gem-wrapbox-style-default' => __( 'no border', 'thegem' ),
			'gem-wrapbox-style-1'       => __( '8px & border', 'thegem' ),
			'gem-wrapbox-style-2'       => __( '16px & border', 'thegem' ),
			'gem-wrapbox-style-3'       => __( '8px outlined border', 'thegem' ),
			'gem-wrapbox-style-4'       => __( '20px outlined border', 'thegem' ),
			'gem-wrapbox-style-5'       => __( '20px border with shadow', 'thegem' ),
			'gem-wrapbox-style-6'       => __( 'Combined border', 'thegem' ),
			'gem-wrapbox-style-7'       => __( '20px border radius', 'thegem' ),
			'gem-wrapbox-style-8'       => __( '55px border radius', 'thegem' ),
			'gem-wrapbox-style-9'       => __( 'Dashed inside', 'thegem' ),
			'gem-wrapbox-style-10'      => __( 'Dashed outside', 'thegem' ),
			'gem-wrapbox-style-11'      => __( 'Rounded with border', 'thegem' ),
			'gem-wrapbox-style-12'      => __( 'Rounded without border', 'thegem' ),
		);
		return $out;
	}

	/**
	 * Get default presets options for Select
	 *
	 * @param int $index
	 *
	 * @access protected
	 * @return string
	 */
	protected function set_default_presets_options() {
		return 'gem-wrapbox-style-default';
	}

	/**
	 * Register the widget controls.
	 *
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout', 'thegem' ),
			]
		);

        $this->add_control(
            'thegem_elementor_preset',
            [
                'label'              => __( 'Skin', 'thegem' ),
                'type'               => Controls_Manager::SELECT,
                'options'            => $this->get_presets_options(),
                'default'            => $this->set_default_presets_options(),
                'frontend_available' => true,
                'render_type'        => 'none',
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'thegem' ),
			]
		);

        $this->add_control(
            'content_choose_image',
            [
                'label'   => __( 'Choose image', 'thegem' ),
                'type'    => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'content_image_link_to',
            [
                'label'   => __( 'Link', 'thegem' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none'   => __( 'None', 'thegem' ),
                    'file'   => __( 'Media File', 'thegem' ),
                    'custom' => __( 'Custom URL', 'thegem' ),
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'label'   => __( 'Link', 'thegem' ),
                'type'    => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __( 'https://your-link.com', 'thegem' ),
                'condition'   => [
                    'content_image_link_to' => 'custom',
                ],
                'show_label'  => false,
            ]
        );

        $this->add_control(
            'open_lightbox',
            [
                'label'     => __( 'Lightbox', 'thegem' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'default',
                'options'   => [
                    'default' => __( 'Default', 'thegem' ),
                    'yes'     => __( 'Yes', 'thegem' ),
                    'no'      => __( 'No', 'thegem' ),
                ],
                'condition' => [
                    'content_image_link_to' => 'file',
                ],
            ]
        );

        $this->add_control(
            'view',
            [
                'label'   => __( 'View', 'thegem' ),
                'type'    => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

		$this->end_controls_section();

        $this->start_controls_section(
            'section_options',
            [
                'label' => __( 'Options', 'thegem' ),
            ]
        );

        $this->add_control(
            'options_lazy_loading',
            [
                'label'        => __( 'Lazy Loading', 'thegem' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'thegem' ),
                'label_off'    => __( 'Off', 'thegem' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->end_controls_section();

		$this->add_styles_controls( $this );

	}

	/**
	 * Controls call
	 * @access public
	 */
	public function add_styles_controls( $control ) {

		$this->control = $control;

        /*Image Style*/
        $this->image_style( $control );

		/*Container Styles*/
		$this->container_styles( $control );

		/*Inner Border Style*/
        $this->inner_border_style($control);

	}


		/**
	 * Container Styles
	 * @access protected
	 */
	protected function container_styles( $control ) {
		
		$control->start_controls_section(
			'container',
			[
				'label' => __( 'Container Style', 'thegem' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$control->start_controls_tabs( 'container_tabs' );

        $control->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'container_bgcolor',
                'label'    => __( 'Background Type', 'thegem' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .gem-image',
            ]
        );

        $control->add_responsive_control(
            'container_radius',
            [
                'label'       => __( 'Radius', 'thegem' ),
                'type'        => Controls_Manager::DIMENSIONS,
                'size_units'  => [ 'px', '%', 'rem', 'em' ],
                'separator'   => 'after',
                'label_block' => true,
                'selectors'   => [
                    '{{WRAPPER}} .gem-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .gem-image .gem-wrapbox-inner img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $control->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'container_border',
                'label'    => __( 'Border', 'thegem' ),
                'selector' => '{{WRAPPER}} .gem-image',

            ]
        );

        $control->add_responsive_control(
            'container_padding',
            [
                'label'       => __( 'Padding', 'thegem' ),
                'type'        => Controls_Manager::DIMENSIONS,
                'size_units'  => [ 'px', '%', 'rem', 'em' ],
                'label_block' => true,
                'selectors'   => [
                    '{{WRAPPER}} .gem-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $control->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'container_shadow',
                'label'    => __( 'Shadow', 'thegem' ),
                'selector' => '{{WRAPPER}} .gem-image',
            ]
        );

		$control->end_controls_tabs();

		$control->end_controls_section();

	}

	/**
	 * Image Styles
	 * @access protected
	 */
	protected function image_style( $control ) {

		$control->start_controls_section(
			'Image_style',
			[
				'label' => __( 'Image Style', 'thegem' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $control->add_responsive_control(
            'size',
            [
                'label' => __( 'Size', 'thegem' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units' => [ '%', 'px', 'vw' ],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .gem-image' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $control->add_control(
            'image_position',
            [
                'label'   => __('Position', 'thegem'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'gem-wrapbox-position-below'    => __( 'Below',    'thegem'),
                    'gem-wrapbox-position-centered' => __( 'Centered', 'thegem'),
                    'gem-wrapbox-position-left'     => __( 'Left',     'thegem'),
                    'gem-wrapbox-position-right'    => __( 'Right',    'thegem'),
                ],
                'default' => 'gem-wrapbox-position-below',
            ]
        );

        $control->start_controls_tabs( 'image_effects' );

        $control->start_controls_tab( 'normal',
            [
                'label' => __( 'Normal', 'thegem' ),
            ]
        );

        $control->add_control(
            'opacity',
            [
                'label'  => __( 'Opacity', 'thegem' ),
                'type'   => Controls_Manager::SLIDER,
                'range'  => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .gem-image' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $control->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'     => 'css_filters',
                'selector' => '{{WRAPPER}} .gem-image .gem-wrapbox-inner img',
            ]
        );

        $control->end_controls_tab();

        $control->start_controls_tab( 'hover',
            [
                'label' => __( 'Hover', 'thegem' ),
            ]
        );

        $control->add_control(
            'opacity_hover',
            [
                'label'  => __( 'Opacity', 'thegem' ),
                'type'   => Controls_Manager::SLIDER,
                'range'  => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .gem-image:hover .gem-wrapbox-inner img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $control->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters_hover',
                'selector' => '{{WRAPPER}} .gem-image .gem-wrapbox-inner img',
            ]
        );

        $control->add_control(
            'background_hover_transition',
            [
                'label'  => __( 'Transition Duration', 'thegem' ),
                'type'   => Controls_Manager::SLIDER,
                'range'  => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .gem-image .gem-wrapbox-inner img' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $control->add_control(
            'hover_animation',
            [
                'label' => __( 'Hover Animation', 'thegem' ),
                'type'  => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $control->end_controls_tab();

        $control->end_controls_tabs();

        $control->add_control(
            'separator_panel_style',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );


		$control->end_controls_section();

	}

	/**
	 * Inner Border Style Style
	 * @access protected
	 */
	protected function inner_border_style( $control ) {

		$control->start_controls_section(
			'inner',
			[
				'label' => __( 'Inner spacing', 'thegem' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$control->add_responsive_control(
			'inner_spacing',
			[
				'label' => __( 'Inner Spacing', 'thegem' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'rem', 'em' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
					'%' => [
						'min' => 1,
						'max' => 49,
					],
					'rem' => [
						'min' => 1,
						'max' => 20,
					],
					'em' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'default' => [
					'size' => 20,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gem-wrapbox-inner:after' => 'top: {{SIZE}}{{UNIT}}; bottom: {{SIZE}}{{UNIT}}; right: {{SIZE}}{{UNIT}}; left: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $control->add_control(
            'border_type',
            [
                'label'   => __('Border Type', 'thegem'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'dashed',
                'options' => [
                    'none'   => __('None', 'thegem'),
                    'solid'  => __('Solid', 'thegem'),
                    'double' => __('Double', 'thegem'),
                    'dotted' => __('Dotted', 'thegem'),
                    'dashed' => __('Dashed', 'thegem'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .gem-wrapbox-inner:after' => 'border-style: {{VALUE}};',
                ],
            ]
        );

        $control->add_control(
            'border_width',
            [
                'label' => __('Border Width', 'thegem'),
                'type'  => Controls_Manager::DIMENSIONS,
                'size_units'  => [ 'px', '%', 'rem', 'em' ],
                'label_block' => true,
                'selectors'   => [
                    '{{WRAPPER}} .gem-wrapbox-inner:after' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$control->add_responsive_control(
			'borderr_color',
			[
				'label' => __( 'Border Color', 'thegem' ),
				'type'  => Controls_Manager::COLOR,
				'label_block' => false,
				'selectors'   => [
					'{{WRAPPER}} .gem-wrapbox-inner:after' => 'border-color: {{VALUE}};',
				],
			]
		);

		$control->end_controls_section();

	}
	/**
	 * Helper check in array value
	 * @access protected
	 * @return string
	 */
	function is_in_array_value( $array = array(), $value = '', $default = '' ) {
		if ( in_array( $value, $array ) ) {
			return $value;
		}
		return $default;
	}

	protected function get_setting_preset( $val ) {
		if( empty( $val ) ) {
			return '';
		}

		return $val;
	}

	protected function get_presets_arg( $val ) {
		if ( empty( $val ) ) {
			return null;
		}

		return json_decode( $val, true );
	}


	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	public function render() {
		$settings = $this->get_settings_for_display();

		$this->add_inline_editing_attributes( 'content_choose_image', 'none' );

		$preset_path = __DIR__ . '/templates/preset_html1.php';

		if ( ! empty( $preset_path) && file_exists( $preset_path ) ){
			include( $preset_path );
		}
	}
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TheGem_StyledImage() );
