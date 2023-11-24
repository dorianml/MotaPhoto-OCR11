<footer>

  <nav class="footerNav">
    <?php
    wp_nav_menu(array([
      'theme_location' => 'footerMenu',
      'container' => false,
      'link_before' => '<span itemprop="name">',
      'link_after' => '</span>',
      'menu_class' => 'footerMenu'
    ]))
    ?>
  </nav>

  <script src="<?php echo get_template_directory_uri(); ?>/js/modaleContact.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $("#wpforms-34-field_3").val("<?php echo esc_attr(get_field('reference')); ?>");
    });
  </script>
  <script src="<?php echo get_template_directory_uri(); ?>/js/loadMoreIndex.js"></script>
</footer>

</body>

</html>