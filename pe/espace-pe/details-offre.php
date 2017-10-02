<?php

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

//récupération des paramètres
if(isset($_GET) && !empty($_GET)) {
    $options = array(
        'id' => FILTER_SANITIZE_NUMBER_INT
    );
    $validateDataInput = filter_input_array(INPUT_GET, $options);
}

global $wpdb;

//si l'utilisateur est connecté => interface message dans l'espace perso
if(isset($_SESSION['utilisateur_id']) && !empty($_SESSION['utilisateur_id']) &&  $_SESSION['utilisateur_groupe']=="SAL") {
    
    //on met l'annonce en favori et on redirige vers l'affichage de l'annonce
    if(!empty($validateDataInput['id'])) {
	
	//vérification que l'annonce choisie n'est pas déjà dans la sélection
	$verifSelectionAnnonce="select 
                                maselection_annonceid 
                                from ".TBL_FAVORIS."
		                WHERE maselection_utilisateurid = ".$_SESSION['utilisateur_id']."
		                AND maselection_annonceid = ".$validateDataInput['id'];
        $resultatselection = $wpdb->get_results($verifSelectionAnnonce);
	$resultatselec=$wpdb->num_rows;
	
	//ajout de l'annonce dans la sélection si elle n'est pas déjà présente
	if(empty($resultatselec))
	{
            $wpdb->insert(
                TBL_FAVORIS,
                array(
                    'maselection_utilisateurid'=> $_SESSION['utilisateur_id'],
                    'maselection_annonceid' => $validateDataInput['id'],
                    'maselection_datecrea' => current_time('mysql', 1)
                ),
                array(
                    '%d',
                    '%d',
                    '%s'
                )
                
            );
	}
        
	//redirection vers section l'écriture d'un message
	$urlRedirect='/pe/espace-pe/favoris.php?annonceid='.$validateDataInput['id'].'&part=affiche-annonce';
        header('Location: '.$urlRedirect);
        exit();
    }
} else {
    //on déconnecte si connecté en tant qu'employeur 
    $_SESSION = array();
    session_destroy();
    
    //page spécifique pour inciter à s'inscrire/à se connecter
    $classes= "class='colored-back-page'";
    $title="Accès offre ParticulierEmploi";
    include_once(dirname(__FILE__).'/templates/header-connespacepe.php');
    include_once(dirname(dirname(__FILE__)).'/recherche/templates/results-details-offre.php');
    get_template_part("logos-partenaires");
    include_once(dirname(dirname(__FILE__)).'/common-templates/footer.php');
}
