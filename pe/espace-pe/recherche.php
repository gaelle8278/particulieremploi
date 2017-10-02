<?php

/**
 * Module de recherche de l'espace perso pe
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

if(!isset($_SESSION['utilisateur_groupe']) || empty($_SESSION['utilisateur_groupe']) ) {
    header('Location: /index.php');
    exit();
}

//récupération des paramètres du formulaire
if (isset($_POST) && !empty($_POST)) {
    $options = array(
        'type_annonce' => FILTER_SANITIZE_STRING,
        'metier' => FILTER_SANITIZE_NUMBER_INT,
        'codep' => FILTER_SANITIZE_NUMBER_INT,
        'distance' => FILTER_SANITIZE_NUMBER_INT,
        'datepf' => FILTER_SANITIZE_STRING,
        'dureehebdomin' => FILTER_SANITIZE_NUMBER_INT,
        'dureehebdomax' => FILTER_SANITIZE_NUMBER_INT,
        'tauxh' => FILTER_SANITIZE_NUMBER_INT,
        'carte' => array( 'filter' => FILTER_VALIDATE_BOOLEAN )
    );
    $params = filter_input_array(INPUT_POST, $options);
}


global $wpdb;

$meta['title']="Recherche | Particulier Emploi";
$meta['desc']="Recherche de l'espace de mise en relation de Particulier Emploi, le site de l'emploi à domicile ";
$pageActive = "recherche";
include_once(dirname(__FILE__).'/templates/header-espacepe.php');
//inclusion du formulaire de recherche
include_once(dirname(dirname(__FILE__)).'/recherche/templates/form-espacepe.php');
//inclusion des résultats
if(!empty($params)) {
    include_once(dirname(dirname(__FILE__)).'/recherche/templates/results.php');
}
include_once(dirname(dirname(__FILE__)).'/common-templates/footer.php');