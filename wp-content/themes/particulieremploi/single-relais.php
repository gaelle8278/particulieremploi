<?php

/**
 *
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */


get_header();
?>

<section>
<div class="content-central-column">
    
        <?php
        $infosStickyRelais=[];
        //1/ récupération de la région du relais sur lequel on a cliqué
        while (have_posts()) :
            the_post();
            //récupération de l'id
            $actualPostID = get_the_ID();
            $displayfirst = false;
            //récupération des catégories
            $postCategories = get_the_category();
            if (!empty($postCategories)) {
                $postCatId=[];
                foreach($postCategories as $category) {
                    //suppression categorie article-regional au cas
                    //où des relais serait tagués avec cette catégorie
                    if($category->cat_ID != IDCATREGIONAL) {
                        $postCatId[]=$category->cat_ID;
                    }
                }
                //si on a cliqué sur un relais mis en avant on l'affiche en premier
                $taxorelais = get_the_terms( $actualPostID, 'type' );
                if( is_sticky() && $taxorelais[0]->slug == IDTAXORELAIS) {
                    $infosStickyRelais[$actualPostID]['title']=get_the_title();
                    $infosStickyRelais[$actualPostID]['email']=get_post_meta( $actualPostID, 'relais-post-email', true );
                    $infosStickyRelais[$actualPostID]['address']=str_replace("<br />","",html_entity_decode(get_post_meta(
                                                                                                            $actualPostID,
                                                                                                            'relais-post-address',
                                                                                                            true )));
                    $infosStickyRelais[$actualPostID]['accueil']=str_replace("<br />","",html_entity_decode(get_post_meta( $actualPostID,
                                                                                                            'relais-post-accueil',
                                                                                                            true )));
                    $infosStickyRelais[$actualPostID]['tel']=get_post_meta( $actualPostID, 'relais-post-tel', true );
                    $infosStickyRelais[$actualPostID]['horaire-tel']=get_post_meta( $actualPostID, 'relais-post-horaire-tel', true );
                    $infosStickyRelais[$actualPostID]['ville']=get_post_meta( $actualPostID, 'relais-post-ville', true );
                    if ( has_post_thumbnail() ) {
                        $infosStickyRelais[$actualPostID]['img']=get_the_post_thumbnail($actualPostID,'thumb-card-size');
                    }
                    $displayfirst=true;
                }
            } else {
                echo "Il y a un problème avec le relais. "
                        . "Veuillez en avertir l'administrateur en communiquant le message suivant :"
                        . "<br> url du relais : ". get_the_permalink() .""
                        . "<br> nom du relais : ". get_the_title() .""
                        . "<br>En vous remerciant";
                return;
            }
        endwhile; 
        
        //2/ récupération des relais de la région
            //2.1 d'abord les sticky relais
        $argsRelaisSticky = array(
                'post_type' => 'relais',
                'category__in' => $postCatId,
                'tax_query' => array(
                    array(
                            'taxonomy' => 'type',
                            'field'    => 'slug',
                            'terms'    => array( IDTAXORELAIS ),
                    ),
                ),
                'post__in' => get_option('sticky_posts'),
                'posts_per_page' => -1
            );
        $queryRelaisSticky = new WP_Query($argsRelaisSticky);
        if($queryRelaisSticky->have_posts()) : 
            while ($queryRelaisSticky->have_posts() ) : $queryRelaisSticky->the_post();
                //si l'on a cliqué sur un stikcy relais il est affiché en premier donc on ne le reprend pas
                if($post->ID == $actualPostID && $displayfirst == true) {
                    continue;
                }
                $infosStickyRelais[$post->ID]['title']=get_the_title();
                $infosStickyRelais[$post->ID]['email']=get_post_meta( $post->ID, 'relais-post-email', true );
                $infosStickyRelais[$post->ID]['address']=str_replace("<br />","",html_entity_decode(get_post_meta(
                                                                                                    $post->ID,
                                                                                                    'relais-post-address',
                                                                                                    true )));
                $infosStickyRelais[$post->ID]['accueil']=str_replace("<br />","",html_entity_decode(get_post_meta(
                                                                                                    $post->ID,
                                                                                                    'relais-post-accueil',
                                                                                                     true )));
                $infosStickyRelais[$post->ID]['tel']=get_post_meta( $post->ID, 'relais-post-tel', true );
                $infosStickyRelais[$post->ID]['horaire-tel']=get_post_meta( $post->ID, 'relais-post-horaire-tel', true );
                $infosStickyRelais[$post->ID]['ville']=get_post_meta( $post->ID, 'relais-post-ville', true );
                if ( has_post_thumbnail() ) {
                    $infosStickyRelais[$post->ID]['img']=get_the_post_thumbnail($post->ID,'thumb-card-size');
                }
            endwhile;
        endif;
        wp_reset_postdata();
        
            //2.2 récupération des contacts des sticky relais
        if(!empty($infosStickyRelais)) {
            $listIDRelais=array_keys($infosStickyRelais);
            foreach ( $listIDRelais as $relaisID) {
                $argsContact = array(
                    'post_type' => 'contact',
                    'category__in' =>   $postCatId,
                    'meta_key' => 'contact-post-ville',
                    'meta_value' => $infosStickyRelais[$relaisID]['ville'],
                    'posts_per_page' => -1

                );
                $queryContact = new WP_Query($argsContact);
               // echo "<pre>";print( $queryContact->request);echo "</pre>";
                if($queryContact->have_posts()) : 
                    while ($queryContact->have_posts() ) : $queryContact->the_post();
                        $contactInfos=[];
                        $contactInfos['title']=get_the_title();
                        $contactInfos['name']=get_post_meta( $post->ID, 'contact-post-name', true );
                        if ( has_post_thumbnail() ) {
                            $contactInfos['avatar']=get_the_post_thumbnail($post->ID,'avatar');
                        }
                        $infosStickyRelais[$relaisID]['contact'][]= $contactInfos;
                    endwhile;
                endif;
                wp_reset_postdata();
            }
        }
        
            //2.3 récupération des autres relais de la région
        $infosRelais=[];
        $argsRelais = array(
                'post_type' => 'relais',
                'category__in' => $postCatId,
                'tax_query' => array(
                    array(
                            'taxonomy' => 'type',
                            'field'    => 'slug',
                            'terms'    => array( IDTAXORELAIS ),
                    ),
                ),
                'post__not_in' => get_option( 'sticky_posts' ),
                'posts_per_page' => -1
            );
        $queryRelais = new WP_Query($argsRelais);
        if($queryRelais->have_posts()) : 
            while ($queryRelais->have_posts() ) : $queryRelais->the_post();
                $infosRelais[$post->ID]['title']=get_the_title();
                $infosRelais[$post->ID]['email']=get_post_meta( $post->ID, 'relais-post-email', true );
                $infosRelais[$post->ID]['address']=str_replace("<br />","",html_entity_decode(get_post_meta(
                                                                                                    $post->ID,
                                                                                                    'relais-post-address',
                                                                                                    true )));
                $infosRelais[$post->ID]['accueil']=str_replace("<br />","",html_entity_decode(get_post_meta(
                                                                                                    $post->ID,
                                                                                                    'relais-post-accueil',
                                                                                                    true )));
                $infosRelais[$post->ID]['tel']=get_post_meta( $post->ID, 'relais-post-tel', true );
                $infosRelais[$post->ID]['horaire-tel']=get_post_meta( $post->ID, 'relais-post-horaire-tel', true );
                $infosRelais[$post->ID]['ville']=get_post_meta( $post->ID, 'relais-post-ville', true );
                if ( has_post_thumbnail() ) {
                    $infosRelais[$post->ID]['img']=get_the_post_thumbnail('thumb-card-size');
                }
            endwhile;
        endif;
        wp_reset_postdata();
            
            //2.4 merge de l'ensemble des relais à afficher
        $allRelaisToDisplay=array_merge($infosStickyRelais, $infosRelais);
        
        //3/ recupération des points relais de la région
        $infosPointRelais=[];
        $args = array(
                'post_type' => 'relais',
                'category__in' => $postCatId,
                'tax_query' => array(
                    array(
                            'taxonomy' => 'type',
                            'field'    => 'slug',
                            'terms'    => array( IDTAXOPOINTRELAIS ),
                    ),
                ),
                'posts_per_page' => -1
            );
        $queryPointRelais = new WP_Query($args);
        if($queryPointRelais->have_posts()) :
            
            while ($queryPointRelais->have_posts() ) : $queryPointRelais->the_post();
                $infosPointRelais[$post->ID]['title']=get_the_title();
                $infosPointRelais[$post->ID]['email']=get_post_meta( $post->ID, 'relais-post-email', true );
                $infosPointRelais[$post->ID]['address']=str_replace("<br />","",html_entity_decode(get_post_meta(
                                                                                                    $post->ID,
                                                                                                    'relais-post-address',
                                                                                                    true )));
                $infosPointRelais[$post->ID]['accueil']=str_replace("<br />","",html_entity_decode(get_post_meta(
                                                                                                    $post->ID,
                                                                                                    'relais-post-accueil',
                                                                                                    true )));
                $infosPointRelais[$post->ID]['tel']=get_post_meta( $post->ID, 'relais-post-tel', true );
                //$infosPointRelais[$post->ID]['horaire-tel']=get_post_meta( $post->ID, 'relais-post-horaire-tel', true );
                //$infosPointRelais[$post->ID]['ville']=get_post_meta( $post->ID, 'relais-post-ville', true );
                
            endwhile;
        endif;
        wp_reset_postdata();
        
        
        ?>
        <div class="zone-relais">
            <?php
            if(!empty($allRelaisToDisplay)) {
                foreach ( $allRelaisToDisplay as $relaisID => $infosRelais ) {
                    ?>
                    <div class="bloc-detail-relais">
                        <div class="relais-section-title"><?php echo $infosRelais['title'] ?></div>
                        <div class="section-title-separator"></div>
                        <?php
                        if(isset($infosRelais['contact'])) {
                            foreach ( $infosRelais['contact'] as $key => $contactInfos ) {
                                ?>
                                <div class="contact-relais">
                                    <div>
                                        <?php echo $contactInfos['avatar'] ?>
                                    </div>
                                    <div>
                                        <p class="text-bold"><?php echo $contactInfos['name'] ?></p>
                                        <?php echo $contactInfos['title'] ?>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        <div class="infos-relais">
                            <div class="relais-tel">
                                <?php echo $infosRelais['tel'] ?><br>
                                <?php echo $infosRelais['horaire-tel'] ?>
                            </div>
                            <div class="relais-email">
                               <?php echo $infosRelais['email'] ?>
                            </div>
                            <div class="relais-accueil">
                                <?php echo $infosRelais['address'] ?><br>
                                    <?php echo $infosRelais['accueil'] ?>
                            </div>
                        </div>
                        <?php
                        if ( isset ( $infosRelais['img'] ) ) {
                            ?>
                            <div class="card-relais"><?php echo $infosRelais['img'] ?></div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
            }
            ?>
        </div><!-- @whitespace
        --><div class="zone-pointrelais">
            <?php
            if(!empty($infosPointRelais)) {
            ?>
                <div class="relais-section-title">Nos points relais Particulier Emploi</div>
                <div class="section-title-separator"></div>
                <?php
                foreach ($infosPointRelais as $relaisID => $infosRelais ) {
                    ?>
                    <div class="bloc-detail-pointrelais">
                        <div class="title"><?php echo $infosRelais['title'] ?></div>
                        <div><?php echo $infosRelais['address'] ?></div>
                        <div>Téléphone: <?php echo $infosRelais['tel'] ?></div>
                        <?php
                        if(isset($infosRelais['email']) && !empty($infosRelais['email'])) {
                            ?>
                            <div class="pointrelais-email">
                                email: <span class="content-link"><?php echo $infosRelais['email'] ?></span>
                            </div>
                            <?php
                        }
                        ?>
                        <div>Ouverture au public : <br>
                            <?php echo $infosRelais['accueil'] ?>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
</div>
</section>
<?php
get_template_part("logos-partenaires");
get_footer();