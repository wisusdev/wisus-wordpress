<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package wisus
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function wisus_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'wisus_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function wisus_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'wisus_pingback_header' );

/**
 * Theme options
 * @param WP_Customize_Manager $wp_customize
 */

 function wisus_config_theme($wp_customize) {

	// Add section for theme options
	$wp_customize->add_section('wisus_layout_options', array(
		'title'    => __('Theme Options', 'wisus'),
		'priority' => 30,
	));


	// Define bootstrap colors
	$colors = array(
		'primary'   => __('Primary', 'wisus'),
		'secondary' => __('Secondary', 'wisus'),
		'success'   => __('Success', 'wisus'),
		'danger'    => __('Danger', 'wisus'),
		'warning'   => __('Warning', 'wisus'),
		'info'      => __('Info', 'wisus'),
		'light'     => __('Light', 'wisus'),
		'dark'      => __('Dark', 'wisus'),
	);

	// Add section for theme options
	$wp_customize->add_setting('wisus_header_color', array(
		'default' => 'primary',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'refresh',	
	));

	// Add control for bootstrap color
	$wp_customize->add_control('wisus_header_color_control', array(
		'label'    => __('Header Color', 'wisus'),
		'section'  => 'wisus_layout_options',
		'settings' => 'wisus_header_color',
		'type'     => 'select',
		'choices'  => $colors,
	));

	// Add setting for footer color
	$wp_customize->add_setting('wisus_footer_color', array(
		'default' => 'dark',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'refresh',
	));

	// Add control for footer color
	$wp_customize->add_control('wisus_footer_color_control', array(
		'label'    => __('Footer Color', 'wisus'),
		'section'  => 'wisus_layout_options',
		'settings' => 'wisus_footer_color',
		'type'     => 'select',
		'choices'  => $colors,
	));


	// Add setting for column layout
	$wp_customize->add_setting('wisus_columns', array(
		'default' => '3',
		'sanitize_callback' => 'absint',
		'transport' => 'refresh',
	));

	// Add control for column layout
	$wp_customize->add_control('wisus_columns_control', array(
		'label'    => __('Column Blog Layout', 'wisus'),
		'section'  => 'wisus_layout_options',
		'settings' => 'wisus_columns',
		'type'     => 'number',
		'input_attrs' => array(
			'min'  => 1,
			'max'  => 12,
			'step' => 1,
		),
	));

	// Add color theme
	// Dark and light mode theme
	$wp_customize->add_setting('wisus_color_theme', array(
		'default' => 'light',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'refresh',
	));

	// Add control for color theme
	$wp_customize->add_control('wisus_color_theme_control', array(
		'label'    => __('Color Theme', 'wisus'),
		'section'  => 'wisus_layout_options',
		'settings' => 'wisus_color_theme',
		'type'     => 'select',
		'choices'  => array(
			'light' => __('Light', 'wisus'),
			'dark'  => __('Dark', 'wisus'),
		),
	));


	// Show title page
	$wp_customize->add_setting('wisus_show_title_page', array(
		'default' => 'yes',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'refresh',
	));

	// Add control for show title page
	$wp_customize->add_control('wisus_show_title_page_control', array(
		'label'    => __('Show Title Page', 'wisus'),
		'section'  => 'wisus_layout_options',
		'settings' => 'wisus_show_title_page',
		'type'     => 'select',
		'choices'  => array(
			'yes' => __('Yes', 'wisus'),
			'no'  => __('No', 'wisus'),
		),
	));

	// Enable sidebar
	$wp_customize->add_setting('wisus_enable_sidebar', array(
		'default' => 'yes',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'refresh',
	));

	// Add control for enable sidebar
	$wp_customize->add_control('wisus_enable_sidebar_control', array(
		'label'    => __('Enable Sidebar', 'wisus'),
		'section'  => 'wisus_layout_options',
		'settings' => 'wisus_enable_sidebar',
		'type'     => 'select',
		'choices'  => array(
			'yes' => __('Yes', 'wisus'),
			'no'  => __('No', 'wisus'),
		),
	));

}

add_action('customize_register', 'wisus_config_theme');

/**
 * Agrega theme options al menu de personalización
 */

 function wisus_add_theme_options_page() {
    add_theme_page(
        __('Theme Options', 'wisus'), // Título de la página
        __('Theme Options', 'wisus'), // Título del menú
        'edit_theme_options',         // Capacidad requerida
        'customize.php?autofocus[section]=wisus_layout_options' // URL del personalizador con la sección seleccionada
    );
}

add_action('admin_menu', 'wisus_add_theme_options_page');

// Se añade las clase para los botones de previo y siguiente en la pagination
add_filter('next_posts_link_attributes', 'posts_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_link_attributes');

function posts_link_attributes(): string {
	return 'class="btn btn-secondary"';
}

// Se añaden las clases para los botones que aparecen en cada post entes del formulario de comentario
function filter_single_post_pagination($output, $format, $link, $post){
	if ($post != ''){
		$title = get_the_title($post);
		$url   = get_permalink($post->ID);
		$class = 'btn btn-outline-primary my-2 text-limit btn-block';
		$rel   = 'prev';
		$arrow = ' &rarr;';

		$arrowWithSpace = $title . $arrow;

		if('next_post_link' === current_filter()){
			$rel   = 'next';
			$arrow = '&larr; ';
			$arrowWithSpace = $arrow . $title;
		}

		return "<a href='$url' rel='$rel' class='$class'>$arrowWithSpace</a>";
	}

	return null;
}
add_filter( 'next_post_link', 'filter_single_post_pagination', 10, 4);
add_filter( 'previous_post_link', 'filter_single_post_pagination', 10, 4);

function better_comments( $comment, $args, $depth ) {

	// Get correct tag used for the comments
	if ( 'div' === $args['style'] ) {
		$tag       = 'div';
		$add_below = 'comment';
	} else {
		$tag       = 'li';
		$add_below = 'div-comment';
	} 
	
	?>
	
	<<?php echo $tag; ?> <?php comment_class( empty( $args['has_children'] ) ? 'card mb-3 shadow' : 'parent card' ); ?> id="comment-<?php comment_ID() ?>">

	<?php
		// Switch between different comment types
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' : 
	?>
		<div class="pingback-entry"><span class="pingback-heading"><?php esc_html_e( 'Pingback:', 'textdomain' ); ?></span> <?php comment_author_link(); ?></div>
	<?php
		break;
		default :

		if ( 'div' != $args['style'] ) { ?>
			<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
		<?php } ?>
			<div class="comment-author vcard card-header d-flex justify-content-between">
				<div class="username-avatar">
					<?php
						// Display avatar unless size is set to 0
						if ( $args['avatar_size'] != 0 ) {
							$avatar_size = ! empty( $args['avatar_size'] ) ? $args['avatar_size'] : 70; // set default avatar size
							
							echo get_avatar( $comment, $avatar_size, '', '', array('class' => 'rounded me-3') );
						}
						// Display author name
						printf( __( '<cite class="author-link">%s</cite>', 'textdomain' ), get_comment_author_link() ); 
					?>
				</div>
				
				<div class="comment-meta commentmetadata">
					<a class="text-decoration-none" href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
						<?php
							/* translators: 1: date, 2: time */
							printf(
								__( '%1$s', 'textdomain' ),
								get_comment_date()
							); 
						?>
					</a>
				</div>

				<div class="btn-edit">
					<?php edit_comment_link( __( 'Editar', 'textdomain' ), '  ', '' ); ?>
				</div>
			</div><!-- .comment-author -->

			<div class="comment-details card-body">
				<div class="comment-text"><?php comment_text(); ?></div><!-- .comment-text -->
				<?php
					// Display comment moderation text
					if ( $comment->comment_approved == '0' ) { ?>
						<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'textdomain' ); ?></em><br/><?php
					} 
				?>
			</div>

			<div class="card-footer border-0">
				<div class="reply float-end">
					<?php
						// Display comment reply link
						comment_reply_link( array_merge( $args, array(
							'add_below' => $add_below,
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'class' 	=> 'btn btn-primary'
						))); 
					?>
				</div>
			</div>
	<?php
		if ( 'div' != $args['style'] ) { ?>
			</div>
		<?php }
	// IMPORTANT: Note that we do NOT close the opening tag, WordPress does this for us
		break;
	endswitch; // End comment_type check.
}