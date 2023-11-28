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

function loop_photo() {
    $current_category_id = isset($_POST['category_id']) ? $_POST['category_id'] : 0;

    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'tax_query'      => array(
            array(
                'taxonomy' => 'categ',
                'field'    => 'id',
                'terms'    => $current_category_id,
            ),
        ),
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $response['posts'] = $query->posts;
    } else {
        $response['posts'] = array();
    }

    wp_send_json($response);
    wp_die();
}

// Enqueue scripts and styles


function loop_photo_format() {
    // $taxonomy = isset($_POST['taxonomy']) ? $_POST['taxonomy'] : 'categ'; // Default to 'categ' if not provided
    $current_format_id = isset($_POST['format_id']) ? $_POST['format_id'] : 0;

    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'tax_query'      => array(
            array(
                'taxonomy' => 'format',
                'field'    => 'id',
                'terms'    => $current_format_id,
            ),
        ),
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $response['posts'] = $query->posts;
    } else {
        $response['posts'] = array();
    }

    wp_send_json($response);
    wp_die();
}

function request_loop_photo_time() {
    $order = isset($_POST['order']) ? $_POST['order'] : 'desc'; // Default to 'desc' if not provided

    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'orderby'        => 'date',
        'order'          => $order,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $response['posts'] = $query->posts;
    } else {
        $response['posts'] = array();
    }

    wp_send_json($response);
    wp_die();
}

// Enqueue scripts and styles

function enqueue_custom_scripts() {
    wp_enqueue_script('loopPhoto_script', get_template_directory_uri() . '/js/loopPhoto.js', array('jquery'), '1.0.0', true);
    wp_localize_script('loopPhoto_script', 'loop_photo_js', array('ajax_url' => admin_url('admin-ajax.php')));
    wp_enqueue_script('loopPhotoFormat_script', get_template_directory_uri() . '/js/loopPhotoFormat.js', array('jquery'), '1.0.0', true);
    wp_localize_script('loopPhotoFormat_script', 'loop_photo_format_js', array('ajax_url' => admin_url('admin-ajax.php')));
    wp_enqueue_script('loopPhotoTime_script', get_template_directory_uri() . '/js/loopPhotoFormat.js', array('jquery'), '1.0.0', true);
    wp_localize_script('loopPhotoTime_script', 'loop_photo_time_js', array('ajax_url' => admin_url('admin-ajax.php')));
}

add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

add_action('wp_ajax_request_loop_photo', 'loop_photo');
add_action('wp_ajax_nopriv_request_loop_photo', 'loop_photo');

add_action('wp_ajax_request_loop_photo_format', 'loop_photo_format');
add_action('wp_ajax_nopriv_request_loop_photo_format', 'loop_photo_format');

