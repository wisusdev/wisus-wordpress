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

<?php 
	$navbarColor = get_theme_mod('wisus_header_color', 'primary'); 
	$themeMode = get_theme_mod('wisus_color_theme', 'light');
    $containerFluidEnabled = get_theme_mod( 'wisus_container_fluid');
?>

<!doctype html>
<html <?php language_attributes(); ?> data-bs-theme="<?php echo esc_attr($themeMode); ?>">

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'wisus'); ?></a>
		<nav class="navbar navbar-expand-lg bg-<?php echo esc_attr($navbarColor); ?>" id="masthead">
			<div class="container<?php echo $containerFluidEnabled ? '-fluid' : ''; ?>">

				<div class="custom-logo-container">
					<?php the_custom_logo(['class' => 'img-fluid']); ?>
				</div>

				<?php $wisus_description = get_bloginfo('description', 'display'); ?>
				<?php $wisus_blog_name = get_bloginfo('name', 'display'); ?>

				<?php if (display_header_text()) : ?>
					<a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>" rel="home" <?php if (is_customize_preview()) : ?>data-customize-partial-id="blogname"<?php endif; ?>>
						<?php if ($wisus_blog_name) : ?>
							<?php echo esc_html($wisus_blog_name); ?>
						<?php endif; ?>
						<?php if ($wisus_description) : ?>
							<small class="small fw-light fs-6 text-body-secondary" <?php if (is_customize_preview()) : ?>data-customize-partial-id="blogdescription"<?php endif; ?>>
								<?php echo esc_html($wisus_description); ?>
							</small>
						<?php endif; ?>
					</a>
				<?php endif; ?>

				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="main-menu">
					<?php
					wp_nav_menu(array(
						'theme_location' => 'main-menu',
						'container' => false,
						'menu_class' => '',
						'fallback_cb' => '__return_false',
						'items_wrap' => '<ul id="%1$s" class="navbar-nav me-auto mb-2 mb-md-0 %2$s">%3$s</ul>',
						'depth' => 2,
						'walker' => new bootstrap_5_wp_nav_menu_walker()
					));
					?>
				</div>
			</div>
		</nav><!-- #site-navigation -->