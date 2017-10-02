<?php

/**
 * Widget relais géolocalisé
 * 
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

//geoloc : dépend du plugin GeoIP Detection
$depCode=geolocalisation();
if(!empty($depCode)) {
    $region=get_region_from_geocode($depCode);
}
$slug='cat-'.$region;
$geoloc=1;

//récupération du relais géolocalisé mis en avant
$infosRelais=[];
$sticky = get_option('sticky_posts');
$argsRelais = array(
    'post_type' => 'relais',
    'post__in' => $sticky,
    'tax_query' => array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => array($slug),
        ),
        array(
            'taxonomy' => 'type',
            'field' => 'slug',
            'terms' => 'relais',
        ),
    ),
    'posts_per_page' => 1,
);
$pointRelais = new WP_Query($argsRelais);
if ($pointRelais->have_posts()) {
    while ($pointRelais->have_posts()) {
        $pointRelais->the_post();
        $infosRelais[$post->ID]['title'] = "";
        $infosRelais[$post->ID]['email'] = get_post_meta($post->ID, 'relais-post-email', true);
        $infosRelais[$post->ID]['address'] = get_post_meta($post->ID, 'relais-post-address', true);
        $infosRelais[$post->ID]['accueil'] = get_post_meta($post->ID, 'relais-post-accueil', true);
        $infosRelais[$post->ID]['tel'] = get_post_meta($post->ID, 'relais-post-tel', true);
        $infosRelais[$post->ID]['horaire-tel'] = get_post_meta($post->ID, 'relais-post-horaire-tel', true);
        $infosRelais[$post->ID]['ville'] = get_post_meta($post->ID, 'relais-post-ville', true);
        if (has_post_thumbnail()) {
            $infosRelais[$post->ID]['img'] = get_the_post_thumbnail($post->ID, 'thumb-card-size');
        }
    }
} else {
    $geoloc=0;
    $infosRelais[0]['title'] ="Contacter nos conseillers";
    $infosRelais[0]['email'] ="contact@particulieremploi.fr"; 
    $infosRelais[0]['address']="";
    $infosRelais[0]['accueil']="";
    $infosRelais[0]['tel']="0825 07 64 64 (0,15 euro/minute + prix de l'appel)";
    $infosRelais[0]['horaire-tel']="du lundi au jeudi de 9h à 18h et le vendredi de 9h à 17h.";
    $infosRelais[0]['ville']="";
    $image_attributes = wp_get_attachment_image_src( ID_MEDIA_CARTEFR, 'thumb-card-size' );
    $infosRelais[0]['img']='<img src="'.$image_attributes[0].'" alt="carte de france" />';
    
    
}
wp_reset_postdata();

//récupération des contacts du relais
if(!empty( $infosRelais ) && $geoloc == 1) {
    $listIDRelais=array_keys($infosRelais);
    foreach ($listIDRelais as $relaisID) {
        $argsContact = array(
            'post_type' => 'contact',
            'category_name' => $slug,
            'meta_key' => 'contact-post-ville',
            'meta_value' => $infosRelais[$relaisID]['ville'],
        );
        $queryContact = new WP_Query($argsContact);
        if ($queryContact->have_posts()) :
            while ($queryContact->have_posts()) : $queryContact->the_post();
                $contactInfos = [];
                $contactInfos['title'] = get_the_title();
                $contactInfos['name'] = get_post_meta($post->ID, 'contact-post-name', true);
                if (has_post_thumbnail()) {
                    $contactInfos['avatar'] = get_the_post_thumbnail($post->ID, 'avatar');
                }
                $infosRelais[$relaisID]['contact'][] = $contactInfos;
            endwhile;
        endif;
        wp_reset_postdata();
    }
}
?>
<!-- Affichage -->
<div class="sidebar-widget-article">
    <div>
        <div class='sidebar-title'>Besoin d'aide?</div>
    
        <div class='widget-title-separator'></div>
    
        <?php
        foreach($infosRelais as $relaisID => $relais) {
            ?>
            <div class="bloc-detail-relais">
                <?php
                if(!empty($relais['title'])) {
                    ?>
                    <p class="text-taller"><?php echo $relais['title']; ?></p>
                    <?php
                }
                
                if(isset($relais['contact'])) {
                    foreach ($relais['contact'] as $key => $contactInfos) {
                        ?>
                        <div class="contact-relais">
                            <div><?php echo $contactInfos['avatar'] ?></div>
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
                        <?php echo $relais['tel'] ?><br>
                        <?php echo $relais['horaire-tel'] ?>
                    </div>
                    <div class="relais-email">
                        <a href="mailto:<?php echo $relais['email'] ?>"><?php echo $relais['email'] ?></a>
                    </div>
                    <?php
                    if(!empty($relais['address']) && !empty($relais['accueil'])) {
                        ?>
                        <div class="relais-accueil">
                            <?php echo $relais['address'] ?><br>
                            <?php echo $relais['accueil'] ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <?php
                if (isset($relais['img'])) {
                    ?>
                    <div class="card-relais"><?php echo $relais['img'] ?></div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>
    </div>
</div>