<?php

/**
 * Template Name: Carte des relais
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

get_header();
?>
<section class="page-reseau">
    <div class="content-central-column">
        <?php
        //page content
        while (have_posts()) :
            the_post();
            the_content();
        endwhile; 
            
        //récupération des relais et point-relais
        $args = array(
             'post_type' => 'relais',
            'ignore_sticky_posts' => 1,
            'posts_per_page' => -1,
    //      'meta_key' => 'metabox_field_post_template',
    //      'meta_value' => 'article-magazine',
            /*'tax_query' => array(
                array(
                        'taxonomy' => 'type',
                        'field'    => 'slug',
                        'terms'    => 'relais',
                ),
            ),*/
        );
        $allRelaisCoord=[];
        $query_relais = new WP_Query($args);
        if($query_relais->have_posts()) : 
            while ($query_relais->have_posts() ) : $query_relais->the_post();
                       $markerCoord=[];
                    $relaisLat=get_post_meta( $post->ID , 'relais-post-latitude' , true );
                    $relaisLong=get_post_meta( $post->ID , 'relais-post-longitude' , true );
                    
                    if(!empty($relaisLat) && !empty($relaisLong)) {
                        $markerCoord['latitude']=$relaisLat;
                        $markerCoord['longitude']=$relaisLong;
                    }
                    //si les coordonnées sont renseignées
                    if(!empty($markerCoord)) {
                        //on ajoute le type de relais
                        $taxo=get_the_terms($post->ID, 'type');
                        $markerCoord['type']=$taxo[0]->slug;
                        //on ajoute l'url de la page du relais
                        $relaisUrl=get_permalink();
                        if(!empty($relaisUrl)) {
                            $markerCoord['url']=$relaisUrl;
                        }
                        //et on ajoute le relais aux marqueurs à afficher
                        $allRelaisCoord[]=$markerCoord;
                    } 
                    
                endwhile;
        endif;
        //On réinitialise à la requête principale (important)
        wp_reset_postdata();
        
        //affichage
        ?>
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
            function initMap() {
                var picto1='<?php echo get_template_directory_uri() . '/images/pictos/picto-marker-relais.png' ?>';
                var picto2='<?php echo get_template_directory_uri() . '/images/pictos/picto-marker-point-relais.png' ?>';
                var mapOptions = {
                    zoom: 7,
                    center: {lat: 46.52863469527167,lng: 2.43896484375},
                    scrollwheel: false
                }
                var mapRelais = new google.maps.Map(document.getElementById('card-map'), mapOptions);
                <?php 
                foreach($allRelaisCoord as $relais) {
                    if($relais['type']=='point-relais') {
                        $picto='picto2';
                    } else {
                        $picto= 'picto1';
                    }
                    echo "var optionsMarqueur = {
                            position: {lat: ".$relais['latitude'].", lng: ".$relais['longitude']."},
                            map: mapRelais,
                            icon: ".$picto."
                    };
                    var marqueur = new google.maps.Marker(optionsMarqueur);
                    marqueur.addListener('click', function() {
                        window.open('".$relais['url']."','_self');
                    });";
                }
                
                
                ?>
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