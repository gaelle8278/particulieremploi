<?php
/**
 * File to manage inclusion of a sidebar
 */
$post_id=get_the_ID();
$sidebar=get_post_meta( $post_id, 'custom_sidebar', true );

if($sidebar && $sidebar != "default") {
    //si une sidebar perso est sélectionnée on l'utlise
    dynamic_sidebar($sidebar);
} else {
    //sinon gestion de l'affichage d'une sidebar par défaut
    if( is_single() ) {
        //si c'est un article inclusion de la sidebar en fonction du layout
        $layout=get_post_meta( $post_id, 'metabox_field_post_template', true );

        //pour les articles de layout juridique distinction entre les articles de catégorie pe et spe
        if($layout=="article-juridique") {
            $postCatSlugs=array();
            $postCategories = get_the_category($post_id);
            if (!empty($postCategories)) {
                foreach ($postCategories as $category) {
                    $postCatSlugs[] = $category->slug;
                }
            }
            if(in_array(SLUGCATSPE, $postCatSlugs)) {
                $sidebar='article-juridique-spe-sidebar';
            } else {
                $sidebar='article-juridique-sidebar';
            }
        } else {
            $sidebar=$layout."-sidebar";
        }

        if( is_active_sidebar($sidebar) ) {
            dynamic_sidebar($sidebar);
        }

    } elseif ( is_category() ) {
        //si c'est une page category
        if( is_active_sidebar('category-sidebar') ) {
            dynamic_sidebar('category-sidebar');
        } elseif ( is_active_sidebar('article-magazine-sidebar') ) {
            dynamic_sidebar('article-magazine-sidebar');
        }
    } elseif ( is_page_template('page-templates/magazine-template.php') ||
       is_page_template('page-templates/cesu-10-points.php') ||
       is_page_template('page-templates/simulateur-cesu.php') ||
       is_page_template('page-templates/volet-cesu.php')
        ) {
        //page template magazine, cesu et simulateur
        if ( is_active_sidebar('article-magazine-sidebar') ) {
            dynamic_sidebar('article-magazine-sidebar');
        }
    } elseif ( is_page_template('page-templates/juridique-template.php') ) {
        //page template juridique
        if ( is_active_sidebar('article-juridique-sidebar') ) {
            dynamic_sidebar('article-juridique-sidebar');
        }
    }

}


