<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class Strativ_Newsletter_Widget extends Widget_Base {

    public function get_name() {
        return 'strativ-newsletter-widget';
    }

    public function get_title() {
        return __('Strativ Newsletter Widget', 'strativ');
    }

    public function get_icon() {
        return 'eicon-mail';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    // Register widget controls
    protected function _register_controls() {
        // Content Section
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'strativ'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'strativ'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Subscribe to Our Newsletter', 'strativ'),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Description', 'strativ'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('Stay updated with our latest news and promotions.', 'strativ'),
            ]
        );

        $this->add_control(
            'placeholder',
            [
                'label' => __('Input Placeholder', 'strativ'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Enter your email', 'strativ'),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'strativ'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Subscribe', 'strativ'),
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_style',
            [
                'label' => __('Style', 'strativ'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'strativ'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} h2' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __('Description Color', 'strativ'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_color',
            [
                'label' => __('Input Color', 'strativ'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} input[type="email"]' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => __('Button Color', 'strativ'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} button[type="submit"]' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background',
            [
                'label' => __('Button Background', 'strativ'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} button[type="submit"]' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    // Render widget output on the frontend
    protected function render() {
        $settings = $this->get_settings_for_display();

        echo '<h2>' . esc_html($settings['title']) . '</h2>';
        echo '<p>' . esc_html($settings['description']) . '</p>';
        echo '<form action="#" method="post">';
        echo '<input type="email" placeholder="' . esc_attr($settings['placeholder']) . '">';
        echo '<button type="submit">' . esc_html($settings['button_text']) . '</button>';
        echo '</form>';
    }

    // Define the structure and placeholders for the content template
    protected function _content_template() {
        ?>
        <h2>{{ settings.title }}</h2>
        <p>{{ settings.description }}</p>
        <form action="#" method="post">
            <input type="email" placeholder="{{ settings.placeholder }}">
            <button type="submit">{{ settings.button_text }}</button>
        </form>
        <?php
    }
}
