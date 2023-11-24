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
			echo '<p> REFERENCE: ' . $custom_field_value . '</p>';
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
				echo 'CATEGORIE: ' . '<a href="' . get_term_link($term) . '">' . $term->name . '</a> ';
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
		<?php the_post_thumbnail('thumbnail') ?>
	</div>
</div>

<div class="bottomPostBar">
	<div class="bottomPostBarLeft">
		<div class="contactPost">
			<h4>Cette photo vous interesse ?</h4>
			<a id="contactPostLink" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-33" href="#top"> Contact </a>
		</div>
	</div>
	<div class="bottomPostBarRight">
		<div class="bottomPostBarRightContent">
			<div class="grid-item">
				<?php
				$next_post = get_next_post();

				if ($next_post) {
					// Display the thumbnail of the next post
					echo '<a href="' . esc_url(get_permalink($next_post)) . '">';
					echo get_the_post_thumbnail($next_post, 'thumbnail');
					echo '</a>';
				}
				?>
			</div>
			<div class="navigation">
				<div class="nav-previous"><?php previous_post_link('%link', 'Previous Post'); ?></div>
				<div class="nav-next"><?php next_post_link('%link', 'Next Post'); ?></div>
			</div>
			<?php
			?>


		</div>
	</div>
</div>
<div class="relatedPost">

	<?php
	$related_query = new WP_Query(array(
		'post_type' => 'photo',
		'posts_per_page' => 2,
		'orderby' => 'date',
		'order' => 'ASC',
	));

	if ($related_query->have_posts()) { ?>

		<div class="related-posts-grid">

			<?php while ($related_query->have_posts()) { ?>

				<?php
				$related_query->the_post(); ?>

				<div class="grid-related-item">
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail('thumbnail'); ?>
					</a>

				</div>

			<?php } ?>
		</div>
		<!-- <div class="navigation">
				<div class="nav-previous"><?php // previous_post_link(); 
											?></div>
				<div class="nav-next"><?php // next_post_link(); 
										?></div>
			</div> -->
	<?php
	}
	?>

</div>
</div>


<!-- <?php // endwhile; -->

		get_footer(); ?>