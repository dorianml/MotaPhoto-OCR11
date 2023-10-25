<?php
function mota3_enqueue_styles() {

    // Enqueue votre propre feuille de style personnalisée
    wp_enqueue_style('mota3-CSS', get_stylesheet_directory_uri() . '/style.css', array('parent-style'), '1.0.0');
}

add_action('wp_enqueue_scripts', 'mota3_enqueue_styles');

function register_my_menus() {
    register_nav_menus(
    array(
    'main-menu' => __( 'Menu Header' ),
    'footer-menu' => __( 'Menu Footer' ),
    'contact-menu' => __( 'Menu Contact' ),
    )
    );
   }
   add_action( 'init', 'register_my_menus' );
   ?>