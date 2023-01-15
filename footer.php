<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wisus
 */

?>

    <footer class="bg-black py-5">
        <div class="container d-flex flex-wrap justify-content-between align-items-center py-3">
            <div class="col-md-4 d-flex align-items-center">
                <span class="text-white fw-light text-small">Copyright © <?php echo date('Y') ?> · All rights reserved</span>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
