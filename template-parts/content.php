<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wisus
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class('col-md-4 mb-3'); ?>>
	<div class="card h-100 shadow ">
		<div class="card-header">
			<?php if ( 'post' === get_post_type() ) : ?>
				<p class="text-capitalize m-1 fw-bold"><?php the_time(get_option('date_format')); ?></p><!-- .entry-meta -->
			<?php endif; ?>
		</div>

		<div class="overflow-hidden p-0 image-post">
			<?php wisus_post_thumbnail(); ?>
		</div>

		<div class="card-body">
			<?php
			if ( is_singular() ) :
				the_title( '<p class="entry-title card-title fw-bold"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" class="text-decoration-none text-black">', '</a></p>' );
			else :
				the_title( '<p class="my-3 fw-bold"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" class="text-decoration-none text-black">', '</a></p>' );
			endif;

			?>

			<!-- Post content -->
			<?php

			echo "<p class='my-3 fw-normal'>" . wp_trim_words( get_the_content(), 20 ) . "</p>";

			?>

		</div>
	</div>
</div><!-- #post-<?php the_ID(); ?> -->
