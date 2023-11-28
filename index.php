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
    <div class="filterNav">

        <?php
        // Get categories
        $categories = get_terms('categ', array('hide_empty' => false));
        // Get formats
        $formats = get_terms('format', array('hide_empty' => false));
        ?>
        <div class="filterTab">
            <span class="x-split-button">
                <button class="x-button x-button-main">&#10070;CATEGORIE</button>
                <button class="x-button x-button-drop">&#9660;</button>
                <ul class="x-button-drop-menu">
                    <?php
                    foreach ($categories as $category) {
                        echo '<li><a class="ajax-category-link" data-category-id="' . $category->term_id . '" id="ajax_call">' . $category->name . '</a></li>';
                    }
                    ?>
                </ul>

            </span>
        </div>
        <div class="filterTab">
            <span class="x-split-button3">
                <button class="x-button3 x-button3-main">&#10070; TRIER PAR</button>
                <button class="x-button3 x-button3-drop">&#9660;</button>
                <ul class="x-button3-drop-menu">
                    <li><a class='ajax_time_link' href="?orderby=date&order=asc" data-order="asc">OLDEST</a></li>
                    <li><a class='ajax_time_link' href="?orderby=date&order=desc" data-order="desc">NEWEST</a></li>
                </ul>
            </span>
        </div>
        <div class="filterTab">
            <span class="x-split-button2">
                <button class="x-button2 x-button2-main">&#10070; FORMAT</button>
                <button class="x-button2 x-button2-drop">&#9660;</button>
                <ul class="x-button2-drop-menu">
                    <?php
                    foreach ($formats as $format) {
                        echo '<li><a class="ajax-format-link" data-format-id="' . $format->term_id . '">' . $format->name . '</a></li>';
                    }
                    ?>
                </ul>
            </span>
        </div>
    </div>

    <div class="galery">

        <?php

        $related_query = new WP_Query(array(
            'post_type' => 'photo',
            'posts_per_page' =>  8,
            'orderby' => 'date',
            'order' => 'ASC',
            'paged' => 1,
        ));

        if ($related_query->have_posts()) { ?>
            <div class="related-posts-grid">
                <?php while ($related_query->have_posts()) { ?>
                    <?php $related_query->the_post(); ?>
                    <div class="grid-item-index">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('full'); ?>
                        </a>
                        <a href="<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>" class="preview">
                            <img class="preview focusIcon" src="https://picsum.photos/id/870/200/300?grayscale&blur=2" alt="">
                        </a>
                    </div>

                <?php } ?>
            </div>
        <?php
        }
        ?>
    </div>
    <div class="galeryAjax" id="ajax_return">

    </div>
    <div class="morePost"></div>
    <div class="btn__wrapper">
        <a href="#!" class="btn btn__primary" id="load-more">Load more</a>
    </div>
</div>

<!-- Your index template content here -->

<?php get_footer(); ?>