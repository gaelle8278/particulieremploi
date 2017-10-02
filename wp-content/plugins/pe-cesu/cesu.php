<?php
/**
 * Plugin Name: Particulier Emploi Widget Cesu
 * Description: Widget permettant d'afficher un encart présentant le Cesu
 * Version: 1.0
 * Auhtor: Gaëlle Rauffet
 *
 */

add_action('widgets_init', 'widget_cesu_init');
function widget_cesu_init() {
    register_widget("widget_cesu");
}

class widget_cesu extends WP_Widget {
    //déclaration du wiget en BO
    function widget_cesu() {
        $options = array(
            "classname" => "widget-infos-cesu",
            "description" => "Encart présentant le CESU"
        );
        $control = array (
            "width" => 500,
            "height" => 500
        );
        $this->WP_Widget('pe-widget-cesu', 'Particulier Emploi Widget Cesu',$options, $control);
    }

    //affichage front du widget
    function widget($args,$instance) {
        extract($args);
        echo $before_widget;
        ?>
        <div>
            <div class='sidebar-title'>
                Travail déclaré, Tous protégés
            </div>
            <div class='widget-title-separator'></div>
            <div>
                <p>Déclarer une heure d'emploi déclarée permet au salarié de bénéficier :</p>
                <ul class="text-bold">
                    <li>d'un droit à congés payés</li>
                    <li>d'une couverture sociale</li>
                    <li>de l'accès à la formation</li>
                    <li>de droits à la retraite</li>
                </ul>
                <p>L'utilisation du Cesu garantit la déclaration des salaires et
                    le juste calcul des cotisations.<br />
                Le <strong>Cncesu</strong> adresse au salarié une attestation valant bulletin de salaire.
                </p>
            </div>
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
}


