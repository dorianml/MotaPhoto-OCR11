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
			<button id="contactPostLink" class="menu-item-33" href="#"> Contact </button>
		</div>
	</div>
	<div class="bottomPostBarRight">
		<div class="bottomPostBarRightContent">
			<div class="grid-item" id="nextPostPreview">
				<?php
				$next_post = get_next_post();
				$previous_post = get_previous_post();

				// if ($next_post) {
				// 	// Display the thumbnail of the next post
				// 	echo '<a class="nextPostPreview" href="' . esc_url(get_permalink($next_post)) . '">';
				// 	echo '<div class="navigationButton">' . get_the_post_thumbnail($next_post, 'large') . '</div>' ; 
				// 	echo '</a>';
				// }
				?>
			</div>
			<div class="navigationButton">
				<div class="nav-previous"><?php previous_post_link('%link', '← <svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m9.474 5.209s-4.501 4.505-6.254 6.259c-.147.146-.22.338-.22.53s.073.384.22.53c1.752 1.754 6.252 6.257 6.252 6.257.145.145.336.217.527.217.191-.001.383-.074.53-.221.293-.293.294-.766.004-1.057l-4.976-4.976h14.692c.414 0 .75-.336.75-.75s-.336-.75-.75-.75h-14.692l4.978-4.979c.289-.289.287-.761-.006-1.054-.147-.147-.339-.221-.53-.221-.191-.001-.38.071-.525.215z" fill-rule="nonzero"/></svg>'); ?> </div>
				<div class="nav-next"> <?php next_post_link('%link', '→ <svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m14.523 18.787s4.501-4.505 6.255-6.26c.146-.146.219-.338.219-.53s-.073-.383-.219-.53c-1.753-1.754-6.255-6.258-6.255-6.258-.144-.145-.334-.217-.524-.217-.193 0-.385.074-.532.221-.293.292-.295.766-.004 1.056l4.978 4.978h-14.692c-.414 0-.75.336-.75.75s.336.75.75.75h14.692l-4.979 4.979c-.289.289-.286.762.006 1.054.148.148.341.222.533.222.19 0 .378-.072.522-.215z" fill-rule="nonzero"/></svg>'); ?> </div>
			</div>
			

		</div>
	</div>
</div>
<div class="relatedPost">

<h2 class=" relatedPostTitle">
VOUS AIMEREZ AUSSI
</h2>

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