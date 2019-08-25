<?php
/**
 * 3r Elementor Timeline Widget.
 *
 * @since 1.0.0
 */
namespace BePack\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Text_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Be_Pack_Widget_Timeline extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * Retrieve widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'be-timeline';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Timelines', 'be-pack' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-time-line';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'basic' ];
	}

	/**
	 * Register widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Timeline', 'be-pack' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
	

		$repeater = new \Elementor\Repeater();
		
		$repeater->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'be-pack' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'separator' => 'none',
			]
		);
		$repeater->add_control(
			'list_title', [
				'label' => __( 'Title', 'be-pack' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Timeline' , 'be-pack' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'list_content', [
				'label' => __( 'Timelines', 'be-pack' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Item content. Click the edit button to change this text.' , 'be-pack' ),
				'show_label' => false,
			]
		);

		$this->add_control(
			'list',
			[
				'label' => __( 'Repeater Control', '' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => array_values( $repeater->get_controls() ),
				'default' => [
					[
						'list_title' => __( 'Timeline', 'be-pack' ),
						'list_content' => __( 'Item content. Click the edit button to change this text.', 'be-pack' ),
					],
					[
						'list_title' => __( 'Timeline', 'be-pack' ),
						'list_content' => __( 'Item content. Click the edit button to change this text.', 'be-pack' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
			]
		);

	$this->end_controls_section();
	/*------- BoxStyle ------------*/
	$this->start_controls_section(
		'content_style',
		[
			'label' => __( 'Content Style', 'be-pack' ),
			'tab' => Controls_Manager::TAB_STYLE,
		]
	);
	$this->add_control(
		'title_color', [
		'label' => __( 'Title Fonts Color', 'be-pack' ),
		'type' => Controls_Manager::COLOR,
		'scheme' => [
			'type' => Scheme_Color::get_type(),
			'value' => Scheme_Color::COLOR_2,
		],
		'selectors' => [
				'{{WRAPPER}} .tl-heading h4' => 'color: {{title_color}}',
			],
		'default' => '#333333',
	]
	);
	$this->add_control(
		'content_color', [
		'label' => __( 'Content Fonts Color', 'be-pack' ),
		'type' => Controls_Manager::COLOR,
		'scheme' => [
			'type' => Scheme_Color::get_type(),
			'value' => Scheme_Color::COLOR_2,
		],
		'selectors' => [
			'{{WRAPPER}} .be-pack .timeline-panel, .be-pack .timeline-panel p' => 'color: {{content_color}}',
		],
		'default' => '#333333',
	]
	);
	$this->add_group_control(
		Group_Control_Typography::get_type(),
		[
			'label' => 'Title Typography',
			'name' => 'tile_typography',
			'scheme' => Scheme_Typography::TYPOGRAPHY_1,
			'selector' => '{{WRAPPER}} .be-pack .tl-heading h4',
		]
	);
	$this->add_group_control(
		Group_Control_Typography::get_type(),
		[	'label' => 'Content Typography',
			'name' => 'content_typography',
			'scheme' => Scheme_Typography::TYPOGRAPHY_1,
			'selector' => '{{WRAPPER}} .be-pack .timeline-panel',
		]
	);

	$this->add_group_control(
		Group_Control_Text_Shadow::get_type(),
		[
			'label' => 'Title Text Shadow',
			'name' => 'text_shadow',
			'selector' => '{{WRAPPER}} .tl-heading h4',
		]
	);
	$this->add_control(
		'title_margin',
		[
			'label' => __( 'Title Margin', 'be-pack' ),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors' => [
				'{{WRAPPER}} .be-pack.timeline .be-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);
	$this->end_controls_section();
	//=======Content style =======
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __( 'Box Style', 'be-pack' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'theme_color', [
				'label' => __( 'Border Color', 'be-pack' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .timeline li .tl-circ' => 'background: {{theme_color}};border:5px solid #e6e6e6 !important',
					' .timeline li .timeline-panel:before' => 'border-left:15px solid {{theme_color}}; border-right:0px solid {{theme_color}};',
					' .timeline li .timeline-panel' => 'border:1px solid {{theme_color}};',
					' .timeline::before' => 'background-color:{{theme_color}};',
				],
			]
		);
		$this->add_control(
			'bg_color', [
			'label' => __( 'Background Color', 'be-pack' ),
			'type' => Controls_Manager::COLOR,
			'scheme' => [
				'type' => Scheme_Color::get_type(),
				'value' => Scheme_Color::COLOR_2,
			],
			'selectors' => [
					'{{WRAPPER}} .be-pack .timeline-panel' => 'background-color: {{bg_color}}',
					'.timeline li .timeline-panel:after' =>'border-left: 14px solid {{bg_color}}; border-right: 0 solid {{bg_color}}'
				],
			'default' => '#fff',
		]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .timeline-panel',
			]
		);
	
		$this->end_controls_section();
		$this->start_controls_section(
			'image_style',
			[
				'label' => __( 'Image Style', 'be-pack' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'be-pack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .be-pack.timeline .timeline_pic img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'=>[
					'top' =>15,
					'right' => 15,
					'bottom' => 15,
					'left' => 15,
					'isLinked' => true,
				],
			]
		);
		$this->add_control(
			'gap',
			[
				'label' => __( 'Image Padding', 'be-pack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .be-pack.timeline .timeline_pic' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'=>[
					'top' =>15,
					'right' => 15,
					'bottom' => 15,
					'left' => 15,
					'isLinked' => true,
				],
			]
		);
		$this->end_controls_section();

	}
		

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$data	  = $settings['list'];
		$count=0;
		echo '<ul class="be-pack timeline">';
		foreach($data as $index=>$content){
		
			$thumbnail_size = $content['thumbnail_size'];
			$image= wp_get_attachment_image($content['image']['id'], $thumbnail_size, true, array('class' => 'be-image'));
			
			if($content['image']['id']!=""){
				$image =  '<div class="timeline_pic pull-left">'.$image.'</div>';
				$class='';
			}else{
				$image = '';
				$class= 'd-block';
			}
			$count= $count+1;
			if($count % 2 == 0){
				echo '<li class="timeline-inverted">';
			}
			else{
				echo '<li>';
			}
			echo '<div class="tl-circ"></div>
			  <div class="timeline-panel">
				<div class="tl-heading">
					<div class="tl-content">
						'.$image.'
						<div class="be-desc">
						<h4 class="be-title '.$class.'">'.wp_kses_post($content['list_title']).'</h4>
						<div class="be-content">'.wp_kses_post($content['list_content']).'</div>
						</div>
					</div>
				</div>
			  </div>
			</li>';
		}
      echo '</ul>';
	}
	 protected function _content_template() {
	?>
		<ul class="be-pack timeline">
		<#
			if ( settings.list ) {
				var count=0;
				_.each( settings.list, function( item, index ) {
					count = index+1;
					if(count % 2==0){
				#>
				<li class="timeline-inverted">
				<# }else{ #>
				<li>
				<# } #>
					<div class="tl-circ"></div>
					<div class="timeline-panel">
						<#
							var image = {
								id: item.image.id,
								url: item.image.url,
								size: item.thumbnail_size,
								dimension: item.thumbnail_custom_dimension,
								model: view.getEditModel()
							};
							var image_url = elementor.imagesManager.getImageUrl( image );
						#>
						<div class="tl-heading">
							<div class="tl-content">
							<# if(item.image.id!=""){
								var $class="be-title";
							#>
								<div class="timeline_pic pull-left">
									<img src="{{{ image_url }}}">
								</div>
							<# }else{ 
								var $class= "be-title d-block";
							}
							#>
								  <div class="be-desc">
								    <h4 class="{{{ $class }}}">{{{ item.list_title }}}</h4>
									<div class="be-content">{{{ item.list_content }}}</div>
								  </div>
							</div>
						</div>
					</div>
				</li>
				<#
				});
			}
		#>
		</ul>
	<?php
	}
}
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Be_Pack_Widget_Timeline() );
