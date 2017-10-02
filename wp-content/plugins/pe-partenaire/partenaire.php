<?php
/**
 * Plugin Name: Particulier Emploi Widget Partenaires
 * Description: Widget permettant d'afficher une encart proposant les services d'un partenaire
 * Version: 1.0
 * Auhtor: Gaëlle Rauffet
 *
 */

add_action('widgets_init', 'widget_partenaire_init');
function widget_partenaire_init() {
    register_widget("widget_partenaire");
}

class widget_partenaire extends WP_Widget {
    //déclaration du wiget en BO
    function widget_partenaire() {
        $options = array(
            "classname" => "widget_partenaire",
            "description" => "widget pour ajouter un encart présentant le service d'un partenaire"
        );
        $control = array (
            "width" => 500,
            "height" => 500
        );
        $this->WP_Widget('pe-widget-partenaire', 'Particulier Emploi Widget partenaire',$options, $control);
    }

    //affichage front du widget
    function widget($args,$instance) {
        extract($args);
        echo $before_widget;
        //echo $before_title.$instance['title'].$after_title;
        ?>
        <div>
            <div class='sidebar-title'>
                <?php echo $instance['title']; ?>
            </div>
            <div class='widget-title-separator'></div>
            <p> <?php echo $instance['description']; ?>
            </p>
        </div>
        <a class="bloc-part-link" href="<?php echo $instance['url']; ?>" target='_blank'>
            <span class="text-bold">
                <?php echo $instance['link_text']; ?>
            </span><br>
            <?php echo html_entity_decode($instance['sub_link_text']); ?>
        </a>

        <?php
        echo $after_widget;
    }

    //paramètrage en BO du widget
    function form($instance) {
        //default values
        $default = array (
            "title" => "",
            "description" => "",
            "link_text" => "",
            "sub_link_text" => "",
            "url" => ""

        );
        $datas=wp_parse_args($instance,$default);
        ?>
        <p class="bo-widget-field">
            <label for="<?php echo $this->get_field_id("title") ?>">Titre : </label>
            <input name="<?php echo $this->get_field_name("title") ?> "
                   type="text"
                   id="<?php echo $this->get_field_id("title") ?>"
                   value="<?php echo $datas["title"]; ?>" >
        </p>
        <p class="bo-widget-field">
            <label for="<?php echo $this->get_field_id("description") ?>">Contenu : </label>
            <textarea name="<?php echo $this->get_field_name("description") ?>"
                      id="<?php echo $this->get_field_id("description") ?>" >
                   <?php echo $datas["description"]; ?>
            </textarea>
        </p>
        <p class="bo-widget-field">
            <label for="<?php echo $this->get_field_id("link_text") ?>">Texte du lien : </label>
            <input name="<?php echo $this->get_field_name("link_text") ?>"
                   type="text"
                   id="<?php echo $this->get_field_id("link_text") ?>"
                   value="<?php echo $datas["link_text"]; ?>">
        </p>
        <p class="bo-widget-field">
            <label for="<?php echo $this->get_field_id("sub_link_text") ?>">Texte complémentaire du lien : </label>
            <input name="<?php echo $this->get_field_name("sub_link_text") ?>"
                   type="text"
                   id="<?php echo $this->get_field_id("sub_link_text") ?>"
                   value="<?php echo $datas["sub_link_text"]; ?>">
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
        $instance=$new;
        $instance['sub_title_link']=htmlentities($new['sub_title_link']);

        return $instance;
    }
}
