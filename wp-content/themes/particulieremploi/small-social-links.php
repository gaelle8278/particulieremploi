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
    <div><a target="_blank" title="Envoyer par mail" href="mailto:?subject=<?php the_title(); ?>&body=<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri() ?>/images/pictos/btn-partage-mail.png" alt="logo partage mail"/></a></div>
</div>