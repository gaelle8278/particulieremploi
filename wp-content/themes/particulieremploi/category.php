<?php

/**
 * Template des pages catégories
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
//enregistrement et récupération du cp de l'internaute
set_user_depcode();
$depCode=get_user_depcode();
get_header();
//plugin pour saisir cp
include(locate_template('plugin-form-cp.php'));
?>
<div class="content-central-column">
    <?php
    
    if(is_category($glossaryEntries)) {
        get_template_part('content-glossary-entry');
    } else {
        wp_nav_menu(array('theme_location' => 'nav_categories', 'container' => 'nav', 'container_class'=>'category_menu'));
        ?>
        <section>
            <?php
            $nb_articles=0;
            $nb_inside_articles=1;
            $pas_bloc=1;
            $page_limit=get_option('posts_per_page')-1;
            while (have_posts()) :
                the_post();
                if($nb_articles==0) {
                    ?>
                    <div class="bloc-ensemble-article bloc-ensemble-gauche">
                    <?php
                    $inside_class="large-article";
                    $pas_bloc++;
                }  else if($nb_articles%3==0) {
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
                            /*$postCatName=[];
                            $postCategories = get_the_category();
                            if (!empty($postCategories)) {
                                foreach ($postCategories as $category) {
                                    $postCatName[] = $category->name;
                                }
                                ?>
                                <div><?php echo implode(', ', $postCatName) ?></div>
                                <?php
                            }*/
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

            //pagination
            base_pagination();
            ?>
        </section><!-- @white-space
        --><aside>
            <?php
            get_sidebar();
            ?>
        </aside>
        <?php
    }
    ?>
</div>
<?php
get_template_part("logos-partenaires");
get_footer();