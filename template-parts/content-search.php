<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wisus
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('card h-100 mb-3'); ?>>
	<header class="entry-header card-header">
		<?php the_title( sprintf( '<h2 class="entry-title card-title fs-5"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php
			wisus_posted_on();
			wisus_posted_by();
			?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php wisus_post_thumbnail(); ?>

	<div class="entry-summary card-body">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<footer class="entry-footer card-footer d-flex justify-content-between">
		<?php wisus_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
