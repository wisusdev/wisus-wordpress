<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package wisus
 */

get_header();
?>

    <main id="primary" class="site-main single-container container py-4">

        <?php
        while ( have_posts() ) :
            the_post();

            get_template_part( 'template-parts/content' );

            ?>
				<div class="d-grid gap-2 d-flex justify-content-between p-3 bg-body-secondary rounded mb-3">
					<div><?php echo get_next_post_link('%link') ?></div>
					<div><?php echo get_previous_post_link('%link') ?></div>
				</div>
			<?php

            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;

        endwhile; // End of the loop.
        ?>

    </main><!-- #main -->

<?php
get_sidebar();
get_footer();