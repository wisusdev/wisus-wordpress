<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package lewer
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area py-5 px-3 bg-light rounded">
	<div class="">


		<?php
		// You can start editing here -- including this comment!
		if ( have_comments() ) :
			?>
			<h2 class="comments-title fs-4 mb-3 py-3 bg-secondary text-white text-center rounded">
				<?php
					$lewer_comment_count = get_comments_number();
					if ( '1' === $lewer_comment_count ) {
						printf(
						/* translators: 1: title. */
							esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'lewer' ),
							'<span>' . wp_kses_post( get_the_title() ) . '</span>'
						);
					} else {
						printf(
						/* translators: 1: comment count number, 2: title. */
							esc_html( _nx( '%1$s comentarios en &ldquo;%2$s&rdquo;', '%1$s comentarios en &ldquo;%2$s&rdquo;', $lewer_comment_count, 'comments title', 'lewer' ) ),
							number_format_i18n( $lewer_comment_count ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							'<span>' . wp_kses_post( get_the_title() ) . '</span>'
						);
					}
				?>
			</h2><!-- .comments-title -->

			<?php the_comments_navigation(); ?>
			
			<div class="comment-list comments mb-3">
				<?php
					wp_list_comments( array(
						'style'			=> 'div',
						'short_ping'	=> true,
						'callback'	=> 'better_comments'
					) );
				?>
			</div>

			<?php the_comments_navigation();  ?>
			
			<?php
			// If comments are closed and there are comments, let's leave a little note, shall we?
			if ( ! comments_open() ) :
				?>
				<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'lewer' ); ?></p>
			<?php
			endif;

		endif; // Check for have_comments().

		// Argumentos para diseño de formulario de comentarios
		$comment_args = array(
			'class_submit' => 'btn btn-primary submit',

			'comment_field' => '<p class="comment-form-comment"><label for="comment" class="form-label">' . _x( 'Comment', 'noun' ) . '</label> <textarea id="comment" name="comment" class="form-control" cols="45" rows="4" aria-required="true" required="required"></textarea></p>',
			
			'fields' => array(
				'author' => '<p class="comment-form-author">' . '<label for="author" class="form-label">' . __( 'Name' ) . '</label> ' .
					'<input id="author" name="author" class="form-control" type="text" size="30"/></p>',
				'email'  => '<p class="comment-form-email"><label for="email" class="form-label">' . __( 'Email' ) . '</label> ' .
					'<input id="email" name="email" class="form-control" value="" size="30" aria-describedby="email-notes"/></p>',
				'url'    => '<p class="comment-form-url"><label for="url" class="form-label">' . __( 'Website' ) . '</label> ' .
					'<input id="url" name="url" class="form-control"  value="" size="30" /></p>',
			)
		);

		comment_form($comment_args);

		?>
	</div>
</div><!-- #comments -->
