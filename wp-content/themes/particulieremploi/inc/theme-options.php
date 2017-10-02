<?php
/* 
 * Settings added in admin panel
 */

//récupération des options du thème
function pe_get_theme_options() {
    //les options du thème sont définies dans la valeur pe_theme_options en BDD
    return get_option( 'pe_theme_options' );
}

//rendu de la page des options
function theme_settings_page(){
    ?>
	    <div class="wrap">
                <h1>Configuration du thème</h1>
                <form method="post" action="options.php">
                    <?php
                        settings_fields("section");
                        do_settings_sections("theme-options");
                        submit_button();
                    ?>
                </form>
            </div>
	<?php
}

//ajout de la page des options
function add_theme_options_item() {
    add_menu_page("Configuration", "Configuration", "manage_options", "theme-panel", "theme_settings_page", null, 99);
}
add_action("admin_menu", "add_theme_options_item");

//ajout des options à la page des options
function display_theme_panel_fields()
{
    add_settings_section("section", "Gestion des marges de droite", null, "theme-options");
    //affichage de l'option
    add_settings_field( 'custom_sidebar', 'Marges de droite', 'pe_settings_field_custom_sidebar', 'theme-options', 'section' );
    //définition du champs en BDD qui contient les oprions
    register_setting('section','pe_theme_options');

}
add_action("admin_init", "display_theme_panel_fields");

//rendu de l'option custom sidebar
function pe_settings_field_custom_sidebar() {
    // Retrieve theme options
    $opts = pe_get_theme_options();
    //$opts=get_option('custom_sidebar');


    // A bit of jQuery to handle interactions (add / remove sidebars)
    $output = "<script type='text/javascript'>";
    $output .= '
                var $ = jQuery;
                $(document).ready(function(){
                    $(".sidebar_management").on("click", ".delete", function(){
                        $(this).parent().remove();
                    });

                    $("#add_sidebar").click(function(){
                        $(".sidebar_management ul").append("<li>"+$("#new_sidebar_name").val()+" <a href=\'#\' class=\'delete\'>Supprimer</a> <input type=\'hidden\' name=\'pe_theme_options[custom_sidebar][]\' value=\'"+$("#new_sidebar_name").val()+"\' /></li>");
                        $("#new_sidebar_name").val("");
                    })

                })
    ';

    $output .= "</script>";

    $output .= "<div class='sidebar_management'>";

    $output .= "<p><input type='text' id='new_sidebar_name' /> "
        . "<input class='button-primary' type='button' id='add_sidebar' value='Ajouter' /></p>";

    $output .= "<ul>";


    // Display every custom sidebar
    if(isset($opts['custom_sidebar']))
    {
        $i = 0;
        foreach($opts['custom_sidebar'] as $sidebar)
        {
            $output .= "<li>".$sidebar." <a href='#' class='delete'>Supprimer</a> "
                . "<input type='hidden' name='pe_theme_options[custom_sidebar][]' value='".$sidebar."' /></li>";
            $i++;
        }
    }

    $output .= "</ul>";

    $output .= "</div>";

    echo $output;
}





