<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package wisus
 */

get_header();
?>

<?php
    $columns = get_theme_mod( 'wisus_columns', 3 );
    $sidebarEnabled = get_theme_mod( 'wisus_enable_sidebar');
    $containerFluidEnabled = get_theme_mod( 'wisus_container_fluid');
?>
    <main id="primary" class="site-main py-4 container<?php echo $containerFluidEnabled ? '-fluid' : ''; ?>">
		<?php if ( have_posts() ) : ?>
			<header class="page-header">
				<h1 class="page-title mb-4">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'wisus' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</header><!-- .page-header -->
            <div class="row">
                <div class="mb-3 <?php echo $sidebarEnabled ? 'col-md-8' : 'col-md-12'; ?>">
                    <div class="row row-cols-1 row-cols-md-<?php echo esc_attr( $columns ); ?> g-4">
                        <?php
                        /* Start the Loop */
                        while ( have_posts() ) : ?>
                            <div class="col">
                                <?php
                                    the_post();

                            /**
                             * Run the loop for the search to output the results.
                             * If you want to overload this in a child theme then include a file
                             * called content-search.php and that will be used instead.
                             */
                            get_template_part( 'template-parts/content', 'search' );
                            ?>
                            </div>
                        <?php
                        endwhile;
                        the_posts_navigation();
                    else :
                        get_template_part( 'template-parts/content', 'none' );
                    endif;
                    ?>
                </div>
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
	</main>
<?php
get_footer();
