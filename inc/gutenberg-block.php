<?php

function wisus_register_custom_block() {
    // Enqueue block editor assets
    wp_register_script(
        'wisus-custom-block',
        get_template_directory_uri() . '/blocks/custom-block.js',
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-block-editor'),
        filemtime(get_template_directory() . '/blocks/custom-block.js')
    );

    // Register block type
    register_block_type('wisus/custom-block', array(
        'editor_script' => 'wisus-custom-block',
        'render_callback' => 'wisus_render_custom_block',
    ));
}
add_action('init', 'wisus_register_custom_block');

function wisus_render_custom_block($attributes) {
    $posts_per_page = isset($attributes['postsPerPage']) ? $attributes['postsPerPage'] : 5;
    $columns = isset($attributes['columns']) ? $attributes['columns'] : 3;

    // Query for blog posts
    $query = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => $posts_per_page,
    ));

    // Start output buffering
    ob_start();

    if ($query->have_posts()) {
        echo '<div class="custom-blog-block row row-cols-1 row-cols-md-' . esc_attr($columns) . ' g-4">';
        while ($query->have_posts()) {
            echo '<div class="col">';
            $query->the_post();
            
            get_template_part('template-parts/content', 'post');
            echo '</div>';
        }
        echo '</div>';
    }

    // Reset post data
    wp_reset_postdata();

    // Return the buffered content
    return ob_get_clean();
}