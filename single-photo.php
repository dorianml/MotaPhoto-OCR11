<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

/* Start the Loop */
// while (have_posts()) :
// 	the_post();

?>

<div class="singlePostContainer">
	<div class="SinglePost-LeftGroupContainer">
		<h2> <?php the_title() ?> </h2>
		<?php

		$custom_field_value = get_field('reference');

		// Check if the custom field has a value
		if ($custom_field_value) {
			echo '<p> RÉFÉRENCE: ' . $custom_field_value . '</p>';
		}

		// Get the value of the custom field for the current post
		$custom_field_value = get_field('type');

		// Check if the custom field has a value
		if ($custom_field_value) {
			echo '<p> TYPE: ' . $custom_field_value . '</p>';
		}

		?>
		<?php
		$current_post_id = get_the_ID();

		// Get terms from the "CATEG" taxonomy associated with the current post
		$terms = get_the_terms($current_post_id, 'categ');

		if ($terms && !is_wp_error($terms)) {
			foreach ($terms as $term) {
				echo 'CATÉGORIE: ' . '<a href="' . get_term_link($term) . '">' . $term->name . '</a> ';
			}
		}
		?>
		<?php
		$current_post_id = get_the_ID();
		// Get terms from the "FORMAT" taxonomy associated with the current post
		$terms = get_the_terms($current_post_id, 'format');

		if ($terms && !is_wp_error($terms)) {
			foreach ($terms as $term) {
				echo '<p> FORMAT: ' . '<a href="' . get_term_link($term) . '">' . $term->name . '</a> </p>';
			}
		}
		?>
		<?php echo 'ANNEE: ' ?> <?php echo get_the_date('Y') ?>
	</div>

	<div class="singlePost-RightGroupContainer">
		<?php the_post_thumbnail('large') ?>
	</div>
</div>

<div class="bottomPostBar">
	<div class="bottomPostBarLeft">
		<div class="contactPost">
			<h4>Cette photo vous interesse ?</h4>
			<a id="contactPostLink" class="menu-item-33" href="#"> Contact </a>
		</div>
	</div>
	<div class="bottomPostBarRight">
		<div class="bottomPostBarRightContent">
			<div class="grid-item">
				<?php
				$next_post = get_next_post();

				if ($next_post) {
					// Display the thumbnail of the next post
					echo '<a class="nextPostPreview" href="' . esc_url(get_permalink($next_post)) . '">';
					echo get_the_post_thumbnail($next_post, 'large');
					echo '</a>';
				}
				?>
			</div>
			<div class="navigationButton">
				<div class="nav-previous"><?php previous_post_link('%link', '←'); ?></div>
				<div class="nav-next"><?php next_post_link('%link', '→'); ?></div>
			</div>
			<?php
			?>


		</div>
	</div>
</div>
<div class="relatedPost">

<?php
$current_post_id = get_the_ID();
// Get terms from the "categ" taxonomy associated with the current post
$categTerms = get_the_terms($current_post_id, 'categ');

// Extract term IDs from the terms
$term_ids = array();
foreach ($categTerms as $term) {
    $term_ids[] = $term->term_id;
}

$related_query = new WP_Query(array(
    'post_type' => 'photo',
    'posts_per_page' => 2,
    'orderby' => 'date',
    'order' => 'ASC',
    'tax_query' => array(
        array(
            'taxonomy' => 'categ',
            'field' => 'id',
            'terms' => $term_ids,
        ),
    ),
));

if ($related_query->have_posts()) { ?>

    <div class="related-posts-grid">

        <?php while ($related_query->have_posts()) { ?>

            <?php $related_query->the_post(); ?>

            <div class="grid-related-item">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('large'); ?>
                </a>
            </div>

        <?php } ?>
    </div>
    <?php
}
wp_reset_postdata(); // Reset post data to the main loop
?>
<div class="buttonToutesPhotos">
	<a href="#" class="buttonAllPhoto"> Toutes les photos </a>
</div>
</div>





<?php get_footer(); ?>