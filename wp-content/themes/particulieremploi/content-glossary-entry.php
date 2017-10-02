<?php

/**
 * Afiichage du contenu des catégories faisant parties du glossaire
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
?>
<section>
    <div class="breadcrumb">
        <a href="<?php echo get_bloginfo('wpurl'); ?>">
            <img src="<?php echo get_template_directory_uri() ?>/images/pictos/home.png" />
        </a>
         > Glossaire
    </div>
    
    <div class="bloc-page-glossaire">
        <div class="bloc-page-wrap">
        <h1>Glossaire </h1>
        <?php
            wp_nav_menu( array(
                    'theme_location' => 'nav_glossaire',
                    'menu_class' => 'nav-glossaire'
            ));
        ?>
        <div class="wrap-clear"></div>
        <?php
        
        while (have_posts()) {
            the_post();
            ?>
            <div class="glossary-entry">
                <h2><?php the_title(); ?></h2>
                <?php the_content(); ?>
            </div>
            <?php
        }
        //pagination
        base_pagination();
        ?>
        </div>
    </div>
</section>
        