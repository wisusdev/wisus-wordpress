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

/**
 * Hooks
 *----------------------------------------------------------------------------------------------------
 */


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

function get_last_post($atts, $content = null) {
    global $post;

    // Extraer los atributos del shortcode
    $atts = shortcode_atts(array(
        'category' => '', // Nombre de la categoría o ID
        'num'      => '5', // Número de posts
        'order'    => 'DESC', // Orden (ASC o DESC)
        'orderby'  => 'post_date', // Campo para ordenar
    ), $atts);

    // Configurar los argumentos para la consulta
    $args = array(
        'posts_per_page' => $atts['num'], // Número de posts
        'order'          => $atts['order'], // Orden
        'orderby'        => $atts['orderby'], // Campo para ordenar
    );

    // Filtrar por categoría si se proporciona
    if (is_numeric($atts['category'])) {
        $args['cat'] = $atts['category']; // Filtrar por ID de categoría
    } elseif (!empty($atts['category'])) {
        $args['category_name'] = $atts['category']; // Filtrar por nombre de categoría
    }

    $output = '';

    // Obtener los posts
    $query = new WP_Query($args);

    ob_start();
	?>
	<div class="mb-3 col-md-12">
		<div class="row row-cols-1 row-cols-md-<?php echo esc_attr(get_theme_mod( 'wisus_columns', 3 )); ?> g-4">
			<?php
			if ($query->have_posts()):
				while ($query->have_posts()):
					$query->the_post();
					?>
					<div class="col">
						<?php get_template_part('template-parts/content', get_post_type()); ?>
					</div>
					<?php
				endwhile;
			else:
				get_template_part('template-parts/content', 'none');
			endif;
			wp_reset_postdata();
			?>
		</div>
		<?php if ($query->found_posts > $atts['num']) { ?>
			<div class="col-12 d-flex justify-content-center my-3">
				<a href="<?php echo esc_url(site_url('/blog')); ?>" class="btn btn-primary">
					Ver más entradas <i class="fas fa-arrow-circle-right ms-2"></i>
				</a>
			</div>
		<?php } ?>
	</div>
	<?php

	return ob_get_clean();
}