<?php

/* 
 * Fichier contenant les fonctions de traitement
 */

ini_set( 'mysql.trace_mode', 0 );

// Add constants script (must be first because can be used by other included files)
require get_template_directory() . '/inc/usefull-constants.php';

/**
 * Registers support for various WordPress features.
 */
function particulieremploi_setup() {
        /** translation */
        load_theme_textdomain( 'particulieremploi', get_template_directory() . '/languages' );
        /*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
        /*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
        /**
         * add of custom sizes
         */
        //images des articles de la hp
	add_image_size( 'article-list', 480, 350, true );
        add_image_size( 'article-list-small', 228,178, true );
        //image des articles des pages liste d'articles avec sidebar (ex: magazine)
        add_image_size( 'article-list-mag', 312, 205, true );
        //image des articles des pages liste d'articles sans sidebar (ex: archive)
        add_image_size( 'article-list-full', 490, 305, true );
        //image pour l'affichage du point relais
        add_image_size( 'thumb-card-size', 297, 257, true );
        //image pour l'affichage des auteurs/contacts
        add_image_size( 'avatar', 70, 70, true );
        
        /** support for post format */ 
        //add_theme_support('post-formats', array('video', 'gallery'));
        /*
	 * Styling of the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	//add_editor_style( array( 'css/editor-style.css', 'genericons/genericons.css', twentyfifteen_fonts_url() ) );
}
add_action( 'after_setup_theme', 'particulieremploi_setup' );

//===== Gestion des sessions ===
function pe_session_start() {
   if ( ! session_id() ) {
      @session_start();
   }
}
function pe_end_session() {
    session_destroy ();
}
add_action('init', 'pe_session_start', 1);
add_action('wp_logout', 'pe_end_session');
add_action('wp_login', 'pe_end_session');

//=== inclusion des fichiers js/css ===
/**
 * JavaScript Detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 */
function pe_javascript_detection() {
    echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'pe_javascript_detection', 0 );

function pe_enqueue_scripts() { 
    $js_directory = get_template_directory_uri() . '/js/'; 
    wp_register_script( 'main', $js_directory . 'main.js', 'jquery', '1.0' );
    wp_register_script( 'stacktable', $js_directory . 'stacktable.min.js', 'jquery', '1.7' );  
    wp_enqueue_script( 'jquery' ); 
    wp_enqueue_script( 'jquery-ui-core' );
    wp_enqueue_script('jquery-ui-tabs'); 
    wp_enqueue_script('jquery-ui-dialog');
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_script('jquery-ui-accordion');
    wp_enqueue_script('jquery-ui-tooltip');
    wp_enqueue_script('stacktable');
    wp_enqueue_script( 'main' );
} 
function pe_enqueue_style() {  
    $css_directory = get_template_directory_uri() . '/css/'; 
    wp_enqueue_style( 'jqueryui', '//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css', false);
    wp_enqueue_style( 'stacktable', $css_directory  . 'stacktable.css', false); 
    wp_enqueue_style( 'core',  get_template_directory_uri()  . '/style.css', false); 
    wp_enqueue_style( 'pe-google-fonts', 'https://fonts.googleapis.com/css?family=PT+Serif:400,700', false );
    wp_enqueue_style( 'pe-google-fonts-2','https://fonts.googleapis.com/css?family=PT+Sans:400,700' , false );
    

}
add_action( 'wp_enqueue_scripts', 'pe_enqueue_style' );
add_action( 'wp_enqueue_scripts', 'pe_enqueue_scripts' );

//=== custom body class ======
add_filter( 'body_class','page_body_class' );
function page_body_class( $classes ) {
    global $glossaryEntries;
    if ( is_category() || is_single() || is_search() ||
            is_page_template('page-templates/magazine-template.php') ||
            is_page_template('page-templates/simulateur-cesu.php') ||
            is_page_template('page-templates/volet-cesu.php') ||
            is_page_template('page-templates/cesu-10-points.php') ||
            is_page_template('page-templates/essentiels-offre-v2.php') ||
            is_page_template('page-templates/essentiels-offre.php') ||
            is_page_template('page-templates/offre-contrat.php') || 
            is_page_template('page-templates/offre-remuneration.php') ||
            is_page_template('page-templates/offre-relation.php') ||
            is_page_template('page-templates/offre-separation.php') ||
            is_page_template('page-templates/formules-accompagnement.php')||
            is_page_template('page-templates/maintenance.php')
            ) {
        $classes[] = 'colored-back-page';
    }
    if (is_page_template('page-templates/essentiels-offre-v2.php') ||
            is_page_template('page-templates/offre-contrat.php') ||
            is_page_template('page-templates/offre-remuneration.php') ||
            is_page_template('page-templates/offre-relation.php') ||
            is_page_template('page-templates/offre-separation.php') ||
            is_page_template('page-templates/formules-accompagnement.php') ||
            is_page_template('page-templates/maintenance.php')
            )  {
        $classes[] = 'page-template-essentiels-offre';
    }
    if( is_category($glossaryEntries) )  {
        $classes[] = 'page-template-glossary';
    }
    if ( is_page_template('page-templates/simulateur-cesu.php') ||
            is_page_template('page-templates/volet-cesu.php') ||
            is_page_template('page-templates/cesu-10-points.php') ) {
        $classes[] = "page-cesu";
    }
    return $classes;  
}


// === déclaration des menus ===
function pe_add_menu()
{
    register_nav_menu('main_menu', 'Menu principal');
    register_nav_menu('home_pe_menu', 'Menu particulier employeur de la home page');
    register_nav_menu('home_spe_menu', 'Menu salarié du particulier employeur de la home page');
    register_nav_menu('nav_categories', 'Menu affiché dans la page magazine pour naviguer entre les catégories'); 
    register_nav_menu('nav_glossaire', 'Menu répertoire du glossaire');   
}
add_action('init', 'pe_add_menu');


// === déclaration des zones de widgets ===
function pe_add_sidebar()
{
    register_sidebar(array(
        'id' => 'article-juridique-sidebar',
        'name' => 'Zone de widgets pour les articles juridiques',
        'description' => "Apparaît à droite sur la page d'affichage d'un article juridique",
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<div>',
        'after_title' => '</div>'
    ));
    register_sidebar(array(
        'id' => 'article-magazine-sidebar',
        'name' => 'Zone de widgets 1 pour les articles magazine',
        'description' => "Apparaît à droite sur la page d'affichage d'un article magazine",
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<div>',
        'after_title' => '</div>'
    ));
     register_sidebar(array(
        'id' => 'article-magazine-sidebar2',
        'name' => 'Zone de widgets 2 pour les articles magazine',
        'description' => "Apparaît à droite sur la page d'affichage d'un article magazine",
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<div>',
        'after_title' => '</div>'
    ));
      register_sidebar(array(
        'id' => 'article-magazine-sidebar3',
        'name' => 'Zone de widgets 3 pour les articles magazine',
        'description' => "Apparaît à droite sur la page d'affichage d'un article magazine",
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<div>',
        'after_title' => '</div>'
    ));
    register_sidebar(array(
        'id' => 'article-standard-sidebar',
        'name' => 'Zone de widgets pour les articles standard',
        'description' => "Apparaît à droite sur la page d'affichage d'un article standard",
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<div>',
        'after_title' => '</div>'
    ));
    register_sidebar(array(
        'id' => 'footer-widget-1',
        'name' => 'Footer zone 1',
        'description' => "Apparaît en bas de page à gauche",
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<div class="footer-title">',
        'after_title' => '</div><div class="footer-title-separator"></div>'
    ));
    register_sidebar(array(
        'id' => 'footer-widget-2',
        'name' => 'Footer zone 2',
        'description' => "Apparaît en bas de page au milieu",
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<div class="footer-title">',
        'after_title' => '</div><div class="footer-title-separator"></div>'
    ));
    register_sidebar(array(
        'id' => 'footer-widget-3',
        'name' => 'Footer zone 3',
        'description' => "Apparaît en bas de page à droite",
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<div class="footer-title">',
        'after_title' => '</div><div class="footer-title-separator"></div>'
    ));
}
add_action('widgets_init','pe_add_sidebar');

/**
 * gestion du lien Lire la suite, [...] des extraits d'articles
 * 
 * la gestion est différente entre l'extrait manuel, la balise more et l'extrait automatique
 * le thème prend en compte l'extrait manuel 
 * 
 * @see https://codex.wordpress.org/fr:Extrait
 */
// tag [...] apparaissant lorsque l'extrait est généré automatiquement
function pe_custom_excerpt_more($more) {
   global $post;
   return '...';
}
add_filter('excerpt_more', 'pe_custom_excerpt_more');
//lien ajouté lorsque l'extrait manuel est défini
/*function excerpt_read_more_link($output) {
    global $post;
    return $output . '<a class="readmore-link" href="'. get_permalink($post->ID) . '"> Lire la suite </a>';
}
add_filter('the_excerpt', 'excerpt_read_more_link');*/

/**
 * update edit form to accept file uploads
 */
function update_edit_form() {
    echo ' enctype="multipart/form-data"';
} // end update_edit_form
add_action('post_edit_form_tag', 'update_edit_form');

//======== metabox pour les articles === (should be placed into a plugin file) ============
function pe_metabox_post_add() {
    add_meta_box( 'metabox-post-options', 'Configuration', 'pe_metabox_post_render', 'post', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'pe_metabox_post_add' );

function pe_metabox_post_render() {
    //echo 'What you put here, show\'s up in the meta box';
    
    // $post is already set, and contains an object: the WordPress post
    global $post;
    $customValues = get_post_custom( $post->ID );
    $selected = isset( $customValues['metabox_field_post_template'] ) ? esc_attr( $customValues['metabox_field_post_template'][0] ) : '';
    $setWording = isset( $customValues['metabox_field_post_wording'] ) ? esc_attr( $customValues['metabox_field_post_wording'][0] ) : '';
    // We'll use this nonce field later on when saving.
    wp_nonce_field( 'field_metabox_post_nonce', 'meta_box_nonce' );
    ?>
    <p>
        <label for="metabox_field_post_template">Modèle de l'article</label>
        <select name="metabox_field_post_template" id="metabox_field_post_template">
            <option value="article-standard" <?php selected( $selected, 'article-standard' ); ?>>Article standard</option>
            <option value="article-magazine" <?php selected( $selected, 'article-magazine' ); ?>>Article magazine</option>
            <option value="article-juridique" <?php selected( $selected, 'article-juridique' ); ?>>Article juridique</option>
        </select>
    </p>
    <p>
        <label for="metabox_field_post_wording">
            <?php _e( "widget sentence", 'particulieremploi' ); ?>
        </label>
        <input type="text" name="metabox_field_post_wording" id="metabox_field_post_wording" value="<?php echo $setWording; ?>" size="100" />
    </p>
    <?php
}
function pe_metabox_post_save($post_id) {
     // Bail if we're doing an auto save : ehe autosave function doesn’t save metadata correctly
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'field_metabox_post_nonce' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;
    
    //saving data
    if( isset( $_POST['metabox_field_post_template'] ) ) {
        update_post_meta( $post_id, 'metabox_field_post_template', esc_attr( $_POST['metabox_field_post_template'] ) );
    }
    if( isset( $_POST['metabox_field_post_wording'] ) ) {
        update_post_meta( $post_id, 'metabox_field_post_wording', esc_attr( $_POST['metabox_field_post_wording'] ) );
    }
}
add_action( 'save_post', 'pe_metabox_post_save' );

//============ custom post type point relais ==============
//enregistrement des custom post relais et contact
//enregistrement de la custom taxonomy type associée au custom post relais
function pe_custom_post_type() { 
    register_post_type(   
        'relais',  
        array(
            'label' => 'Relais',     
            'labels' => array(       
                'name' => 'Relais',       
                'singular_name' => 'Relais',       
                'all_items' => 'Tous les relais',       
                'add_new_item' => 'Ajouter un relais',       
                'edit_item' => 'Éditer le relais',       
                'new_item' => 'Nouveau relais',       
                'view_item' => 'Voir le relais',       
                'search_items' => 'Rechercher parmi les relais',      
                'not_found' => 'Pas de relais trouvé',       
                'not_found_in_trash'=> 'Pas de relais dans la corbeille'       
                ),     
            'public' => true,     
            'capability_type' => 'post',     
            'supports' => array(       
                'title',       
                'editor',       
                'thumbnail'
            ),     
            'taxonomies' => array( 'category' ),
            'has_archive' => true   
        ) 
    );
    register_post_type(   
        'contact',  
        array(
            'label' => 'Contacts',     
            'labels' => array(       
                'name' => 'Contacts',       
                'singular_name' => 'Contact',       
                'all_items' => 'Tous les contacts',       
                'add_new_item' => 'Ajouter un contact',       
                'edit_item' => 'Éditer le contact',       
                'new_item' => 'Nouveau contact',       
                'view_item' => 'Voir le contact',       
                'search_items' => 'Rechercher parmi les contacts',      
                'not_found' => 'Pas de contact trouvé',       
                'not_found_in_trash'=> 'Pas de contact dans la corbeille'       
                ),     
            'public' => true,     
            'capability_type' => 'post',     
            'supports' => array(       
                'title',       
                'editor',       
                'thumbnail'
            ),
            'taxonomies' => array( 'category' ),
            'has_archive' => true   
        ) 
    );
    register_taxonomy(   
        'type',   
        'relais',   
        array(     
            'label' => 'Types',     
            'labels' => array(     
                'name' => 'Types',     
                'singular_name' => 'Type',     
                'all_items' => 'Tous les types',     
                'edit_item' => 'Éditer le type',     
                'view_item' => 'Voir le type',     
                'update_item' => 'Mettre à jour le type',     
                'add_new_item' => 'Ajouter un type',     
                'new_item_name' => 'Nouveau type',     
                'search_items' => 'Rechercher parmi les types',     
                'popular_items' => 'Types les plus utilisées'   ),   
            'hierarchical' => true   ) ); 
    register_taxonomy_for_object_type( 'type', 'relais' );
}
add_action('init', 'pe_custom_post_type'); 

//////options du custom post relais
function pe_metabox_postrelais_add() {
    add_meta_box( 'metabox-relais-options', 'Informations du relais', 'pe_metabox_postrelais_render', 'relais', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'pe_metabox_postrelais_add' );

function pe_metabox_postrelais_render( $post ) { 
    $customValues = get_post_meta( $post->ID );
    //already set values
    $setAddress=isset( $customValues['relais-post-address'] ) ? esc_attr( $customValues['relais-post-address'][0]  ) : '';
    $setHoraireAccueil=isset( $customValues['relais-post-accueil'] ) ? esc_attr( $customValues['relais-post-accueil'][0]  ) : '';
    $setEmail=isset( $customValues['relais-post-email'] ) ? esc_attr( $customValues['relais-post-email'][0]  ) : '';
    $setTel=isset( $customValues['relais-post-tel'] ) ? esc_attr( $customValues['relais-post-tel'][0]  ) : '';
    $setHoraireTel=isset( $customValues['relais-post-horaire-tel'] ) ? esc_attr( $customValues['relais-post-horaire-tel'][0]  ) : '';
    $setVille=isset( $customValues['relais-post-ville'] ) ? esc_attr( $customValues['relais-post-ville'][0]  ) : '';
    //$contactImg=isset( $customValues['relais-post-contact-img'] ) ? esc_attr( $customValues['relais-post-contact-img'][0]  ) : '';
    $setLatitude=isset( $customValues['relais-post-latitude'] ) ? esc_attr( $customValues['relais-post-latitude'][0]  ) : '';
    $setLongitude=isset( $customValues['relais-post-longitude'] ) ? esc_attr( $customValues['relais-post-longitude'][0]  ) : '';
    wp_nonce_field( 'field_relais_metabox_nonce', 'relais_metabox_nonce' ); 
    ?>

    <div>
        <label for="relais-post-address">
            <?php _e( "relais address", 'particulieremploi' ); ?>
        </label>
        <input type="text" name="relais-post-address" id="relais-post-address" value="<?php echo $setAddress; ?>" size="100" />
    </div>
    <div>
        <label for="relais-post-accueil">
            <?php _e( "relais accueil", 'particulieremploi' ); ?>
        </label>
        <textarea name="relais-post-accueil" id="relais-post-accueil" rows="2" cols="100" ><?php echo $setHoraireAccueil; ?></textarea>
    </div>
    <div>
        <label for="relais-post-email">
            <?php _e( "relais email", 'particulieremploi' ); ?>
        </label>
        <input type="text" name="relais-post-email" id="relais-post-email" value="<?php echo $setEmail; ?>" size="50" />
    </div>
    <div>
        <label for="relais-post-tel">
            <?php _e( "relais telephone", 'particulieremploi' ); ?>
        </label>
        <input type="text" name="relais-post-tel" id="relais-post-tel" value="<?php echo $setTel; ?>" size="50"/>
    </div>
    <div>
        <label for="relais-post-horaire-tel">
            <?php _e( "relais accueil telephone", 'particulieremploi' ); ?>
        </label>
        <textarea name="relais-post-horaire-tel" id="relais-post-horaire-tel" rows="2" cols="100" ><?php echo $setHoraireTel; ?></textarea>
    </div>
    <div>
        <label for="relais-post-ville">
            <?php _e( "relais city", 'particulieremploi' ); ?>
        </label>
        <input type="text" name="relais-post-ville" id="relais-post-ville" value="<?php echo $setVille; ?>" size="50"/>
    </div>
    <div>
        <label for="relais-post-latitude">
            <?php _e( "relais latitude", 'particulieremploi' ); ?>
        </label>
        <input type="text" name="relais-post-latitude" id="relais-post-latitude" value="<?php echo $setLatitude; ?>" size="20" />
    </div>
    <div>
        <label for="relais-post-longitude">
            <?php _e( "relais longitude", 'particulieremploi' ); ?>
        </label>
        <input type="text" name="relais-post-longitude" id="relais-post-longitude" value="<?php echo $setLongitude; ?>" size="20" />
    </div>
    <!--<div>
        <label for="relais-post-contact-img" class="">Image du contact</label>
        <input type="text" name="relais-post-contact-img" id="relais-post-contact-img" value="<?php echo $contactImg ; ?>" />
        <input type="button" id="meta-image-button" class="" value="Ajouter une image" />
    </div>-->
    <?php 
}

function pe_metabox_postrelais_save($post_id) {
    // Bail if we're doing an auto save : the autosave function doesn’t save metadata correctly
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    
    // Verify the nonce before proceeding. 
    if ( !isset( $_POST['relais_metabox_nonce'] ) || !wp_verify_nonce( $_POST['relais_metabox_nonce'], 'field_relais_metabox_nonce' ) )
        return;
    
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;
    
    
    //save address
    if( isset( $_POST['relais-post-address'] ) ) {
        update_post_meta( $post_id, 'relais-post-address', esc_attr( $_POST['relais-post-address'] ) );
    } else {
        delete_post_meta( $post_id, 'relais-post-address', $_POST['relais-post-address'] );
    }
    //save accueil
    if( isset( $_POST['relais-post-accueil'] ) ) {
        update_post_meta( $post_id, 'relais-post-accueil', esc_attr( $_POST['relais-post-accueil'] ) );
    } else {
        delete_post_meta( $post_id, 'relais-post-accueil', $_POST['relais-post-accueil'] );
    }
    //save email
    if( isset( $_POST['relais-post-email'] ) ) {
        update_post_meta( $post_id, 'relais-post-email', esc_attr($_POST['relais-post-email'])  );
    } else {
        delete_post_meta( $post_id, 'relais-post-email', esc_attr($_POST['relais-post-email']) );
    }
    //save tel
    if( isset( $_POST['relais-post-tel'] ) ) {
        update_post_meta( $post_id, 'relais-post-tel', esc_attr($_POST['relais-post-tel'])  );
    } else {
        delete_post_meta( $post_id, 'relais-post-tel', esc_attr($_POST['relais-post-tel']) );
    }
    //save horaire tel
    if( isset( $_POST['relais-post-horaire-tel'] ) ) {
        update_post_meta( $post_id, 'relais-post-horaire-tel', esc_attr($_POST['relais-post-horaire-tel'])  );
    } else {
        delete_post_meta( $post_id, 'relais-post-horaire-tel', esc_attr($_POST['relais-post-horaire-tel']) );
    }
    //save ville
    if( isset( $_POST['relais-post-ville'] ) ) {
        update_post_meta( $post_id, 'relais-post-ville', esc_attr($_POST['relais-post-ville'])  );
    } else {
        delete_post_meta( $post_id, 'relais-post-villel', esc_attr($_POST['relais-post-ville']) );
    }
    //save latitude
    if( isset( $_POST['relais-post-latitude'] ) ) {
        update_post_meta( $post_id, 'relais-post-latitude', esc_attr($_POST['relais-post-latitude'])  );
    } else {
        delete_post_meta( $post_id, 'relais-post-latitude', esc_attr($_POST['relais-post-latitude']) );
    }
    //save longitude
    if( isset( $_POST['relais-post-longitude'] ) ) {
        update_post_meta( $post_id, 'relais-post-longitude', esc_attr($_POST['relais-post-longitude'])  );
    } else {
        delete_post_meta( $post_id, 'relais-post-longitude', esc_attr($_POST['relais-post-longitude']) );
    }
    // Checks for input and saves if needed
    /*if( isset( $_POST[ 'relais-post-contact-img' ] ) ) {
        update_post_meta( $post_id, 'relais-post-contact-img', $_POST[ 'relais-post-contact-img' ] );
    }*/
}
add_action( 'save_post', 'pe_metabox_postrelais_save' );

/////options du custom post contact
function pe_metabox_postcontact_add() {
    add_meta_box( 'metabox-contact-options', 'Informations du contact', 'pe_metabox_postcontact_render', 'contact', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'pe_metabox_postcontact_add' );

function pe_metabox_postcontact_render( $post ) { 
    $customValues = get_post_meta( $post->ID );
    //already set values
    $setName=isset( $customValues['contact-post-name'] ) ? esc_attr( $customValues['contact-post-name'][0]  ) : '';
    $setVille=isset( $customValues['contact-post-ville'] ) ? esc_attr( $customValues['contact-post-ville'][0]  ) : '';
    wp_nonce_field( 'field_contact_metabox_nonce', 'contact_metabox_nonce' ); 
    ?>

    <div>
        <label for="contact-post-name">
            <?php _e( "contact name", 'particulieremploi' ); ?>
        </label>
        <input type="text" name="contact-post-name" id="contact-post-name" value="<?php echo $setName; ?>" size="50" />
    </div>
    <div>
        <label for="contact-post-ville">
            <?php _e( "contact city", 'particulieremploi' ); ?>
        </label>
        <input type="text" name="contact-post-ville" id="contact-post-ville" value="<?php echo $setVille; ?>" size="50" />
    </div>
    <?php
}

function pe_metabox_postcontact_save($post_id) {
    // Bail if we're doing an auto save : the autosave function doesn’t save metadata correctly
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    
    // Verify the nonce before proceeding. 
    if ( !isset( $_POST['contact_metabox_nonce'] ) || !wp_verify_nonce( $_POST['contact_metabox_nonce'], 'field_contact_metabox_nonce' ) )
        return;
    
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;
    
    
    //save contact name
    if( isset( $_POST['contact-post-name'] ) ) {
        update_post_meta( $post_id, 'contact-post-name', esc_attr( $_POST['contact-post-name'] ) );
    } else {
        delete_post_meta( $post_id, 'contact-post-name', $_POST['contact-post-name'] );
    }
    //save contact ville
    if( isset( $_POST['contact-post-ville'] ) ) {
        update_post_meta( $post_id, 'contact-post-ville', esc_attr( $_POST['contact-post-ville'] ) );
    } else {
        delete_post_meta( $post_id, 'contact-post-ville', $_POST['contact-post-ville'] );
    }
}
add_action( 'save_post', 'pe_metabox_postcontact_save' );

//===== image responsive ====
function pe_images( $html ) { 
    $html = preg_replace( '/(width|height)="\d*"\s/', "", $html ); 
    return $html; 
} 
add_filter( 'post_thumbnail_html', 'pe_images', 10 ); 
add_filter( 'image_send_to_editor', 'pe_images', 10 ); 
add_filter( 'wp_get_attachment_link', 'pe_images', 10 );

//====== category page  ====
//ignore the sticky => useless because Sticky posts 
//only show on top of the home page
/*function custom_loop_category( $query ) {
    if ( $query->is_category() && $query->is_main_query() ) {
        $query->set( 'ignore_sticky_posts', '1' );     
    }
}
add_action( 'pre_get_posts', 'custom_loop_category' );*/

//======= configuration du widget Nuage de mots-clefs inclus dans WP =====
//suppression affichage du titre en front 
function custom_widget_title($title='', $instance='', $base='') {
    if ( $base == 'tag_cloud' ) {
        if ( strtolower($title)=='pas de titre' ) {
            $title='';
        } 
    }
    return $title;
}
add_filter('widget_title', 'custom_widget_title', 10, 3);
//configuration de certaines options du widget
function custom_tag_cloud($args) {
    $args['unit'] = 'em';
    $args['smallest'] = 1;
    $args['largest'] = 1;
    $args['order'] = 'RAND';
    $args['format'] = 'flat';
    return $args;
}
add_filter('widget_tag_cloud_args', 'custom_tag_cloud');

//========== ajout de la prise en compte du sticky pour les CPT=====
add_action( 'admin_footer-post.php', 'pe_add_sticky_post_support' );
add_action( 'admin_footer-post-new.php', 'pe_add_sticky_post_support' );
function pe_add_sticky_post_support() 
{ 
    global $post, $typenow; ?>
	
	<?php 
        if ( $typenow == 'relais' && current_user_can( 'edit_others_posts' ) ) : ?>
	<script>
	jQuery(function($) {
		var sticky = "<br/><span id='sticky-span'><input id='sticky' name='sticky' type='checkbox' value='sticky' <?php checked( is_sticky( $post->ID ) ); ?> /> <label for='sticky' class='selectit'><?php _e( "Stick this relais to the page", 'particulieremploi' ); ?></label><br /></span>";	
		$('[for=visibility-radio-public]').append(sticky);	
	});
	</script>
	<?php 
        endif; 
}
//============== modification boucle principale ================
function pe_pregetposts( $query ) {
    global $glossaryEntries;
    if ( ! is_admin() && $query->is_main_query() && is_category($glossaryEntries)) {
        $query->set( 'orderby', 'title' );
        $query->set( 'order', 'ASC' );
    }
}
add_action( 'pre_get_posts', 'pe_pregetposts', 1 );

//===== réécriture pour les carte des relais ============
function pe_add_rewrite_carte() {
  global $wp_rewrite;
  add_rewrite_tag('%cregion%','([^&]+)');
  $wp_rewrite->add_rule('carte-des-relais-par-region/([^/]+)','index.php?pagename=carte-des-relais-par-region&cregion=$matches[1]','top');

  $wp_rewrite->flush_rules();
}
add_action('init', 'pe_add_rewrite_carte');

//Fonctions diverses
require get_template_directory() . '/inc/usefull-functions.php';
