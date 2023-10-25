<?php get_header(); ?>
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
</div>

<!-- Your index template content here -->

<?php get_footer(); ?>