<?php

/**
 * Fichier index de l'esapce perso
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

$idUtilisateur = $_SESSION['utilisateur_id'];
$type_compte= strtoupper($_SESSION['utilisateur_groupe']);

global $wpdb;
//mise à jour des annonces trop vieilles
$date_peremption = diffdate('month','-',3); 
$nb_annonces = $wpdb->get_var( "SELECT COUNT(*) FROM ".TBL_ANNONCES." "
        . "WHERE annonce_dateprisefonction <= '$date_peremption' "
        . "AND annonce_idauteur = '$idutilisateur'" 
        . "AND annonce_etat <> 'PERIME' AND annonce_etat <> 'SUPPRIME' AND annonce_etat <> 'INS'"
        );
if($nb_annonces != 0) { 
    // TODO : faire mise à jour des annonces
    //header('Location:/pe/espace-pe/miseajour.php');
    //exit();
}
$meta['title']="Accueil espace de mise en relation | Particulier Emploi";
$meta['desc']="Accueil espace de mise en relation de Particulier Emploi, le site de l'emploi à domicile ";
$pageActive = "compte";
include_once(dirname(__FILE__).'/templates/header-espacepe.php');
include_once(dirname(__FILE__).'/templates/compte.php');
//inclusion formulaire de recherche
include_once(dirname(dirname(__FILE__)).'/recherche/templates/form-espacepe.php');
include_once(dirname(dirname(__FILE__)).'/common-templates/footer.php');
