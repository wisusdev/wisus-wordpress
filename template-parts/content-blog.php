<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package lewer
 */

?>

<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header">
		<h1 class="page-title"><?php the_title( '<h1 class="entry-title fw-bold">', '</h1>' ); ?></h1>
	</header><!-- .page-header -->

	<div class="my-3">
		<?php wisus_post_thumbnail(); ?>
	</div>

	<p class="mb-5">
		<?php echo __('por') ?>
		<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author_meta('display_name') ?></a>
		<?php echo __('en') ?>
		<?php the_time(get_option('date_format')); ?>
		<?php
		$category_detail = get_the_category(get_post());
		foreach($category_detail as $cd){
			echo '<a class="px-1" href="' . esc_url( get_category_link( $cd->term_id ) ) .'">' . $cd->name . '</a>';
		} ?>
	</p>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'lewer' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>


</section><!-- .no-results -->
