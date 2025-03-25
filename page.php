<?php
get_header();
?>

<?php
    $sidebarEnabled = get_theme_mod( 'wisus_enable_sidebar');
    $containerFluidEnabled = get_theme_mod( 'wisus_container_fluid');
?>
<div class="d-flex flex-column">
    <main id="primary" class="page-main flex-grow-1 py-4 container<?php echo $containerFluidEnabled ? '-fluid' : ''; ?>">
        <div class="row">
            <div class="mb-3 <?php echo $sidebarEnabled ? 'col-md-8' : 'col-md-12'; ?>">
				<?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', 'page' );

					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile;
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
    </main>
</div>

<?php get_footer(); ?>