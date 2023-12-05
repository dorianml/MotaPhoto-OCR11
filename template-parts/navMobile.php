<div class="hamburger-menu">
<img src="<?php echo get_stylesheet_directory_uri() . '/images/Logo.svg'; ?>  " alt="logo-nathalie-mota">

    <input id="menu__toggle" type="checkbox" />
    <label class="menu__btn" for="menu__toggle">
      <span></span>
    </label>

    <ul class="menu__box">
    <?php
    wp_nav_menu(array(
        'theme_location' => 'main-menu',
        'menu_class' => 'main-menu',
    )); ?>
    </ul>
  </div>
