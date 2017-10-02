<?php

/**
 * Template d'affichage des articles
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

//enregistrement et récupération du cp de l'internaute
set_user_depcode();
$depCode=get_user_depcode();
get_header();
include(locate_template('plugin-form-cp.php'));
?>
<div class="content-central-column">
    <section>
        <?php
        // Start the loop.
        while (have_posts()) : the_post();
            if(function_exists('fil_ariane')) { echo fil_ariane(); }
        
            $post_template = get_post_custom();
            if (isset($post_template['metabox_field_post_template'])) {
                include(locate_template("content-".$post_template['metabox_field_post_template'][0].".php"));
                //get_template_part('content', $post_template['metabox_field_post_template'][0]);
            } else {
                get_template_part('content-article-standard', get_post_format());
            }
            
        endwhile;
    ?>    
    </section>
</div>
<?php
get_template_part("logos-partenaires");
get_footer();

