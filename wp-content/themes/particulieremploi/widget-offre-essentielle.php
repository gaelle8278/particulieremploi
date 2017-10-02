<?php

/**
 * Widget d'offre essentielle de la FEPEM
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

$textlien= "Découvrez nos formules d'accompagnement";
if (is_single()) {
    //si on des dans les articles des pages Je suis particulier employeur
    // le wording du lien comprend le prix sinon non
    $postCategories = get_the_category();
    if (!empty($postCategories)) {
        foreach ($postCategories as $category) {
            $postCatSlugs[] = $category->slug;
        }
        if(in_array(SLUGCATPE, $postCatSlugs)) {
            $textlien= "Découvrez nos formules d'accompagnement à partir de 12 €";
        }
    }

    //dépendance de certains articles avec le contenu latéral
    //le titre du call to action pour l'abonnement change en fonction de l'article
    //récupération de ce champs
    $post_template = get_post_custom();
    if (isset($post_template['metabox_field_post_wording'])) {
        $calltoaction_wording=$post_template['metabox_field_post_wording'][0];
    }
} 
?>
<div class="sidebar-widget-article">
    <div>
        <div class='sidebar-title'>
            <?php
            if(isset($calltoaction_wording) && !empty($calltoaction_wording)) {
                echo $calltoaction_wording;
            }
            else {
                echo "Vous souhaitez être aidé dans vos démarches ?";
            }
           ?>
        </div>
    
        <div class='title-separator'></div>
        <p>La Fédération des Particuliers Employeurs de France (FEPEM) vous 
            accompagne et vous simplifie votre rôle de particulier employeur.</p>
    </div>

    <a class="bloc-offre-link" href="<?php echo get_permalink( ID_PAGEESSENTIEL ) ; ?>">
        <?php echo $textlien; ?></a>
</div>
