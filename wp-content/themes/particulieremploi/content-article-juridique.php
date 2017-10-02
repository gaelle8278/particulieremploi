<?php
/**
 * Template pour l'affichage d'un article "juridique".
 *
 * Les articles juridiques sont les articles des sections "Jes suis particulier employeur" et "Je suis salarié"
 * 
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

?>
<article>
    <div class="article-toolbar">
        <?php 
        get_template_part('article-features-bar');
        get_template_part('social-links'); 
        ?>
    </div>
    <div class="wrap-clear"></div>
    <h1><?php the_title(); ?> </h1>
    <?php
    if ( has_post_thumbnail() ) {
        the_post_thumbnail('post-thumbnail', array('class' => 'main-img-article'));
    }
    ?>
    <div class="article-excerpt">    
        <?php the_excerpt(); ?>
    </div>
    <div class="section-title-separator"></div>
    <?php
    the_content();
    ?>
    <div class="article-toolbar">
        <div class='article-date'><?php echo ucfirst(get_the_date('F Y')); ?></div>
        <?php get_template_part('social-links');?>
    </div>
    <div class="wrap-clear"></div>
    <div class="bloc-author">
        <?php echo get_avatar( get_the_author_id() , 80 ); ?>
        <div class="author-infos">
            <p>Publié par <span class="text-bold"><?php the_author(); ?></span></p>
            <p><?php the_author_description(); ?></p>
        </div>
    </div>
    <div class="wrap-clear"></div>
    <?php  get_template_part('article-more-content'); ?>
</article><!-- @white-space
--><aside>
   
    <?php
        get_sidebar();
        //get_template_part("sidebar-juridique");
    
    ?>
</aside>
