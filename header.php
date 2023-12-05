<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width" />
    <?php wp_head(); ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/navMobile.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/lightbox.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
</head>

<body>
    <header id="header" class="header" role="banner">
        <nav class="mainNav">
            <img src="<?php echo get_stylesheet_directory_uri() . '/images/Logo.svg'; ?>  " alt="logo-nathalie-mota">
            <div class="wp-mainMenu">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'main-menu',
                    'menu_class' => 'main-menu',
                )); ?>
            </div>
            <div id="myModal" class="modal">
                <!-- Modal content -->
                <?php get_template_part('template-parts/modalContact') ?>
            </div>
        </nav>
        <?php get_template_part('template-parts/navMobile') ?>
    </header>