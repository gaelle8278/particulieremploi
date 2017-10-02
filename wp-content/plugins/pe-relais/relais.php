<?php
/**
 * Plugin Name: Particulier Emploi Widget Relais
 * Description: Widget permettant d'afficher les informations à propos d'un relais pe.  Ce widget se base sur la géolocalisation.
 * Version: 1.0
 * Auhtor: Gaëlle Rauffet
 *
 */

add_action('widgets_init', 'widget_relais_init');
function widget_relais_init() {
    register_widget("widget_relais");
}

class widget_relais extends WP_Widget {
    //déclaration du wiget en BO
    function widget_relais() {
        $options = array(
            "classname" => "widget_relais",
            "description" => "widget pour ajouter les informations d'un relais"
        );
        $control = array (
            "width" => 500,
            "height" => 500
        );
        $this->WP_Widget('pe-widget-relais', 'Particulier Emploi Widget relais',$options, $control);
    }

    //affichage front du widget
    function widget($args,$instance) {
        extract($args);

        //cp choisi par l'utilisateur
        $depCode=get_user_depcode();
        //on retrouve la région à partir du cp utilisateur
        if(!empty($depCode)) {
            $region=get_region_from_geocode($depCode);
        } else {
            $region="";
        }
        $slug='cat-'.$region;
        //on récupère le relai de la région concernée
        $infosRelais=$this->get_relais_infos($slug);

        //affichage
        echo $before_widget;
        ?>
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
        <?php
        echo $after_widget;
        
    }

    //paramètrage en BO du widget
    function form($instance) {
        return true;
        
    }

    //enregistrement des paramètres du widget
    function update($new, $old) {
        return $new;
    }



    function get_relais_infos($slug) {
        $geoloc=1;
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
       // echo print_r($pointRelais);
        if ($pointRelais->have_posts()) {
            while ($pointRelais->have_posts()) {
                $pointRelais->the_post();
                $id=get_the_ID();
                $infosRelais[$id]['title'] = "";
                $infosRelais[$id]['email'] = get_post_meta($id, 'relais-post-email', true);
                $infosRelais[$id]['address'] = get_post_meta($id, 'relais-post-address', true);
                $infosRelais[$id]['accueil'] = get_post_meta($id, 'relais-post-accueil', true);
                $infosRelais[$id]['tel'] = get_post_meta($id, 'relais-post-tel', true);
                $infosRelais[$id]['horaire-tel'] = get_post_meta($id, 'relais-post-horaire-tel', true);
                $infosRelais[$id]['ville'] = get_post_meta($id, 'relais-post-ville', true);
                if (has_post_thumbnail()) {
                    $infosRelais[$id]['img'] = get_the_post_thumbnail($id, 'thumb-card-size');
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
                        $id=get_the_ID();
                        $contactInfos = [];
                        $contactInfos['title'] = get_the_title();
                        $contactInfos['name'] = get_post_meta($id, 'contact-post-name', true);
                        if (has_post_thumbnail()) {
                            $contactInfos['avatar'] = get_the_post_thumbnail($id, 'avatar');
                        }
                        $infosRelais[$relaisID]['contact'][] = $contactInfos;
                    endwhile;
                endif;
                wp_reset_postdata();
            }
        }

        return $infosRelais;
    }
}
