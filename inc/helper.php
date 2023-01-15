<?php

/**
 * En este archivo se manejan funciones y se usan hooks,
 * cada uno tiene una descripcion de lo que hace
*/

/* Tabla de contenido

	- Funciones
	- Hooks

*/

/**
 * Funciones
 *----------------------------------------------------------------------------------------------------
*/

/* Paginacion con bootstrap 5 */
function bt_lewer_pagination( \WP_Query $wp_query = null, $echo = true, $params = [] ) {
	if ( null === $wp_query ) {
		global $wp_query;
	}

	$add_args = [];

	$pages = paginate_links( array_merge( [
			'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
			'format'       => '?paged=%#%',
			'current'      => max( 1, get_query_var( 'paged' ) ),
			'total'        => $wp_query->max_num_pages,
			'type'         => 'array',
			'show_all'     => false,
			'end_size'     => 3,
			'mid_size'     => 1,
			'prev_next'    => true,
			'prev_text'    => __( 'Back' ),
			'next_text'    => __( 'Next' ),
			'add_args'     => $add_args,
			'add_fragment' => ''
		], $params )
	);

	if ( is_array( $pages ) ) {

		$pagination = '<nav aria-label="Page navigation"><ul class="pagination mb-0">';

		foreach ( $pages as $page ) {
			$pagination .= '<li class="page-item' . (strpos($page, 'current') !== false ? ' active' : '') . '"> ' . str_replace('page-numbers', 'page-link', $page) . '</li>';
		}

		$pagination .= '</ul></nav>';

		if ( $echo ) {
			echo $pagination;
		} else {
			return $pagination;
		}
	}

	return null;
}

/**
 * Esta funcion sirve para crear una paginaciòn simple
 * EL diseño del boton habilitado se añade en #posts_link_attributes
 */
function lw_pagination(){
	global $wp_query;

	$total_pages = $wp_query->max_num_pages;
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

	$prev = $paged == 1 ? '<span class="btn btn-outline-dark disabled">' . __( 'Previous' ) . '</span>' : get_previous_posts_link(  __( 'Previous' ) );
	$nPage = '<span class="px-3">' . $paged . ' ' . __('of') . ' ' . $total_pages . '</span>';
	$next = $paged == $total_pages ? '<span class="btn btn-outline-dark disabled">' . __( 'Next' ) . '</span>' : get_next_posts_link( __( 'Next' ) );

	echo '<div>'. $prev . $nPage . $next . '</div>';
}

/*
 * Establece un contador de vistas en la entrada usando la meta del post
 */
function setPostViews($postID) {
	$countKey = 'post_views_count';
	$count = get_post_meta($postID, $countKey, true);
	if($count==''){
		$count = 0;
		delete_post_meta($postID, $countKey);
		add_post_meta($postID, $countKey, '0');
	}else{
		$count++;
		update_post_meta($postID, $countKey, $count);
	}
}

// Funcion que obtiene los post por una determinada categoria
function popular_post() {
	$args = array(
		'post_type'			=> 'post' ,
		'orderby' 			=> 'date' ,
		'order' 			=> 'DESC' ,
		'posts_per_page' 	=> 4,
		'category_name'		=> 'depression',
	);

	$popular_posts = new WP_Query( $args );

	while( $popular_posts->have_posts() ):
		$popular_posts->the_post();

		?>
		<div class="col-md-3 mb-3">
			<div class="card h-100">
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('largest', array('class' => 'img-fluid')); ?></a>
				<div class="card-body">
					<?php
						$category_detail = get_the_category(get_post());
						foreach($category_detail as $cd){
							echo '<a class="pe-1 text-black text-decoration-none" href="' . esc_url( get_category_link( $cd->term_id ) ) .'">' . $cd->name . '</a>';
						}
					?>
					<p class="fw-bolder fs-6 mt-2">
						<a href="<?php the_permalink(); ?>" class="text-black text-decoration-none"><?php the_title() ?></a>
					</p>
				</div>
			</div>
		</div>
	<?php
	endwhile;

	wp_reset_postdata();
}

function get_popular_post(){

	$args = array(
        'meta_key' => 'post_views_count',
        'orderby' => 'meta_value_num',
		'order' 			=> 'DESC' ,
		'posts_per_page' 	=> 4,
	);

	query_posts($args);

	if (have_posts()) : while (have_posts()) : the_post();
		?>
		<div class="col-md-3 mb-3">
			<div class="card h-100">
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('largest', array('class' => 'img-fluid')); ?></a>
				<div class="card-body">
					<?php
					$category_detail = get_the_category(get_post());
					foreach($category_detail as $cd){
						echo '<a class="pe-1 text-black text-decoration-none" href="' . esc_url( get_category_link( $cd->term_id ) ) .'">' . $cd->name . '</a>';
					}
					?>
					<p class="fw-bolder fs-6 mt-2">
						<a href="<?php the_permalink(); ?>" class="text-black text-decoration-none"><?php the_title() ?></a>
					</p>
				</div>
			</div>
		</div>
	<?php
	endwhile; endif;
	wp_reset_query();
}

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

			<div class="card-footer bg-white border-0">
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

/**
 * Hooks
 *----------------------------------------------------------------------------------------------------
 */

// Se habilita el editor clasico de wordpress //
//add_filter('use_block_editor_for_post', '__return_false');

// Se añade las clase para los botones de previo y siguiente en la paginacion
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
		$class = 'btn btn-outline-secondary my-2 text-limit btn-block';
		$rel   = 'prev';

		if('next_post_link' === current_filter()){
			$rel   = 'next';
		}
		return "<a href='$url' rel='$rel' class='$class'>$title</a>";
	}

	return null;
}
add_filter( 'next_post_link', 'filter_single_post_pagination', 10, 4);
add_filter( 'previous_post_link', 'filter_single_post_pagination', 10, 4);


// Se eliminan los p (parrafos) vacios
//remove_filter('the_content', 'wpautop');
//remove_filter('the_excerpt', 'wpautop' );

// Añadir clase a logo
add_filter( 'get_custom_logo', 'change_logo_class' );
function change_logo_class( $html ) {
	$html = str_replace( 'custom-logo', 'logo-navbar', $html );
	return $html;
}

/* SHORTCODE */
add_shortcode('getLastPost', 'get_last_post');
function get_last_post($atts, $content = null){

    global $post;

    extract(shortcode_atts(array(
        'cat'     => '',
        'num'     => '5',
        'order'   => 'DESC',
        'orderby' => 'post_date',
    ), $atts));

    $args = array(
        'cat'            => $cat,
        'posts_per_page' => $num,
        'order'          => $order,
        'orderby'        => $orderby,
    );

    $output = '';

    $posts = get_posts($args);

    foreach($posts as $post) {

        setup_postdata($post);

		$output .= '
			<div class="col-md-4 mb-3">
				<div class="card h-100 shadow ">
					<div class="card-header">
						<p class="text-capitalize m-1 fw-bold">' . get_the_date( get_option('date_format')) . '</p>
					</div>
	
					<div class="overflow-hidden p-0 image-post">
						<div class="post-thumbnail">
							<a href="'. get_the_permalink() .'">
								'. get_the_post_thumbnail(null, '', array('class' => 'img-fluid')) .'
							</a>
						</div>
					</div>
	
					<div class="card-body">
						<p class="entry-title card-title fw-bold"><a href="'. get_the_permalink() .'" rel="bookmark" class="text-decoration-none text-black">'. get_the_title() .'</a></p>
						<!-- Post content -->
						<p class="my-3 fw-normal">' . wp_trim_words( get_the_content(), 20 ) . '</p>
					</div>
				</div>
			</div>
		';
    }

	if ($posts > $num){
		$output .= '
			<div class="col-12 d-flex justify-content-center my-3">
					<a href="' .esc_url(site_url('/blog')) .'" class="btn btn-primary">Ver mas entradas <i class="fas fa-arrow-circle-right ms-2"></i></a>
			</div>';
	}

    wp_reset_postdata();

    return '<div class="row">' . $output . '</div>';
}