<?php
/**
 * Template Name: Carte des relais par région
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */


global $wp_query;
$pregion = $wp_query->query_vars['cregion'];

$regions=explode('_',$pregion);

if(empty($regions)) {
    header("Location: /404.php");
    exit();
}
$allRelaisCoord = [];

foreach($regions as $region) {
    $slugReg='cat-'.$region;
    //recherche des relais de la région
    $args = array(
            'post_type' => 'relais',
            'ignore_sticky_posts' => 1,
            'posts_per_page' => -1,
            'category_name' => $slugReg,
            );

    $query_relais   = new WP_Query($args);
    if ($query_relais->have_posts()) :
        while ($query_relais->have_posts()) : $query_relais->the_post();
            $markerCoord = [];
            $relaisLat   = get_post_meta($post->ID, 'relais-post-latitude', true);
            $relaisLong  = get_post_meta($post->ID, 'relais-post-longitude', true);

            if (!empty($relaisLat) && !empty($relaisLong)) {
                $markerCoord['latitude']  = $relaisLat;
                $markerCoord['longitude'] = $relaisLong;
            }
            //si les coordonnées sont renseignées
            if (!empty($markerCoord)) {
                //on ajoute le type de relais
                $taxo                = get_the_terms($post->ID, 'type');
                $markerCoord['type'] = $taxo[0]->slug;
                //on ajoute l'url de la page du relais
                $relaisUrl           = get_permalink();
                if (!empty($relaisUrl)) {
                    $markerCoord['url'] = $relaisUrl;
                }
                //on ajoute les autres informations
                $markerCoord['title'] = get_the_title();
                if(!empty(get_post_meta( $post->ID, 'relais-post-email', true ))) {
                    $markerCoord['email'] = get_post_meta( $post->ID, 'relais-post-email', true );
                } else {
                     $markerCoord['email'] = "N.C";
                }
                if(!empty(get_post_meta( $post->ID, 'relais-post-address', true ))) {
                    $markerCoord['address']=html_entity_decode(trim(get_post_meta( $post->ID, 'relais-post-address', true )));
                } else {
                    $markerCoord['address']="N.C";
                }
                if(!empty(get_post_meta( $post->ID, 'relais-post-accueil', true ))) {
                    $markerCoord['accueil']=html_entity_decode(trim(get_post_meta( $post->ID, 'relais-post-accueil', true )) );
                } else {
                    $markerCoord['accueil']="N.C";
                }
                $markerCoord['tel']=get_post_meta( $post->ID, 'relais-post-tel', true );

                //et on ajoute le relais aux marqueurs à afficher
                $allRelaisCoord[] = $markerCoord;
            }

        endwhile;
    endif;
    //On réinitialise à la requête principale (important)
    wp_reset_postdata();
}


get_header();
?>
<section class="page-reseau">
    <div class="content-central-column">
        <div class="card-title"><?php echo $coordRegion[$pregion]['title']; ?></div>
        <div class="card-legend">
            <div>
                <img src="<?php echo get_template_directory_uri()?>/images/pictos/picto-legend-relais.png" />
                Relais Particulier emploi
            </div>
            <div>
                <img src="<?php echo get_template_directory_uri() ?>/images/pictos/picto-legend-point-relais.png"/>
                Les points Relais Particulier emploi
            </div>
        </div>
        <div id="card-map"></div>
        <div class="alert-no-js">
            <p>Attention : </p>
            <p>Afin de pouvoir utiliser Google Maps, JavaScript doit être activé.</p>
            <p>Or, il semble que JavaScript est désactivé ou qu'il ne soit pas supporté par votre navigateur.</p>
            <p>Pour afficher Google Maps, activez JavaScript en modifiant les options de votre navigateur, puis essayez à nouveau.</p>
        </div>

        <script type="text/javascript">

            var mapRelais;
            var infoBulle;

            
            function initMap() {
                var picto1='<?php echo get_template_directory_uri() . '/images/pictos/picto-marker-relais.png' ?>';
                var picto2='<?php echo get_template_directory_uri() . '/images/pictos/picto-marker-point-relais.png' ?>';
                var mapOptions = {
                    zoom: <?php  echo $coordRegion[$pregion]['zoom'];?>,
                    center: {lat: <?php  echo $coordRegion[$pregion]['lat'];?>,lng: <?php echo $coordRegion[$pregion]['long'];?> },
                    scrollwheel: false
                }
                var mapRelais = new google.maps.Map(document.getElementById('card-map'), mapOptions);
                var infoBulle = new google.maps.InfoWindow();
                var optionsMarqueur;
                var marqueur;
                var contentInfo;
                <?php
                foreach($allRelaisCoord as $relais) {
                    if($relais['type']=='point-relais') {
                        $picto='picto2';
                    } else {
                        $picto= 'picto1';
                    }
                    echo "optionsMarqueur = {
                            position: {lat: ".$relais['latitude'].", lng: ".$relais['longitude']."},
                            map: mapRelais,
                            icon: ".$picto."
                    };
                    marqueur = new google.maps.Marker(optionsMarqueur);
                    contentInfo = '<div class=\'mapMark\'>"
                        . "<p class=\'text-bold\'>".$relais['title']."</p>"
                        . "<p>".$relais['address']."</p>"
                        . "<p>Téléphone: ".$relais['tel']."</p>"
                        . "<p>Email: <span class=\'content-link\'>".$relais['email']."</span></p>"
                        . "<p>Ouverture au public :<br>".$relais['accueil']."</p>"
                        //. "<p><a class=\'button-infowindow\' href=\'".$relais['url']."\' title=\'page du relais\'>Nous contacter</a></p>"
                        . "</div>';
                    bindInfoWindow(marqueur, contentInfo, infoBulle, mapRelais);
                   ";
                }


                ?>
            }

            function bindInfoWindow(marqueur, info, infoBulle, map) {
                google.maps.event.addListener(marqueur, 'mouseover', function() {
                    infoBulle.setContent(info);
                    infoBulle.open(map, marqueur);
                });
            }




        </script>
        <script async defer
          src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAegpMmfI2S-8T8D1VZBuBJJRJrQJPbtCY&callback=initMap">
        </script>
    </div>

</section>
<?php
get_template_part("logos-partenaires");
get_footer();
