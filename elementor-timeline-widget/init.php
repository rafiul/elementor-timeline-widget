<?php
/**
 * Plugin Name: 3r Elementor Timeline Widget
 * Description: 3r Elementor Timeline Widget Plugin add timeline element to Elementor Page builder.
 * Plugin URI: https://wordpress.org/plugins/3r-elementor-timeline-widget
 * Version: 1.2
 * Author: B.M. Rafiul Alam
 * Author URI: https://themeforest.net/user/3rtheme/portfolio
 * Text Domain: be-pack
 */
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'THREE_ELEMENTOR_URL', plugins_url( '/', __FILE__ ) );

add_action( 'elementor/preview/enqueue_styles', 'three_elementor_enqueue_style' );
add_action('wp_enqueue_scripts', 'three_elementor_enqueue_style');

function three_elementor_enqueue_style() {
    wp_enqueue_style( 'three-preview', THREE_ELEMENTOR_URL  . 'assets/css/style.css', array());
}

class ThreeElementorTimeline {
 
   private static $instance = null;
 
   public static function get_instance() {
      if ( ! self::$instance )
         self::$instance = new self;
      return self::$instance;
   }
 
   public function init(){
      add_action( 'elementor/widgets/widgets_registered', array( $this, 'widgets_registered' ) );
   }
 
   public function widgets_registered() {
 
      // We check if the Elementor plugin has been installed / activated.
      if(defined('ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base')){

         // We look for any theme overrides for this custom Elementor element.
         // If no theme overrides are found we use the default one in this plugin.
         $widget_file = get_template_directory() .'/elementor-timeline/timeline-widget.php';
         $template_file = locate_template($widget_file);
         if ( !$template_file || !is_readable( $template_file ) ) {
            $template_file = plugin_dir_path(__FILE__).'/timeline-widget.php' ; 
         }
         if ( $template_file && is_readable( $template_file ) ) {
            require_once $template_file;
         }
      }
   }
}
 
ThreeElementorTimeline::get_instance()->init();