<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


class Strativ_Blog_Widget extends \Elementor\Widget_Base
{
  

    /**
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'Strativ Blog';
    }


    /**
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__('Strativ Blog', 'strativ');
    }

    /**
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-post-list';
    }


    /**
     * @return string Widget help URL.
     */
    public function get_custom_help_url()
    {
        return 'https://essentialwebapps.com/category/elementor-tutorial/';
    }

    /**
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return [ 'general' ];
    }

    /**
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
        return [ 'strativ', 'blog', 'stativ-blog', 'essential' ];
    }

    /**
     * Register widget controls.
     */
protected function _register_controls()
{
    // Content Controls Section
    $this->start_controls_section(
        'section_content',
        [
            'label' => __('Content', 'your-text-domain'),
        ]
    );

    $this->add_control(
        'data_source',
        [
            'label' => __('Data Source', 'your-text-domain'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'all',
            'options' => [
                'all' => __('All Posts', 'your-text-domain'),
                'category' => __('Specific Category', 'your-text-domain'),
                'tag' => __('Specific Tag', 'your-text-domain'),
            ],
        ]
    );

    $this->add_control(
        'category',
        [
            'label' => __('Category', 'your-text-domain'),
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
            'label' => __('Tag', 'your-text-domain'),
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
            'label' => __('Order By', 'your-text-domain'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'date',
            'options' => [
                'date' => __('Date', 'your-text-domain'),
                'title' => __('Title', 'your-text-domain'),
                'rand' => __('Random', 'your-text-domain'),
            ],
        ]
    );

    $this->add_control(
        'order',
        [
            'label' => __('Sort Order', 'your-text-domain'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'desc',
            'options' => [
                'asc' => __('Ascending', 'your-text-domain'),
                'desc' => __('Descending', 'your-text-domain'),
            ],
        ]
    );

    $this->add_control(
        'exclude',
        [
            'label' => __('Exclude Posts', 'your-text-domain'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'description' => __('Enter comma-separated post IDs to exclude from the results.', 'your-text-domain'),
        ]
    );

    $this->add_control(
        'offset',
        [
            'label' => __('Offset', 'your-text-domain'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0,
            'default' => 0,
            'description' => __('Number of posts to skip in the results.', 'your-text-domain'),
        ]
    );

    $this->end_controls_section();

    // Style Controls Section
    $this->start_controls_section(
        'section_style',
        [
            'label' => __('Style', 'your-text-domain'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );
    $this->add_control(
        'blog_design',
        [
            'label' => __('Blog Design', 'your-text-domain'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'design-1',
            'options' => [
                'design-1' => __('Design 1', 'your-text-domain'),
                'design-2' => __('Design 2', 'your-text-domain'),
                'design-3' => __('Design 3', 'your-text-domain'),
            ],
        ]
    );

    $this->add_control(
        'image_size',
        [
            'label' => __('Image Size', 'your-text-domain'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'thumbnail',
            'options' => [
                'thumbnail' => __('Thumbnail', 'your-text-domain'),
                'medium' => __('Medium', 'your-text-domain'),
                'large' => __('Large', 'your-text-domain'),
                'full' => __('Full', 'your-text-domain'),
            ],
        ]
    );

    $this->add_control(
        'columns',
        [
            'label' => __('Columns', 'your-text-domain'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => '3',
            'options' => [
                '1' => __('1 Column', 'your-text-domain'),
                '2' => __('2 Columns', 'your-text-domain'),
                '3' => __('3 Columns', 'your-text-domain'),
                '4' => __('4 Columns', 'your-text-domain'),
            ],
        ]
    );

    $this->add_control(
        'space_between',
        [
            'label' => __('Space Between', 'your-text-domain'),
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
            'label' => __('Items per Page', 'your-text-domain'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 10,
        ]
    );

    $this->add_control(
        'pagination',
        [
            'label' => __('Pagination', 'your-text-domain'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __('Show', 'your-text-domain'),
            'label_off' => __('Hide', 'your-text-domain'),
            'default' => 'yes',
        ]
    );


    // ... Existing style controls ...

    $this->end_controls_section();
}

/**
 * Get category options for the control.
 */
private function get_category_options()
{
    $categories = get_categories();
    $options = [];

    foreach ($categories as $category) {
        $options[$category->term_id] = $category->name;
    }

    return $options;
}

/**
 * Get tag options for the control.
 */
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
    <div class="card" style="">
        <?php
                if (has_post_thumbnail()) {
                    echo '<a class="card-img-top" href="' . get_permalink() . '">' . get_the_post_thumbnail() . '</a>';
                }
            ?>
        <div class="card-body">
            <h5 class="card-title">
                <?php echo '<h2><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>'; ?>
            </h5>
            <p class="card-text">
                <?php echo '<div class="card-text">' . wp_trim_words(get_the_content(), 10, '...') . '</div>';
            ?>
            </p>
            <a href="<?php echo get_permalink(); ?>"
                class="btn btn-primary">Go somewhere</a>
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
        echo __('No posts found.', 'your-text-domain');
    }
    echo '</div>';
    echo '</div>';


}





}
