<article id="post-<?php the_ID(); ?>" <?php post_class(is_singular() && !is_front_page() ? '' : 'card h-100 mb-3'); ?>>

    <header class="entry-header <?php echo is_singular() && !is_front_page() ? '' : 'card-header'; ?>">
        <?php
        if ( is_singular() && !is_front_page() ) :
            the_title( '<h1 class="entry-title">', '</h1>' );
        else :
            the_title( '<h2 class="entry-title card-title fs-5"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        endif;

        if ( 'post' === get_post_type() ) :
            ?>
            <div class="entry-meta">
                <?php
                    wisus_posted_on();
                    wisus_posted_by();
                ?>
            </div><!-- .entry-meta -->
        <?php endif; ?>
    </header><!-- .entry-header -->

    <?php wisus_post_thumbnail(); ?>

    <div class="entry-content <?php echo is_singular() && !is_front_page() ? '' : 'card-body'; ?>">
        <?php
        if(is_singular() && !is_front_page()) {
            the_content(
                sprintf(
                    wp_kses(
                        /* translators: %s: Name of current post. Only visible to screen readers */
                        __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'wisus' ),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post( get_the_title() )
                )
            );
        } else {
            echo '<p>' . wp_trim_words(get_the_content(), 60, '...') . '</p>';
        }

        wp_link_pages(
            array(
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wisus' ),
                'after'  => '</div>',
            )
        );
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer <?php echo is_singular() && !is_front_page() ? '' : 'card-footer d-flex justify-content-between'; ?>">
        <?php wisus_entry_footer(); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->