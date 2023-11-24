<?php
function mota3_enqueue_styles()
{

    // Enqueue votre propre feuille de style personnalisée
    wp_enqueue_style('mota3-CSS', get_stylesheet_directory_uri() . '/style.css', array('parent-style'), '1.0.0');
}

add_action('wp_enqueue_scripts', 'mota3_enqueue_styles');

function register_my_menus()
{
    register_nav_menus(
        array(
            'main-menu' => __('Menu Header'),
            'footer-menu' => __('Menu Footer'),
            'contact-menu' => __('Menu Contact'),
        )
    );
}

add_action('init', 'register_my_menus');

function weichie_load_more()
{
    $ajaxposts = new WP_Query(array(
        'post_type' => 'photo',
        'posts_per_page' =>  8,
        'orderby' => 'date',
        'order' => 'ASC',
        'paged' => $_POST['paged'],
    ));

    $response = '';

    if ($ajaxposts->have_posts()) {
        while ($ajaxposts->have_posts()) : $ajaxposts->the_post();
            $thumbnail = get_the_post_thumbnail(get_the_ID(), 'full');
            $permalink = get_the_permalink();
            $response .= '<a href="' . $permalink . '">' . $thumbnail . '</a>';

        endwhile;
    } else {
        $response = '';
    }

    echo $response;
    exit;
}
add_action('wp_ajax_weichie_load_more', 'weichie_load_more');
add_action('wp_ajax_nopriv_weichie_load_more', 'weichie_load_more');
