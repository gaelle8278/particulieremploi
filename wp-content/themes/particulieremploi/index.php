<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

get_header();
?>
<div class="content-central-column">
    <section>
        <?php
        while (have_posts()) :
            the_post();
            the_content();
        endwhile; 

        ?>
    </section>
</div>
<?php

get_footer();


