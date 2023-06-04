<?php
/**
 * Plugin Name: Strativ Elementor Custom Widgets
 * Description: Elementor custom widgets from Strativ.
 * Plugin URI:  https://github.com/Mohib04/strativ
 * Version:     1.0.0
 * Author:      Mohibbulla Munshi
 * Author URI:  https://www.linkedin.com/in/mohibbullamunshi/
 * Text Domain: strativ
 *
 * Elementor tested up to: 3.5.0
 * Elementor Pro tested up to: 3.5.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function register_strativ_blog_custom_widgets($widgets_manager)
{
    require_once(__DIR__ . '/widgets/strativ-blog-widget.php');
    require_once(__DIR__ . '/widgets/strativ-newsletter-widget.php');

    $widgets_manager->register_widget_type(new \Strativ_Blog_Widget());
    $widgets_manager->register_widget_type(new \Strativ_Newsletter_Widget());
}
add_action('elementor/widgets/widgets_registered', 'register_strativ_blog_custom_widgets');

// Enqueue Bootstrap CSS.
function enqueue_bootstrap()
{
    wp_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');

    // Enqueue Bootstrap JS and its dependencies (jQuery).
    wp_enqueue_script('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), '4.5.2', true);
}
add_action('wp_enqueue_scripts', 'enqueue_bootstrap');
