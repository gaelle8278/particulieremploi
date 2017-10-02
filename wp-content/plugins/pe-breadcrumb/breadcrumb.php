<?php

/**
 * Plugin Name: ParticulierEmploi Breadcrumb
 * Description: Fil d'ariane pour les pages et les articles de Particulier Emploi
 * Version: 1.0
 *
 */

function fil_ariane () {
    global $post;
    
    /*$parents=get_ancestors($post->ID,'page');
    echo "<pre>"; print_r( $parents);echo "</pre>";*/
    
    if (!is_home()) {
        $fil  = '<div class="breadcrumb"><a href="'.get_bloginfo('wpurl').'">';
        $fil .= "<img src='".plugin_dir_url( __FILE__ )."img/home.png' />";
        $fil .= "</a> > ";
        
        /*$parents = array_reverse(get_ancestors($post->ID,'page'));
        foreach ($parents as $parent) {
            $fil .= '<a href="'.get_permalink($parent).'">';
            $fil .= get_the_title($parent);
            $fil .= '</a> > ';
        }*/
        $category = get_the_category();
        $fil .= '<a href="'.get_category_link($category[0]->cat_ID).'">'.ucfirst($category[0]->cat_name).'</a> > ';
        $fil .= $post->post_title;
        $fil .= "</div>";
    }
    return $fil;
}