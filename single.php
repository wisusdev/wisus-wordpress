<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package lewer
 */

get_header();
?>
	<!-- Cargamos el blog -->
	<main id="primary" class="site-main blog py-5">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<?php
					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content', 'blog' );
						?>

						<div class="d-grid gap-2 d-md-flex justify-content-between py-5">
							<div><?php echo get_next_post_link('%link') ?></div>
							<div><?php echo get_previous_post_link('%link') ?></div>
						</div>

						<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

						// Se registra la visita a este post
						setPostViews(get_the_ID());

					endwhile; // End of the loop.
					?>
				</div>
				<div class="col-md-4">
					<div class="position-sticky" style="top: 4rem;">
						<div class="p-4 bg-light rounded">
							<?php get_sidebar() ?>
						</div>
					</div>
				</div>
			</div>


		</div>
	</main><!-- #main -->

<?php

get_footer();
