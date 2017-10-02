<?php
/**
 * Plugin Name: Particulier Emploi Widget volet Cesu
 * Description: Widget permettant d'afficher un encart menant à la page de présentation du volet cesu
 * Version: 1.0
 * Auhtor: Gaëlle Rauffet
 *
 */

add_action('widgets_init', 'widget_voletcesu_init');
function widget_voletcesu_init() {
    register_widget("widget_voletcesu");
}

class widget_voletcesu extends WP_Widget {
    //déclaration du wiget en BO
    function widget_voletcesu() {
        $options = array(
            "classname" => "widget_voletcesu",
            "description" => "Encart menant à la page de présentation du volet cesu"
        );
        $control = array (
            "width" => 500,
            "height" => 500
        );
        $this->WP_Widget('pe-widget-voletcesu', 'Particulier Emploi Widget volet Cesu',$options, $control);
    }

    //affichage front du widget
    function widget($args,$instance) {
        extract($args);
        echo $before_widget;
        ?>
        <div>
            <div class='sidebar-title'>
                Comment remplir le volet social ?
            </div>
            <div class='widget-title-separator'></div>

            <div>
                <img src="<?php echo get_template_directory_uri() ?>/images/volet-social-cesu.jpg"
                     alt="image du volet social avec légende" >
            </div>
            <a class='link-volet-cesu' href="<?php echo get_permalink(ID_PAGE_VOLETCESU); ?>"> Voir plus  > </a>
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

