<?php

/**
 * Template Name: Magazine
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
get_header();

//geoloc : dépend du plugin GeoIP Detection
$depCode=geolocalisation();
//$tabRegion is defined in usefull_constants.php
if(!empty($depCode)) {
    $region=get_region_from_geocode($depCode);
}
$slugReg='cat-'.$region;
$catReg=get_category_by_slug($slugReg);

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
    //'meta_key' => 'metabox_field_post_template',
    //'meta_value' => 'article-magazine',
    //filtrage des catégories pour la géoloc :
    //article régional => article de la région concernée
    //et autres articles non régionaux
    'tax_query' => array(
                    'relation' => 'OR',
                    array(
                            'taxonomy' => 'category',
                            'field'    => 'slug',
                            'terms'    => array( $slugReg ),
                    ),
                    array(
                            'taxonomy' => 'category',
                            'field'    => 'slug',
                            'terms'    => array( SLUGCATREG, SLUGCATPE, SLUGCATSPE, SLUGCATGLOSS),
                            'operator' => 'NOT IN',
                    )
                
            ),
    'posts_per_page' => POSTPERPAGE,
    'paged' => $paged,
);
$my_query = new WP_Query($args);
?>

<div class="content-central-column">
    <?php
    wp_nav_menu(array('theme_location' => 'nav_categories', 'container' => 'nav', 'container_class'=>'category_menu'));
    ?>
    <section>
        <?php
        $nb_articles=0;
        $nb_inside_articles=1;
        $pas_bloc=1;
        $page_limit=$my_query->post_count-1;
        if($my_query->have_posts()) : 
            while ($my_query->have_posts() ) : $my_query->the_post();
        
                /* ajout filtrage des articles régionaux*/
                /*$regionalCat=get_child_regional_categories($post->ID);
                if(!empty($regionalCat) && !in_array($slugReg, $regionalCat)) {
                    //echo "toto";
                    continue;
                }*/
                ///
                if($nb_articles==0) {
                    ?>
                    <div class="bloc-ensemble-article bloc-ensemble-gauche">
                    <?php
                    $inside_class="large-article";
                    $pas_bloc++;
                } else if($nb_articles%3==0) {
                    $inside_class="large-article";
                    if($pas_bloc%2==0) {
                        $class="bloc-ensemble-droit";
                    } else {
                        $class="bloc-ensemble-gauche";
                    }
                    ?>
                    </div>
                    <div class="bloc-ensemble-article <?php echo $class ?>">
                    <?php
                    $pas_bloc++;
                } else {
                    $inside_class="normal-article";
                    if($nb_inside_articles%2!=0) {
                        $inside_class.=" first-inside-article";
                    }
                    $nb_inside_articles++;
                }
                ?>
        
                <div class="bloc-article <?php echo $inside_class; ?>">
                    <div class="bloc-article-img">
                        <?php
                        if ( has_post_thumbnail() ) {
                            the_post_thumbnail('article-list-mag');
                        } else {
                            ?>
                            <img src="<?php echo get_template_directory_uri() ?>/images/list-article-img-mock.jpg" alt="image de l'article"/>
                            <?php
                        }
                        ?>
                    </div>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="bloc-article-content">                
                        <div class="bloc-article-content-wrap">
                            <?php
                            $postCatName=[];
                            $postCategories = get_the_category();
                            if (!empty($postCategories)) {
                                foreach ($postCategories as $category) {
                                            $postCatName[] = $category->name;
                                }
                                ?>
                                <div class="list-post-cat"><?php echo implode(', ', $postCatName) ?></div>
                                <?php
                            }
                            //echo "article n°".$nb_articles;
                            ?>
                            <div class="list-post-title"><?php the_title(); ?></div>
                            <div class="info-date"><?php echo get_the_date(); ?></div>
                        </div>
                    </a>
                </div>
                <?php
                if ($nb_articles== $page_limit) {
                    ?>
                    </div>
                    <?php
                }
                $nb_articles++;
            endwhile;

            // Pagination.
            /*next_posts_link( 'Older Entries »', $my_query->max_num_pages);
            previous_posts_link( 'Newer Entries' );*/
            base_pagination($my_query);
        endif;

        //On réinitialise à la requête principale (important)
        wp_reset_postdata();
        ?>
    </section><!-- @white-space
    --><aside>
            <?php
                get_template_part('sidebar-magazine');
            ?>
    </aside>
</div>
    <?php
    get_template_part("logos-partenaires");
get_footer();




