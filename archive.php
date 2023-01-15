<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wisus
 */

get_header();
?>
	<main id="primary" class="site-main main-archive">
		<div class="container py-5">
			<div class="row">
				<div class="col-md-8">

					<?php if ( have_posts() ) : ?>

						<header class="page-header mb-4">
							<?php
							the_archive_title( '<h1 class="page-title">', '</h1>' );
							the_archive_description( '<div class="archive-description">', '</div>' );
							?>
						</header><!-- .page-header -->

						<div class="row">
							<?php
							/* Start the Loop */
							while ( have_posts() ) :
								the_post();

								/*
								 * Include the Post-Type-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
								 */
								get_template_part( 'template-parts/content', get_post_type() );

							endwhile;
							?>
						</div>

						<div class="pt-4">
							<?php the_posts_navigation(); ?>
						</div>

						<?php

					else :

						get_template_part( 'template-parts/content', 'none' );

					endif;
					?>
				</div>
				<div class="col-md-4">
					<div class="position-sticky" style="top: 4rem;">
						<div class="p-4 bg-light rounded">
							<?php get_sidebar(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>

	</main><!-- #main -->

<?php
get_footer();
