<?php
/**
 * Plugin Name: Particulier Emploi Widget Recherche
 * Description: Widget permettant d'afficher un formulaire de recherche d'annonces/offres disponibles sur particulier emploi
 * Version: 1.0
 * Auhtor: Gaëlle Rauffet
 *
 */

add_action('widgets_init', 'widget_recherche_init');
function widget_recherche_init() {
    register_widget("widget_recherche");
}

class widget_recherche extends WP_Widget {
    //déclaration du wiget en BO
    function widget_recherche() {
        $options = array(
            "classname" => "widget_recherche",
            "description" => "Formulaire de recherche d'annonces/offres disponibles sur particulier emploi"
        );
        $control = array (
            "width" => 500,
            "height" => 500
        );
        $this->WP_Widget('pe-widget-recherche', 'Particulier Emploi Widget recherche',$options, $control);
    }

    //affichage front du widget
    function widget($args,$instance) {
        extract($args);
        if($instance['type']=="offre") {
            $classForm="bloc-recherche-sidebar-sal";
            $classWidget= "widget-search-sal";
            $title="Vous recherchez un emploi à domicile ?";
            $subTitle="Trouver un emploi en fonction de vos besoins";
            $type_annonce="emp";
        } else {
            $classForm="bloc-recherche-sidebar-emp";
            $classWidget= "widget-search-emp";
            $title="Vous recherchez un salarié à domicile ?";
            $subTitle="Trouver un salarié en fonction de vos besoins";
            $type_annonce="sal";
        }
        //recherche des métiers
        global $wpdb;
        $queryMetier= "SELECT
            referentiel_id,
            referentiel_libelle
            from tbl_ref_metiers
            WHERE referentiel_visibilite = '1'
            order by referentiel_libelle ASC";
        $resMetier=$wpdb->get_results($queryMetier);



        echo $before_widget;
        ?>
        <div class="<?php echo $classWidget ?>">
            <div class='sidebar-title sidebar-title-search'>
                <p><?php echo $title; ?></p>
            </div>
            <div>
                <div class='title-separator'></div>
                <p><?php echo $subTitle; ?></p>
            </div>
        </div>
        <form action="/pe/recherche/results.php" method="post" class="bloc-recherche-sidebar <?php echo $classForm ?>">
            <input type="hidden" name="type_annonce" value="<?php echo $type_annonce ?>" />
            <div class="bloc-field-form">
                <label for="metier">Métiers</label>
                <div class="select-style">
                    <select name="metier" id="metier">
                        <option value="0">Sélectionner</option>
                        <?php
                        foreach ($resMetier as $result) {
                            echo "<option value='".$result->referentiel_id."'>";
                            echo $result->referentiel_libelle."</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="bloc-field-form">
                <div class="bloc-field-inline field-cp">
                    <label for="codep">Localisation</label>
                    <input type="text" class="input-style" id="codep" name="codep" placeholder="Code Postal">
                </div>
                <div class="bloc-field-inline field-submit">
                    <input type="submit" value="Rechercher"  />
                </div>
            </div>
        </form>
        <?php
        echo $after_widget;
    }

    //paramètrage en BO du widget
    function form($instance) {
        //default values
        $default = array (
            "type" => "annonce"

        );
        $datas=wp_parse_args($instance,$default);
        ?>
        <p class="bo-widget-field">
            <label for="<?php echo $this->get_field_id( 'type' ); ?> ">Type de recherche : </label>
            <select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>">
                <option value="annonce" <?php echo $datas["type"]=="annonce"?"selected=\"selected\"":""; ?>>Annonces</option>
                <option value="offre" <?php echo $datas["type"]=="offre"?"selected=\"selected\"":""; ?>>Offres</option>
            </select>
        </p>

        <?php
    }

    //enregistrement des paramètres du widget
    function update($new, $old) {
        $instance = $old;
        $instance['type'] = strip_tags( $new['type'] );

        return $instance;
    }
}
