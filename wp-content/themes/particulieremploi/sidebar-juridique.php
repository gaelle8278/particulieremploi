<?php

/**
 * Barre latérale des pages et articles "juridique"
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */


    
//////////Offres/////////////////
$postCatSlugs=[];
if (is_single()) { 
    $postCategories = get_the_category();
    if (!empty($postCategories)) {
        foreach ($postCategories as $category) {
            $postCatSlugs[] = $category->slug;
        }
    }
}
//affichage du widget "Offres Les Essentiels" si article 
// n'est pas de la catégorie "Js suis salarié"
if(!in_array(SLUGCATSPE, $postCatSlugs)) {
    get_template_part('widget-offre-essentielle');
} else {
    get_template_part('widgets-partenaires');
}

///////////Infos Relais//////////////////////////
get_template_part('widget-relais');

//////////Bloc recherche/////////////////
get_template_part('widget-search');

//custom widget
if(is_active_sidebar( 'article-juridique-sidebar' )) {
    dynamic_sidebar('article-juridique-sidebar');
}