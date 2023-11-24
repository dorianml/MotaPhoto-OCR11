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

        <?php
        $posts_per_page = 8; // Default number of posts per page

        // Check if a custom posts_per_page value is passed via AJAX
        if (isset($_POST['custom_posts_per_page']) && is_numeric($_POST['custom_posts_per_page'])) {
            $posts_per_page = intval($_POST['custom_posts_per_page']);
        }
        // $current_post_id = get_the_ID();
        // // Get terms from the "categ" taxonomy associated with the current post
        // $terms = get_the_terms($current_post_id, 'categ');

        $related_query = new WP_Query(array(
            'post_type' => 'photo',
            'posts_per_page' =>  $posts_per_page,
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
                    </div>
                <?php } ?>
            </div>
        <?php
        }
        ?>
    </div>
    <?php wp_reset_postdata(); ?>
    <div class="morePost"></div>
    <div class="btn__wrapper">
        <a href="#!" class="btn btn__primary" id="load-more">Load more</a>
    </div>
</div>

<!-- Your index template content here -->

<?php get_footer(); ?>