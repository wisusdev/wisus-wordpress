<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wisus
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-57ZXY337Z6"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-57ZXY337Z6');
	</script>
	
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<div id="page" class="site">
	<header class="border-bottom">
		<nav id="header" class="navbar navbar-expand-md bg-white">
			<div class="container">
				<div class="navbar-brand">
					<?php

					the_custom_logo(['class' => 'img-fluid']);

					if ( is_front_page() && is_home() ) :
					?>
						<h1 class="site-title">
							<a href="<?php echo home_url() ?>" class="text-decoration-none text-black"><?php bloginfo( 'name' ); ?></a>
						</h1>
					<?php
					else :
					?>
						<p class="site-title navbar-brand m-0 fw-bold">
							<a href="<?php echo home_url() ?>" class="text-decoration-none text-black"><?php bloginfo( 'name' ); ?></a>
						</p>
					<?php
					endif;
					$wisus_description = get_bloginfo( 'description', 'display' );
					if ( $wisus_description || is_customize_preview() ) :
						?>
						<p class="site-description"><?php echo $wisus_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
					<?php endif; ?>
				</div>

				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'surti' ); ?>">
					<i class="fas fa-bars"></i>
				</button>

				<div id="navbar" class="collapse navbar-collapse">
					<ul class="navbar-nav me-auto">

					</ul>
					<ul class="navbar-nav mb-2 mb-lg-0 ms-auto">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
								'menu_class'     => 'navbar-nav mb-2 mb-lg-0 ms-auto',
								'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
								'walker'         => new WP_Bootstrap_Navwalker(),
							)
						);
						?>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container -->
		</nav><!-- /#header -->
	</header>
