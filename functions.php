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

// function weichie_load_more()
// {
//     $ajaxposts = new WP_Query(array(
//         'post_type' => 'photo',
//         'posts_per_page' =>  8,
//         'orderby' => 'date',
//         'order' => 'ASC',
//         'paged' => $_POST['paged'],
//     ));

//     $response = '';

//     if ($ajaxposts->have_posts()) {
//         while ($ajaxposts->have_posts()) : $ajaxposts->the_post();
//             $thumbnail = get_the_post_thumbnail(get_the_ID(), 'full');
//             $permalink = get_the_permalink();

//             // Generate HTML structure for each post with the 'grid-item-index' div
//             $response .= '
//                 <div class="grid-item-index">
//                     <a href="' . esc_url($permalink) . '">
//                         ' . $thumbnail . '
//                     </a>
//                     <a href="' . esc_url(wp_get_attachment_url(get_post_thumbnail_id())) . '" class="preview">
//                         <img class="preview focusIcon" src="https://picsum.photos/id/870/200/300?grayscale&blur=2" alt="">
//                     </a>
//                 </div>';
//         endwhile;
//     } else {
//         $response = ''; // No posts, set response to empty string
//     }

//     echo $response;
//     exit;


// }
// add_action('wp_ajax_weichie_load_more', 'weichie_load_more');
// add_action('wp_ajax_nopriv_weichie_load_more', 'weichie_load_more');

function lightbox()
{
    $current_category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    // $categories = get_the_terms(get_the_ID(), 'categ');
    // $category_names = !empty($categories) ? wp_list_pluck($categories, 'name') : array();

    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => -1, // Retrieve all posts
        'orderby'        => 'date',
        'order'          => 'DESC',
        'tax_query'      => array( 
                'taxonomy' => 'categ',
                'field'    => 'id',
                'terms'    => $current_category_id,
        ),
    );

    $query = new WP_Query($args);

    $posts = array();
    $index = 0;

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $thumbnail_url = get_the_post_thumbnail_url();

            $categories = get_the_terms(get_the_ID(), 'categ');
            $category_names = !empty($categories) ? wp_list_pluck($categories, 'name') : array();
            
            $post_data = array(
                'post_index'     => $index,
                'post_permalink' => get_permalink(),
                'post_title'     => get_the_title(),
                'post_thumbnail' => $thumbnail_url,
                'post_category_object' => $categories,
                'post_category'       => !empty($category_names) ? $category_names[0] : '',
                'post_reference'      => get_field('reference'),
            );
            $posts[] = $post_data;
            $index++;
        }
        wp_reset_postdata();
    }

    $response['posts'] = $posts;
    $response['category'] = $category_names; // Pass the category array
    $response['reference'] = get_field('reference'); // Pass the reference

    wp_send_json($response);
    wp_die();
}

add_action('wp_ajax_request_lightbox', 'lightbox');
add_action('wp_ajax_nopriv_request_lightbox', 'lightbox');


/* INITIAL LOAD PHOTO */
function load_photo_posts($offset = 0, $posts_per_page = 8)
{
    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => $posts_per_page,
        'offset'         => $offset,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    $query = new WP_Query($args);

    $posts = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $thumbnail_url = get_the_post_thumbnail_url();

            $categories = get_the_terms(get_the_ID(), 'categ');
            $category_names = !empty($categories) ? wp_list_pluck($categories, 'name') : array();

            $post_data = array(
                'post_category_object' => $categories,
                'post_category'       => !empty($category_names) ? $category_names[0] : '',
                'post_reference'      => get_field('reference'),
                'post_permalink'      => get_permalink(),
                'post_title'          => get_the_title(),
                'post_thumbnail'      => $thumbnail_url,
            );
            $posts[] = $post_data;
        }
        wp_reset_postdata();
    }

    return $posts;
}
function initial_load_photo()
{
    $response['posts'] = load_photo_posts();
    wp_send_json($response);
    wp_die();
}
/* LOAD MORE INITIAL PHOTO */

function load_more_photo_posts()
{
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $posts = load_photo_posts($offset);
    $response['posts'] = $posts;
    wp_send_json($response);
    wp_die();
}

add_action('wp_ajax_request_initial_load_photo', 'initial_load_photo');
add_action('wp_ajax_nopriv_request_initial_load_photo', 'initial_load_photo');
add_action('wp_ajax_load_more_photo_posts', 'load_more_photo_posts');
add_action('wp_ajax_nopriv_load_more_photo_posts', 'load_more_photo_posts');

// function initial_load_photo() {
//     $args = array(
//         'post_type'      => 'photo',
//         'posts_per_page' => 8,
//         'orderby'        => 'date', // Order by date
//         'order'          => 'DESC', // Order in descending order (latest first)
//     );

//     $query = new WP_Query($args);

//     $posts = array(); // Initialize the array to hold post data

//     if ($query->have_posts()) {
//         while ($query->have_posts()) {
//             $query->the_post();
//             $thumbnail_url = get_the_post_thumbnail_url();

//             $categories = get_the_terms(get_the_ID(), 'categ');
//             $category_names = !empty($categories) ? wp_list_pluck($categories, 'name') : array();

//             $post_data = array(
//                 'post_category_object' => $categories,
//                 'post_category'       => !empty($category_names) ? $category_names[0] : '',
//                 'post_reference'      => get_field('reference'),
//                 'post_permalink'      => get_permalink(),
//                 'post_title'          => get_the_title(),
//                 'post_thumbnail'      => $thumbnail_url,
//             );
//             $posts[] = $post_data;
//         }
//         wp_reset_postdata();
//     }

//     $response['posts'] = $posts;

//     wp_send_json($response);
//     wp_die();
// }

// add_action('wp_ajax_request_initial_load_photo', 'initial_load_photo');
// add_action('wp_ajax_nopriv_request_initial_load_photo', 'initial_load_photo');


function loop_photo()
{
    $current_category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
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

    $posts = array(); // Initialize the array to hold post data

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $thumbnail_url = get_the_post_thumbnail_url();

            $categories = get_the_terms(get_the_ID(), 'categ');
            $category_names = !empty($categories) ? wp_list_pluck($categories, 'name') : array();

            $post_data = array(
                'post_category_object' => $categories,
                'post_category'       => !empty($category_names) ? $category_names[0] : '',
                'post_reference'      => get_field('reference'),
                'post_permalink'      => get_permalink(),
                'post_title'          => get_the_title(),
                'post_thumbnail'      => $thumbnail_url,
            );
            $posts[] = $post_data;
        }
        wp_reset_postdata();
    }

    $response['posts'] = $posts;

    wp_send_json($response);
    wp_die();
}

add_action('wp_ajax_request_loop_photo', 'loop_photo');
add_action('wp_ajax_nopriv_request_loop_photo', 'loop_photo');

function loop_photo_format()
{
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

    $posts = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {

            $query->the_post();
            $thumbnail_url = get_the_post_thumbnail_url();

            $categories = get_the_terms(get_the_ID(), 'categ');
            $category_names = !empty($categories) ? wp_list_pluck($categories, 'name') : array();

            $post_data = array(
                'post_category_object' => $categories,
                'post_category'       => !empty($category_names) ? $category_names[0] : '',
                'post_reference'      => get_field('reference'),
                'post_permalink'      => get_permalink(),
                'post_title'          => get_the_title(),
                'post_thumbnail'      => $thumbnail_url,
            );
            $posts[] = $post_data;
        }
        wp_reset_postdata();
    }

    $response['posts'] = $posts;

    wp_send_json($response);
    wp_die();
}

add_action('wp_ajax_request_loop_photo_format', 'loop_photo_format');
add_action('wp_ajax_nopriv_request_loop_photo_format', 'loop_photo_format');

function loop_photo_time()
{
    $order = isset($_POST['order']) ? $_POST['order'] : 'desc'; // Default to 'desc' if not provided

    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'orderby'        => 'date',
        'order'          => $order,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $thumbnail_url = get_the_post_thumbnail_url();

            $categories = get_the_terms(get_the_ID(), 'categ');
            $category_names = !empty($categories) ? wp_list_pluck($categories, 'name') : array();

            $post_data = array(
                'post_category_object' => $categories,
                'post_category'       => !empty($category_names) ? $category_names[0] : '',
                'post_reference'      => get_field('reference'),
                'post_permalink'      => get_permalink(),
                'post_title'          => get_the_title(),
                'post_thumbnail'      => $thumbnail_url,
            );
            $posts[] = $post_data;
        }
        wp_reset_postdata();
    }

    $response['posts'] = $posts;

    wp_send_json($response);
    wp_die();
}

add_action('wp_ajax_request_loop_photo_time', 'loop_photo_time');
add_action('wp_ajax_nopriv_request_loop_photo_time', 'loop_photo_time');

function enqueue_custom_scripts()
{
    wp_enqueue_script('loopPhoto_script', get_template_directory_uri() . '/js/loopPhoto.js', '1.0.0', true);
    wp_enqueue_script('initialLoadPhoto_script', get_template_directory_uri() . '/js/initialLoadPhoto.js', '1.0.0', true);
    wp_enqueue_script('loopPhotoFormat_script', get_template_directory_uri() . '/js/loopPhotoFormat.js', '1.0.0', true);
    wp_enqueue_script('loopPhotoTime_script', get_template_directory_uri() . '/js/loopPhotoTime.js', '1.0.0', true);
    wp_enqueue_script('lightbox_script', get_template_directory_uri() . '/js/lightbox.js', '1.0.0', true);
    wp_enqueue_style('style_css', get_template_directory_uri() . '/style.css', '1.0.0', true);
    wp_enqueue_style('navMobile_css', get_template_directory_uri() . '/navMobile.css', '1.0.0', true);
    wp_enqueue_style('lightbox_css', get_template_directory_uri() . '/lightbox.css', '1.0.0', true);
    wp_enqueue_style('arrowNav_css', get_template_directory_uri() . '/arrowNav.css', '1.0.0', true);
}

add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

