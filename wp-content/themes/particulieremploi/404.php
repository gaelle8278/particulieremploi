<?php
/* 
 * Page 404 personnalisée
 */

get_header();

?>
<section>
    <div class="content-central-column">
        <p>La page demandée n'existe pas</p>
        <div class="text-center"><a href="<?php echo esc_url(home_url()); ?>" title="Page d'accueil de particulieremploi.fr">Aller à la page d'accueil</a></div>
    </div>
</section>


<?php
get_template_part("logos-partenaires");
get_footer();