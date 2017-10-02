<?php
/**
 * Gestion de la recherche d'annonce
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

/**
 * Constantes
 */
require( dirname(dirname(__FILE__)).'/config/constants.php' );
/**
 * Fonctions
 */
require( dirname(dirname(__FILE__)).'/config/functions.php' );
/**
 * Fonctions de Wordpress
 */
require( dirname(dirname(dirname(__FILE__))).'/wp-load.php' );

session_start();

////// récupération des paramètres du formulaire
if (isset($_POST) && !empty($_POST)) {
    $options = array(
        'type_annonce' => FILTER_SANITIZE_STRING,
        'metier' => FILTER_SANITIZE_NUMBER_INT,
        'codep' => FILTER_SANITIZE_NUMBER_INT,
        'distance' => FILTER_SANITIZE_NUMBER_INT
    );
    $params = filter_input_array(INPUT_POST, $options);
}
// formulaire soumis par site partenaire ne transmets pas le type d'annonce
// en effet dans la V1 de pe.fr seules les annonces salariés pouvaient être recherchées
if(empty($params['type_annonce'])) {
    $params['type_annonce']="sal";
}

//si l'utilisateur est connecté => redirection vers la recherche de l'espace perso
// pour éviter de le faire rentrer dans le parcours d'inscription par la suite
if( isset($_SESSION['utilisateur_id']) ){
    $urlRedirect = "/pe/espace-pe/recherche.php?metier=".$params['metier']."&codep=".$params['codep'];
    if(!empty($params['distance'])) {        
        $urlRedirect .= "&distance=".$params['distance'];
    }
    header('Location: '.$urlRedirect);
    exit();
}

global $wpdb;

//affichage
include_once(dirname(__FILE__).'/templates/header-recherche.php');
//inclusion des résultats
include_once(dirname(__FILE__).'/templates/results.php');
get_template_part("logos-partenaires");
get_footer();
