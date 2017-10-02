<?php
/**
 * Template Name: Homepage
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */


//enregistrement et récupération du cp de l'internaute
set_user_depcode();
$depCode=get_user_depcode();
//on retrouve la région à partir du cp utilisateur
if(!empty($depCode)) {
    $region=get_region_from_geocode($depCode);
} else {
    $region="";
}
//récupération de la catégorie correspond à la région géolocalisée
$slug='cat-'.$region;
$catReg=get_category_by_slug($slug);

//on vérifie si l'internaute a visité le site
$visited=get_visit();
//header
include(locate_template('header.php'));
//plugin pour saisir cp
include(locate_template('plugin-form-cp.php'));
    ?>
    <!-- recherche -->
    <div class="bloc-recherche">
        <div class="content-central-column">
            <div class="bloc-recherche-wrap">
                <?php
                include(locate_template('homepage-plugin-search.php')); 
                ?>
            </div>
        </div>
    </div>
    <!-- magazine -->
    <div class="bloc-magazine">
        <div class="content-central-column">
            <h1 class="text-center">Le magazine de l'emploi à domicile </h1>
            <!-- page content -->
            <div class="page-content">
                <?php
                while (have_posts()) : the_post();
                    the_content();
                endwhile;
                ?>
            </div>
            <!-- posts -->
            
                <?php
                // 1. récupération des articles nationaux mis en avant
                $sticky = get_option('sticky_posts');
                $argsNat = array(
                    'post_type' => 'post',
                    'category_name' => 'article-national',
                    'ignore_sticky_posts' => 1,
                    'post__in' => $sticky,
                    'posts_per_page' => 1,
                );
                $stickyNationalPost = new WP_Query($argsNat);
                if($stickyNationalPost->have_posts()) { 
                    ?>
                    <div class="highlighted-post">
                        <?php
                        while ($stickyNationalPost->have_posts() ) {
                            $stickyNationalPost->the_post();

                            if ( has_post_thumbnail() ) {
                                ?>
                                <div class="highlighted-post-img">
                                    <?php
                                    the_post_thumbnail('article-list');
                                    ?>
                                    <div class='tag-image'>
                                        <?php
                                        $attachment = get_post(get_post_thumbnail_id($post->ID ));
                                        echo esc_attr($attachment->post_title);
                                        ?>
                                    </div>
                                </div><!-- @whitespace
                                <?php
                            } 
                            ?>
                            --><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="highlighted-post-content">
                                <div class="wrap">
                                    <div class="list-post-cat">National</div> 
                                    <div class="list-post-title"><?php the_title(); ?></div>
                                    <div class="list-post-separator"></div>
                                    <div class="list-post-text"><?php the_excerpt(); ?></div>
                                    <div class="info-date"><?php echo get_the_date(); ?></div>
                                </div>
                            </a>
                            <?php
                        }
                    ?>
                    </div>
                    <?php
                } else {
                    if(!empty($region)) {
                        //2. sinon récupération de l'article régional selon géolocalisation
                        $argsReg = array(
                            'post_type' => 'post',
                            'category_name' => $slug,
                            'ignore_sticky_posts' => 1,
                            'post__in' => $sticky,
                            'posts_per_page' => 1,
                        );
                        $stickyRegionalPost = new WP_Query($argsReg);
                        if($stickyRegionalPost->have_posts()) { 
                            ?>
                            <div class="highlighted-post">
                            <?php
                                while ($stickyRegionalPost->have_posts() ) {
                                    $stickyRegionalPost->the_post();
                                    if ( has_post_thumbnail() ) {
                                        ?>
                                        <div class="highlighted-post-img">
                                            <?php
                                            //the_post_thumbnail(array(520, 520), array( 'class' => 'post-highlighted' ));
                                            the_post_thumbnail('article-list');
                                            ?>
                                            <div class='tag-image'>
                                                <?php
                                                $attachment = get_post(get_post_thumbnail_id($post->ID ));
                                                echo esc_attr($attachment->post_title);
                                            ?>
                                            </div>
                                        </div><!-- @whitespace
                                        <?php   
                                    } 
                                    ?>
                                    --><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="highlighted-post-content">
                                        <div class="wrap">
                                            <div class="list-post-cat">
                                                <?php echo $catReg->name; ?>
                                            </div>
                                            <div class="list-post-title"><?php the_title(); ?></div>
                                            <div class="list-post-separator"></div>
                                            <div class="list-post-text"><?php the_excerpt(); ?></div>
                                            <div class="info-date"><?php echo get_the_date(); ?></div>
                                        </div>
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                    }   
                }
                //réinitialisation à la requête principale 
                wp_reset_postdata();  
                ?>
            <div class="list-home-post">
                <?php
                //3. récupération des articles des autres catégories (non régional, non national)
                $args = array(
                        'post_type' => 'post',
                        'ignore_sticky_posts' => 1,
                        'cat' => "'-".IDCATREGIONAL.",-".IDCATNATIONAL."'",
                        'post__in' => $sticky,
                        'posts_per_page' => 2,
                );

                $stickyOtherPost = new WP_Query($args);
                if($stickyOtherPost->have_posts()) {
                    $i=0;
                    while ($stickyOtherPost->have_posts()) {
                        $stickyOtherPost->the_post();
                        if ($i % 2 == 0) {
                            $class = "right-gutter";
                        } else {
                            $class = '';
                        }

                        if ($i % 2 != 0) {
                            echo "--><div class='home-post " . $class . "'>";
                        } else {
                            echo "<div class='home-post " . $class . "'>";
                        }

                        if (has_post_thumbnail()) {
                            ?>
                            <div class="home-post-img">
                                <?php
                                the_post_thumbnail('article-list-small');
                                ?>
                            </div><!-- @whitespace
                            <?php
                        }
                        ?>
                         --><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="home-post-content">
                                <div class="wrap"> 
                                    <?php
                                    $postCatName =[];
                                    $postCategories = get_the_category();
                                    if (!empty($postCategories)) {
                                        foreach ($postCategories as $category) {
                                            $postCatName[] = $category->name;
                                        }
                                        echo "<div class='list-post-cat'>" . implode(', ', $postCatName) . "</div>";
                                    }
                                    ?>
                                    <div class="list-post-title"><?php the_title(); ?></div>
                                    <div class="info-date"><?php echo get_the_date(); ?></div>
                                   
                                </div>
                            </a>
                        <?php
                        if ($i % 2 == 0) {
                            echo "</div><!-- @whitespace";
                        } else {
                            echo "</div>";
                        }
                        $i++;
                    }
                }
                wp_reset_postdata();   
                ?>
            </div>
        </div><!-- fin bloc centrage du contenu-->
    </div><!-- fin bloc magazine -->
    
    <!-- menus de la relation -->
    <div class="bloc-relations">
        <div class="content-central-column">
                <h1 class="text-center">Les 5 étapes clés de la relation de travail</h1>
                <div class="menu_relation_title menu_relation_pe"> Je suis employeur ou souhaite le devenir</div>
                <?php
                clean_custom_menus('home_pe_menu', 'menu_pe');
                //wp_nav_menu(array('theme_location' => 'home_pe_menu', 'menu_class' => 'menu-pe', 'container' => 'nav', 'container_class'=>'menu_relation'));
                ?>
                <div class="menu_relation_title menu_relation_spe">Je suis salarié ou souhaite le devenir</div>
                <?php
                clean_custom_menus('home_spe_menu', 'menu_spe');
                //wp_nav_menu(array('theme_location' => 'home_spe_menu', 'menu_class' => 'menu_relation menu-spe', 'container' => 'nav', 'container_class'=>'menu_relation'));
                ?>
        </div>
    </div>
    
    <!--relais info -->
    <div class="bloc-relais">
        <div class="content-central-column">
            <h1 class="text-center">Particulier Emploi près de chez vous</h1>
            <div class="relais-infos">
                <?php
                //récupération du relais mis en avant
                $argsRelais = array(
                    'post_type' => 'relais',
                    'post__in' => $sticky,
                    'tax_query' => array(
                                'relation' => 'AND',
                                array(
                                    'taxonomy' => 'category',
                                    'field'    => 'slug',
                                    'terms'    => array( $slug ),
                                ),
                                array(
                                        'taxonomy' => 'type',
                                        'field'    => 'slug',
                                        'terms'    => 'relais',
                                ),
                        ),
                    'posts_per_page' => 1,
                    //custom meta field region
                );
                $pointRelais = new WP_Query($argsRelais);
                if($pointRelais->have_posts()) {
                    while ($pointRelais->have_posts() ) {
                        $pointRelais->the_post();
                        ?>
                        <div class="relais-card">
                            <?php
                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail('thumb-card-size');
                            }
                            ?>
                        </div>
                        <div class="relais-content">
                            <div class="relais-content-column ">
                                <div class="wrap-relais-content">
                                    <h2>Se rendre à votre Relais
                                        <?php
                                        //echo  $catReg->name;
                                        $post_template = get_post_custom();
                                        echo $post_template['relais-post-ville'][0];
                                        ?>
                                    </h2>
                                    <div class="section-title-separator"></div>
                                    <p class="relais-accueil">
                                        <?php echo get_post_meta( $post->ID, 'relais-post-accueil', true ); ?>
                                        <?php echo get_post_meta( $post->ID, 'relais-post-address', true ); ?>
                                    </p>
                                    <p class="relais-pcard">
                                        <a href="<?php echo get_permalink( IDPAGERESEAU ) ; ?>">
                                            Accéder à la carte des Relais Particulier Emploi </a>
                                    </p>
                                </div>
                            </div><!-- @whitespace
                            --><div class="relais-content-column">
                                <div class="wrap-relais-content">
                                    <h2>Contacter nos conseillers</h2>
                                    <div class="section-title-separator"></div>
                                    <p class="relais-tel">
                                        <?php 
                                        echo get_post_meta( $post->ID, 'relais-post-tel', true );
                                        echo get_post_meta( $post->ID, 'relais-post-horaire-tel', true );
                                        ?>
                                    </p>
                                    <p class="relais-email">
                                        <a href="mailto:<?php echo get_post_meta( $post->ID, 'relais-post-email', true );?>" >
                                            <?php echo get_post_meta( $post->ID, 'relais-post-email', true );?></a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }

                } else {
                    ?>
                    <div class="relais-card">
                        <?php
                        $image_attributes = wp_get_attachment_image_src( ID_MEDIA_CARTEFR, 'thumb-card-size' );
                        if ( $image_attributes ) { 
                            ?>
                            <a href="<?php echo get_permalink( IDPAGERESEAU ) ; ?>" alt="carte de france des points relais particulier emploi">
                                <img src="<?php echo $image_attributes[0]; ?>" alt="carte de france" />
                            </a>
                            <?php 
                        } 
                        ?>
                    </div>
                    <div class="relais-content">
                        <div class="relais-content-column">
                            <div class="wrap-relais-content">
                                <h2>Se rendre à votre Relais le plus proche</h2>
                                <div class="section-title-separator"></div>
                                <p class="relais-pcard">
                                    <a href="<?php echo get_permalink( IDPAGERESEAU ) ; ?>">Consulter la carte des Relais Particulier Emploi </a>
                                </p>
                            </div>
                        </div><!-- @whitespace
                        --><div class="relais-content-column">
                            <div class="wrap-relais-content">
                                <h2>Contacter nos conseillers</h2>
                                <div class="section-title-separator"></div>
                                <p class="relais-tel">
                                    0825 07 64 64 (0,15 euro/minute + prix de l'appel) 
                                    du lundi au jeudi de 9h à 18h et le vendredi de 9h à 17h. 
                                </p>
                                <p class="relais-email">
                                    <a href="mailto:contact@particulieremploi.fr">
                                        contact@particulieremploi.fr
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                wp_reset_postdata(); 
                ?>
            </div>
        </div>
    </div>
    <?php
    get_template_part("logos-partenaires");
get_footer();