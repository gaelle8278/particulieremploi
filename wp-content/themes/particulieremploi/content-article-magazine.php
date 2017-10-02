<?php
/**
 * Template pour l'affichage d'un article "magazine".
 *
 * Les articles magazines sont les articles présents dans le magazine.
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
    <?php  get_template_part('article-more-content'); ?>
    
</article><!-- @white-space
--><aside>
    <?php
        get_sidebar();
    ?>
</aside>

