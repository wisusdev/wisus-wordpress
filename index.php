<?php

/**
 * The main template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
	<main id="primary" class="site-main pb-4 container<?php echo $containerFluidEnabled ? '-fluid' : ''; ?>">
		<?php
			if ( have_posts() ) :
			if ( is_home()  ) :
		?>
		<header>
			<h1 class="page-title mb-4"><?php single_post_title(); ?></h1>
		</header>
		<div class="row">
			<div class="mb-3 <?php echo $sidebarEnabled ? 'col-md-8' : 'col-md-12'; ?>">
				<div class="row row-cols-1 row-cols-md-<?php echo esc_attr( $columns ); ?> g-4">
					<?php
					endif;

					/* Start the Loop */
					while ( have_posts() ) : ?>
						<div class="col">
							<?php
							the_post();
							get_template_part( 'template-parts/content', get_post_type() );
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
						<?php
							get_sidebar();
						?>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</main><!-- #main -->
<?php
get_footer();
