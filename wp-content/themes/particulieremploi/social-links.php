<?php

/**
 *
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
?>

<div class="article-social-links">
   
    <div>Partager :   </div>
    <div>
        <a target="_blank" title="Facebook" 
                href="https://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&t=<?php the_title(); ?>" 
                rel="nofollow" 
                onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=500,width=700');return false;">
            <img src="<?php echo get_template_directory_uri() ?>/images/pictos/btn-partage-facebook.png" alt="logo partage facebook"/>                 
        </a>
    </div>
    <div>
        <a target="_blank" title="Twitter" 
            href="https://twitter.com/share?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" 
            rel="nofollow" 
            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=700');return false;">
           <img src="<?php echo get_template_directory_uri() ?>/images/pictos/btn-partage-twitter.png" alt="logo partage twitter"/>
        </a>
    </div>
    <div>
        <a target="_blank" title="Envoyer par mail" href="mailto:?subject=<?php the_title(); ?>&body=<?php the_permalink(); ?>" rel="nofollow">
            <img src="<?php echo get_template_directory_uri() ?>/images/pictos/btn-partage-mail.png" alt="logo partage mail"/>
       </a>
    </div>
</div>