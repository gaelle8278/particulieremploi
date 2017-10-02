<?php

/**
 * Page de fonctionnementde la messagerie
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
/**
 * Constantes
 */
require( dirname(dirname(dirname(__FILE__))).'/config/constants.php' );
/**
 * Fonctions
 */
require( dirname(dirname(dirname(__FILE__))).'/config/functions.php' );
/**
 * Fonctions de Wordpress
 */
require( dirname(dirname(dirname(dirname(__FILE__)))).'/wp-load.php' );

session_start();

if (isset($_GET) && !empty($_GET)) {
    $options = array(
        'page' => FILTER_SANITIZE_NUMBER_INT
    );
    $params = filter_input_array(INPUT_GET, $options);
}

if(!isset($_SESSION['utilisateur_groupe']) || empty($_SESSION['utilisateur_groupe']) ) {
    header('Location: /index.php');
    exit();
}

global $wpdb;

if(isset($params['page'])) {
    $page=$params['page'];
} else {
    $page=1;
}

// affichage
$meta['title']="Fonctionnement messagerie | Particulier Emploi";
$meta['desc']="Fonctionnement de la messagerie de l'espace de mise en relation de Particulier Emploi, le site de l'emploi à domicile ";
$pageActive="messagerie";
$subPageActive = "fmessagerie";
include_once(dirname(dirname(__FILE__)).'/templates/header-espacepe.php');
include_once(dirname(dirname(__FILE__)).'/templates/fonctionnement-messagerie.php');
include_once(dirname(dirname(dirname(__FILE__))).'/common-templates/footer.php');
