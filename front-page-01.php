<?php get_header() ?>

	<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
	?>

	<div class="bg-light-gray py-5">
		<div class="container">

			<h2 class="alt-font font-weight-600 fw-bold text-black pb-5">
				<span class="text-white bg-black p-2 rounded shadow">ÚLTIMOS POSTS</span>
			</h2>

			<div class="row">
				<?php
					$args = array(
						'post_type' => 'post',
						'posts_per_page' => 3
					);

					// Consulta personalizada
					$blog = new WP_Query($args);

					while($blog->have_posts()): $blog->the_post();
						get_template_part('template-parts/content');
					endwhile; wp_reset_postdata();
				?>
			</div>

			<?php if ($blog->found_posts > 4): ?>
				<div class="col-12 d-flex justify-content-center mt-3">
					<a href="<?php echo esc_url(site_url('/blog')); ?>" class="btn btn-primary">Ver mas entradas <i class="fas fa-arrow-circle-right ms-2"></i></a>
				</div>
			<?php endif; ?>
		</div>
	</div>


<?php get_footer() ?>
