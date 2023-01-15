<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wisus
 */

?>

<!-- content page -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header header-title-page">
		<?php the_title( '<h1 class="entry-title content-page">', '</h1>' ); ?>
	</header>

	<?php wisus_post_thumbnail(); ?>

	<div class="entry-content content-page">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wisus' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
