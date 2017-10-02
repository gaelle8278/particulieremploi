<?php

/**
 * Template de la page des résultats de la recherche
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */


get_header();
?>

    <div class="content-central-column">
        <section class="search_results">
            <div class="breadcrumb">
                <a href="<?php echo get_bloginfo('wpurl'); ?>">
                    <img src="<?php echo get_template_directory_uri() ?>/images/pictos/home.png" />
                </a> > 
                <span class="text-bold">Recherche</span> > Resultat
            </div>
            <div class="bloc-res-search">
                <h1> Résultats de la recherche </h1>
                <?php 
                $count = $wp_query->found_posts;
                $several = ($count<=1) ? '' : 's'; 
                $output = "<p class='search-count'>";
                if ($count>0) {
                    $output .=  $count.' résultat'.$several.' pour la recherche';
                } else {
                    $output .= 'Aucun résultat pour la recherche';
                }
                   
                $output .= ' "<span class="text-bold">'. get_search_query() .'</span>"</p>';
                echo $output;
                
                if (have_posts()) : 
                    while (have_posts()) : the_post();
                        ?>
                        <div class="bloc_display_post">
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <div class="post-info">
                                Publié le <?php echo get_the_date(); ?>  
                                    <?php
                                    $postCatName=[];
                                    $postCategories = get_the_category();
                                    if (!empty($postCategories)) {
                                        foreach ($postCategories as $category) {
                                            $postCatName[] = $category->name;
                                        }
                                        echo " dans ".implode(', ', $postCatName).".";
                                    }
                                ?>
                            </div>
                            <div class="post-content"> 
                                <?php the_excerpt(); ?> 
                            </div>
                        </div>
                        <?php
                    endwhile;
                endif;
                ?>
            </div>
            <?php
                //pagination
                base_pagination();
            ?>
        </section>
    </div>
    <?php
get_template_part("logos-partenaires");
get_footer();