<?php get_header();
global $wp_query; ?>


<div class="container">
    <div class="headerPhoto">
        <p class="bannerTitle">
            PHOTOGRAPHE EVENT
        </p>

        <?php
        // Query a random single post with a featured image
        $args = array(
            'post_type' => 'photo', // Change to the appropriate post type if needed
            'posts_per_page' => 1,
            'orderby' => 'rand',
        );

        $random_post = new WP_Query($args);

        if ($random_post->have_posts()) {
            while ($random_post->have_posts()) {
                $random_post->the_post();
                // Get the featured image URL
                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); // 'full' can be replaced with other image size names

                // Output the image element
                if ($image_url) {
                    echo '<img src="' . esc_url($image_url) . '" alt="' . get_the_title() . '" />';
                } else {
                    // Handle the case where there's no featured image
                    echo 'No featured image available.';
                }
            }
            wp_reset_postdata(); // Reset the post data
        } else {
            echo 'No posts found.';
        }
        ?>
        <!-- <img src="<?php echo get_stylesheet_directory_uri() . '/images/Photos NMota/nathalie-11.jpeg'; ?>  " alt="party-photo-by-nathalie"> -->
    </div>
    <div class="galery">
        <div class="filterNav">

            <?php
            // Get categories
            $categories = get_terms('categ', array('hide_empty' => false));
            // Get formats
            $formats = get_terms('format', array('hide_empty' => false));
            ?>
            <div class="filterType">
                <div class="filterCategory">
                    <span class="x-split-button">
                        <button class="x-button x-button-drop">CATEGORIES <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.58934 7.74408C5.2639 7.41864 4.73626 7.41864 4.41083 7.74408C4.08539 8.06951 4.08539 8.59715 4.41083 8.92259L9.41083 13.9226C9.73626 14.248 10.2639 14.248 10.5893 13.9226L15.5893 8.92259C15.9148 8.59715 15.9148 8.06951 15.5893 7.74408C15.2639 7.41864 14.7363 7.41864 14.4108 7.74408L10.0001 12.1548L5.58934 7.74408Z" fill="#313144" />
                            </svg>
                        </button>
                        <ul class="filter-drop-menu x-button-drop-menu">
                            <?php
                            foreach ($categories as $category) {
                                echo '<li><a class="ajax-LOAD-link filterLink" data-category-id="' . $category->term_id . '" id="ajax_call">' . $category->name . '</a></li>';
                            }
                            ?>
                        </ul>

                    </span>
                </div>
                <div class="filterFormat">
                    <span class="x-split-button2">
                        <button class="x-button2 x-button2-drop">FORMAT <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.58934 7.74408C5.2639 7.41864 4.73626 7.41864 4.41083 7.74408C4.08539 8.06951 4.08539 8.59715 4.41083 8.92259L9.41083 13.9226C9.73626 14.248 10.2639 14.248 10.5893 13.9226L15.5893 8.92259C15.9148 8.59715 15.9148 8.06951 15.5893 7.74408C15.2639 7.41864 14.7363 7.41864 14.4108 7.74408L10.0001 12.1548L5.58934 7.74408Z" fill="#313144" />
                            </svg></button>
                        <ul class="filter-drop-menu x-button2-drop-menu">
                            <?php
                            foreach ($formats as $format) {
                                echo '<li><a class="ajax-LOAD-link filterLink" data-format-id="' . $format->term_id . '">' . $format->name . '</a></li>';
                            }
                            ?>
                        </ul>
                    </span>
                </div>
            </div>
            <div class="filterTime">
                <span class="x-split-button3">
                    <button class="x-button3 x-button3-drop">TRIER PAR <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.58934 7.74408C5.2639 7.41864 4.73626 7.41864 4.41083 7.74408C4.08539 8.06951 4.08539 8.59715 4.41083 8.92259L9.41083 13.9226C9.73626 14.248 10.2639 14.248 10.5893 13.9226L15.5893 8.92259C15.9148 8.59715 15.9148 8.06951 15.5893 7.74408C15.2639 7.41864 14.7363 7.41864 14.4108 7.74408L10.0001 12.1548L5.58934 7.74408Z" fill="#313144" />
                        </svg></button>

                    <ul class="filter-drop-menu x-button3-drop-menu">
                        <li><a class='ajax-LOAD-link filterLink' data-order="asc">Les plus anciens</a></li>
                        <li><a class='ajax-LOAD-link filterLink' data-order="desc">Les plus récents</a></li>
                    </ul>

                </span>
            </div>
        </div>
        <?php
        // get_template_part('template-parts/photoGallery.php');
        include ('template-parts/photoGallery.php');
        ?>
    </div>
    <div class="galeryAjax" id="ajax_return"> </div>
    <!-- <div class="morePost"></div> -->
    <div class="btn__wrapper">
        <a href="#!" class="btn btn__primary" id="load-more">Charger plus</a>
    </div>
</div>

<!-- Your index template content here -->

<?php get_footer(); ?>