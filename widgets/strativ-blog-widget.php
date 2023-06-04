<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Strativ_Blog_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'Strativ Blog';
    }

    public function get_title()
    {
        return esc_html__('Strativ Blog', 'strativ');
    }

    public function get_icon()
    {
        return 'eicon-post-list';
    }

    public function get_custom_help_url()
    {
        return 'https://essentialwebapps.com/category/elementor-tutorial/';
    }

    public function get_categories()
    {
        return ['general'];
    }

    public function get_keywords()
    {
        return ['strativ', 'blog', 'stativ-blog', 'essential'];
    }

    protected function _register_controls()
    {
        // Content Controls Section
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'strativ'),
            ]
        );

        $this->add_control(
            'data_source',
            [
                'label' => __('Data Source', 'strativ'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'all',
                'options' => [
                    'all' => __('All Posts', 'strativ'),
                    'category' => __('Specific Category', 'strativ'),
                    'tag' => __('Specific Tag', 'strativ'),
                ],
            ]
        );

        $this->add_control(
            'category',
            [
                'label' => __('Category', 'strativ'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->get_category_options(),
                'condition' => [
                    'data_source' => 'category',
                ],
            ]
        );

        $this->add_control(
            'tag',
            [
                'label' => __('Tag', 'strativ'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->get_tag_options(),
                'condition' => [
                    'data_source' => 'tag',
                ],
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => __('Order By', 'strativ'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => __('Date', 'strativ'),
                    'title' => __('Title', 'strativ'),
                    'rand' => __('Random', 'strativ'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __('Sort Order', 'strativ'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'asc' => __('Ascending', 'strativ'),
                    'desc' => __('Descending', 'strativ'),
                ],
            ]
        );

        $this->add_control(
            'exclude',
            [
                'label' => __('Exclude Posts', 'strativ'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'description' => __('Enter comma-separated post IDs to exclude from the results.', 'strativ'),
            ]
        );

        $this->add_control(
            'offset',
            [
                'label' => __('Offset', 'strativ'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'default' => 0,
                'description' => __('Number of posts to skip in the results.', 'strativ'),
            ]
        );

        $this->end_controls_section();

        // Style Controls Section
        $this->start_controls_section(
            'section_style',
            [
                'label' => __('Style', 'strativ'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'blog_design',
            [
                'label' => __('Blog Design', 'strativ'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'design-1',
                'options' => [
                    'design-1' => __('Design 1', 'strativ'),
                    'design-2' => __('Design 2', 'strativ'),
                    'design-3' => __('Design 3', 'strativ'),
                ],
            ]
        );

        $this->add_control(
            'image_size',
            [
                'label' => __('Image Size', 'strativ'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'thumbnail',
                'options' => [
                    'thumbnail' => __('Thumbnail', 'strativ'),
                    'medium' => __('Medium', 'strativ'),
                    'large' => __('Large', 'strativ'),
                    'full' => __('Full', 'strativ'),
                ],
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => __('Columns', 'strativ'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => __('1 Column', 'strativ'),
                    '2' => __('2 Columns', 'strativ'),
                    '3' => __('3 Columns', 'strativ'),
                    '4' => __('4 Columns', 'strativ'),
                ],
            ]
        );

        $this->add_control(
            'space_between',
            [
                'label' => __('Space Between', 'strativ'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .your-blog-container .your-blog-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'items_per_page',
            [
                'label' => __('Items per Page', 'strativ'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 10,
            ]
        );

        $this->add_control(
            'pagination',
            [
                'label' => __('Pagination', 'strativ'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'strativ'),
                'label_off' => __('Hide', 'strativ'),
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
    }

    private function get_category_options()
    {
        $categories = get_categories();
        $options = [];

        foreach ($categories as $category) {
            $options[$category->term_id] = $category->name;
        }

        return $options;
    }

    private function get_tag_options()
    {
        $tags = get_tags();
        $options = [];

        foreach ($tags as $tag) {
            $options[$tag->term_id] = $tag->name;
        }

        return $options;
    }

    protected function render()
    {

        $settings = $this->get_settings();

        // Query Arguments
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'orderby' => $settings['orderby'],
            'order' => $settings['order'],
            'offset' => $settings['offset'],
            'posts_per_page' => $settings['items_per_page'],
        );

        // Exclude Posts
        if (!empty($settings['exclude'])) {
            $excluded_posts = explode(',', $settings['exclude']);
            $excluded_posts = array_map('trim', $excluded_posts);
            $args['post__not_in'] = $excluded_posts;
        }

        // Data Source: Specific Category or Tag
        if ($settings['data_source'] === 'category') {
            $args['category__in'] = $settings['category'];
        } elseif ($settings['data_source'] === 'tag') {
            $args['tag__in'] = $settings['tag'];
        }

        // Query the posts
        $query = new \WP_Query($args);

        if ($query->have_posts()) {
            echo '<div class="your-blog-container columns-' . $settings['columns'] . '">';

            // Start the Loop
            echo '<div class="container">';
            echo '<div class="row">';
            while ($query->have_posts()) {
                $query->the_post();
                ?>
                <div class="col-md-4">
                    <div class="card">
                        <p class="card-title">
                            <?php 
                            $categories = get_the_category(); // Get the categories for the current post
                            if (!empty($categories)) {
                                foreach ($categories as $category) {
                                    // Display the category name
                                    $category_link = get_category_link($category->term_id);
                                     echo '<p><a style="font-size: 25px; margin-right:10%; margin-left:10%" href="' . esc_url($category_link) . '">' . $category->name . '</a>'.get_the_date().' </p>';  
                                }
                            }
                            ?>
                        </p>
                       
                        <div class="card-body">
                             <?php
                                if (has_post_thumbnail()) {
                                    echo '<a class="card-img-top" href="' . get_permalink() . '">' . get_the_post_thumbnail() . '</a>';
                                }
                            ?>
                            <h3 class="card-text">
                                <?php echo '<div class="card-text">' . get_the_title() . '</div>';
                                ?>
                            </h3>
                            <p class="card-text">
                                <?php echo '<div class="card-text">' . wp_trim_words(get_the_content(), 10, '...') . '</div>';
                                ?>
                            </p>
                            <a href="<?php echo get_permalink(); ?>"
                               class="btn btn-link">See More</a>
                        </div>
                    </div>
                </div>
            <?php
            }

            // Pagination
            if ($settings['pagination'] === 'yes') {
                echo '<div class="your-blog-pagination">';
                echo paginate_links(array(
                    'total' => $query->max_num_pages,
                ));
                echo '</div>';
            }
            echo '</div>';
            // Restore original Post Data
            wp_reset_postdata();
        } else {
            echo __('No posts found.', 'strativ');
        }
        echo '</div>';
        echo '</div>';
    }


}
