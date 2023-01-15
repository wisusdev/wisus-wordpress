<?php
/*
* Template Name: Sin container (No sidebar)
*/

get_header();
?>
	<main id="primary" class="site-main main-sin-container">
		<div class="no-sidebar page-no-container">
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'page' );

				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>
		</div>
	</main><!-- #main -->

<?php
get_footer();
