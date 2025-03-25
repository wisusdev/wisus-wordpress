<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wisus
 */

get_header();
?>

<?php
    $sidebarEnabled = get_theme_mod( 'wisus_enable_sidebar');
    $containerFluidEnabled = get_theme_mod( 'wisus_container_fluid');
?>
	<main id="primary" class="page-main py-4 container<?php echo $containerFluidEnabled ? '-fluid' : ''; ?>">
        <div class="row">
            <div class="mb-3 <?php echo $sidebarEnabled ? 'col-md-8' : 'col-md-12'; ?>">
                <?php
                while ( have_posts() ) :
                    the_post();

                    get_template_part( 'template-parts/content', 'page' );

                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;

                endwhile; // End of the loop.
                ?>
            </div>
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
	</main><!-- #main -->
<?php
get_footer();
