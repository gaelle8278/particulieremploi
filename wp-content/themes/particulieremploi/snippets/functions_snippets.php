<?php

/**
 * Fichier contenant des snippets potentiellement utiles
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

// guillemets dans les posts
remove_filter('the_content', 'wptexturize');

/**
 * 
 * récupération des slugs des catégories régions
 * 
 * @param type $postID
 */
function get_child_regional_categories ($postID) {
    $listCatReg=array();
    //récupération des catégories de l'article
    $all_category = get_the_category($postID);
    foreach ($all_category as $cat) {
        //si la catégorie est une catégorie fille
        if ($cat->category_parent == true) {
            //récupération des slugs des catégories parentes (true en 4ème param)
            $catParents = get_category_parents($cat->cat_ID, false, '/', true);
            $tabCatParents = explode('/', $catParents);
            //test si parmis les catégories parentes il a la catégorie "article régional"
            if (in_array('article-regional', $tabCatParents)) {
                //si c'est le cas récupération de la catégorie
                $listCatReg[]= $cat->category_nicename;
                $listCatReg[]= $cat->cat_name;
            }
        }
    }
    return $listCatReg;
}
/** exemple d'utilisation
*
    $postCatReg = get_child_regional_categories($post->ID);
    foreach ($postCatReg as $catReg) {
        echo $catReg;
        $cat=get_category_by_slug($catReg);
        $tabIdCat[]=$cat->cat_ID;
    }
    //puis faire une wp_query en utilisant category__in ou category__not_in
*/



/**
 * Fonction pour charger le javascript nécessaire à 
 * la gestion d'un champs d'upload d'image dans une metabox en back-office
 */
function pe_image_enqueue() {
    global $typenow;
    if( $typenow == 'relais' ) {
        wp_enqueue_media();
 
        // Registers and enqueues the required javascript.
        wp_register_script( 'meta-box-image', get_template_directory_uri() . '/js/admin/meta-box-image.js', array( 'jquery' ) );
        wp_localize_script( 'meta-box-image', 'meta_image',
            array(
                'title' =>  'Sélectionnez votre image',
                'button' => 'Utiliser cette image',
            )
        );
        wp_enqueue_script( 'meta-box-image' );
    }
}
add_action( 'admin_enqueue_scripts', 'pe_image_enqueue' );
