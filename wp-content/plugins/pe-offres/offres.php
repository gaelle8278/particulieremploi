<?php
/**
 * Plugin Name: Particulier Emploi Widget Offres
 * Description: Widget permettant d'afficher une encart incitant à souscrire à une offre FEPEM
 * Version: 1.0
 * Auhtor: Gaëlle Rauffet
 *
 */

add_action('widgets_init', 'widget_offres_init');
function widget_offres_init() {
    register_widget("widget_offres");
}

class widget_offres extends WP_Widget {
    //déclaration du wiget en BO
    function widget_offres() {
        $options = array(
            "classname" => "widget_offres",
            "description" => "widget pour ajouter un encart offre"
        );
        $control = array (
            "width" => 500,
            "height" => 500
        );
        $this->WP_Widget('pe-widget-offres', 'Particulier Emploi Widget Offres',$options, $control);
    }

    //affichage front du widget
    function widget($args,$instance) {
        extract($args);
        echo $before_widget;
        //echo $before_title.$instance['title'].$after_title;
        ?>
            <div>
                <div class='sidebar-title'><?php echo $instance['title']; ?></div>
                <div class='title-separator'></div>
                <p><?php echo $instance['description']; ?></p>
            </div>
            <a class="bloc-offre-link" href="<?php echo $instance['url'] ; ?>">
                    <?php echo $instance['link_text']; ?></a>
        <?php
        echo $after_widget;
    }

    //paramètrage en BO du widget
    function form($instance) {
        //default values
        $default = array (
            "title" => "Vous souhaitez être aidé dans vos démarches ?",
            "description" => "La Fédération des Particuliers Employeurs de France (FEPEM) vous accompagne "
            . "et vous simplifie votre rôle de particulier employeur.",
            "link_text" => "Découvrez nos formules d'accompagnement",
            "url" => get_permalink( ID_PAGEESSENTIEL )

        );
        $datas=wp_parse_args($instance,$default);
        ?>
        <p class="bo-widget-field">
            <label for="<?php echo $this->get_field_id("title") ?>">Titre : </label>
            <input name="<?php echo $this->get_field_name("title") ?>"
                   type="text"
                   id="<?php echo $this->get_field_id("title") ?>"
                   value="<?php echo $datas["title"]; ?>">
        </p>
        <p class="bo-widget-field">
            <label for="<?php echo $this->get_field_id("description") ?>">Contenu : </label>
            <input name="<?php echo $this->get_field_name("description") ?>"
                   type="text"
                   id="<?php echo $this->get_field_id("description") ?>"
                   value="<?php echo $datas["description"]; ?>">
        </p>
        <p class="bo-widget-field">
            <label for="<?php echo $this->get_field_id("link_text") ?>">Texte du lien : </label>
            <input name="<?php echo $this->get_field_name("link_text") ?>"
                   type="text"
                   id="<?php echo $this->get_field_id("link_text") ?>"
                   value="<?php echo $datas["link_text"]; ?>">
        </p>
        <p class="bo-widget-field">
            <label for="<?php echo $this->get_field_id("url") ?>">URL : </label>
            <input name="<?php echo $this->get_field_name("url") ?>"
                   type="text"
                   id="<?php echo $this->get_field_id("url") ?>"
                   value="<?php echo $datas["url"]; ?>">
        </p>
        <?php
    }

    //enregistrement des paramètres du widget
    function update($new, $old) {
        return $new;
    }
}
