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

<?php
	$sidebarEnabled = get_theme_mod( 'wisus_enable_sidebar');
    $containerFluidEnabled = get_theme_mod( 'wisus_container_fluid');
?>
    <main id="primary" class="site-main single-container py-4 container<?php echo $containerFluidEnabled ? '-fluid' : ''; ?>">
        <div class="row">
            <div class="mb-3 <?php echo $sidebarEnabled ? 'col-md-8' : 'col-md-12'; ?>">
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

				<?php if( $sidebarEnabled) { ?>
                    <div class="mb-3 col-md-4">
                        <div class="card">
                            <div class="card-body">
								<?php get_sidebar(); ?>
                            </div>
                        </div>
                    </div>
				<?php } ?>
            </div>
        </div>
    </main><!-- #main -->
<?php
get_footer();