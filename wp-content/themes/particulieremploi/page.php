<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
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
        //page content
        while (have_posts()) :
            the_post();
            the_content();
            endwhile; 
        ?>
        <div class="wrap-clear"></div>
    </section>
    
</div>
<?php
get_template_part("logos-partenaires");
get_footer();

