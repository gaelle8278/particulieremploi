<?php

/**
 * Template Name: Juridique
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
get_header();

    // pour que la pagination des articles fonctionne sur une page statique
    global $paged;
    //pour faire fonctionner la pagination
    if ( get_query_var( 'paged' ) ) { 
         $paged = get_query_var( 'paged' ); 

    }
    elseif ( get_query_var( 'page' ) ) {
        $paged = get_query_var( 'page' ); 

    }
    else { 
        $paged = 1; 

    }


    $args = array(
        'post_type' => 'post',
        'ignore_sticky_posts' => 1,
        'meta_key' => 'metabox_field_post_template',
        'meta_value' => 'article-juridique',
        'posts_per_page' => 10,
        'paged' => $paged,
        'orderby' => 'date',
        'order' => 'DESC',

    );

    // 2. on exécute la query
    $my_query = new WP_Query($args);

    // 3. on lance la boucle !
    if($my_query->have_posts()) : 
        while ($my_query->have_posts() ) : $my_query->the_post();
            the_title();
            the_content();
        endwhile;
        // Previous/next page navigation.

    //echo $my_query->max_num_pages;

    next_posts_link( 'Older Entries »', $my_query->max_num_pages);
    previous_posts_link( 'Newer Entries' );

    endif;


    // 4. On réinitialise à la requête principale (important)
    wp_reset_postdata();

get_template_part("logos-partenaires");
get_footer();