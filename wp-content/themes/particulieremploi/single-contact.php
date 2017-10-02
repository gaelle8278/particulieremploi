<?php

/**
 *
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
get_header();
?>
<section>
    <?php
    // Start the loop.
    while (have_posts()) : the_post();
        the_content();
        if ( has_post_thumbnail() ) {
            the_post_thumbnail('avatar');
        }
        echo get_post_meta( $post->ID, 'contact-post-name', true );
        

    endwhile;

    
    ?>

</section>
<?php
get_template_part("logos-partenaires");
get_footer();