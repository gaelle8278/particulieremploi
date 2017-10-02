<?php

/**
 * Page d'accueil de la messagerie
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
        'envoye' => FILTER_SANITIZE_NUMBER_INT,
        'type_message' => FILTER_SANITIZE_STRING,
        'sous_type_msg' => FILTER_SANITIZE_STRING,
        'page' =>  FILTER_SANITIZE_NUMBER_INT,
        'msginfo' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
    $params = filter_input_array(INPUT_GET, $options);
}
//echo "<pre>";print_r($params);echo "</pre>";
//vérification que l'utilisateur est toujours connecté
if(!isset($_SESSION['utilisateur_groupe']) || empty($_SESSION['utilisateur_groupe']) ) {
    header('Location: /index.php');
    exit();
}
$idUtilisateur = $_SESSION['utilisateur_id'];

global $wpdb;

//// pagination
// page en cours d'affichage
$page = (!empty($params['page']) ? ($params['page'] > 0 ? $params['page']: 1) : 1);
// nombre de résultat pas page 
$limite = 10;
// calcul du premier élément à récupérer pour la page en cours
$debut = ($page - 1) * $limite;

//// message après envoi d'un message
$messageEnv=$params['envoye'];


//// récupération des messages à afficher
if($params['type_message']==STATE_BDD_ENV ) {
    $subPageActive="envoye";
    
    if(empty($params['sous_type_msg'])) {
        //message que l'utilisateur a envoyé 
        //(=dont il est expéditeur au statut envoyé)
        $queryRecupMsg="select SQL_CALC_FOUND_ROWS message_id as id,"
            . "message_objet as objet, "
            . "message_contenu as contenu,"
            . "message_datecrea as date_envoi, "
            . "utilisateur_prenom as prenom_dest, "
            . "utilisateur_nom as nom_dest "
            . "from ".TBL_MESSAGES.", "
            . TBL_UTILISATEURS.", "
            . TBL_MSG_EXP." "
            . " where exp_mess_id_membre=".$idUtilisateur." "
            . " and exp_mess_etat_gestion='".STATE_BDD_ENV."' "
            . " and exp_mess_id_mess=message_id "
            . " and message_dest=utilisateur_id "
            . " order by message_datecrea desc limit ".$limite." offset ".$debut;
        
    } elseif ($params['sous_type_msg'] == STATE_BDD_ARCH || 
            $params['sous_type_msg'] == STATE_BDD_SUPPR) {
        
        //message que l'utilisateur a envoyé et archivé ou supprimé
        //(=message dont il est expéditeur au statut archive ou supprime)
        $queryRecupMsg="select SQL_CALC_FOUND_ROWS message_id as id,"
            . "message_objet as objet, "
            . "message_contenu as contenu,"
            . "message_datecrea as date_envoi, "
            . "utilisateur_prenom as prenom_dest, "
            . "utilisateur_nom as nom_dest "
            . "from ".TBL_MESSAGES.", "
            . TBL_UTILISATEURS.", "
            . TBL_MSG_EXP." "
            . " where exp_mess_id_membre=".$idUtilisateur." "
            . " and exp_mess_etat_gestion='".$params['sous_type_msg']."' "
            . " and exp_mess_id_mess=message_id "
            . " and message_dest=utilisateur_id "
            . " order by message_datecrea desc limit ".$limite." offset ".$debut;
        
    }
    
    $tabMsg=$wpdb->get_results($queryRecupMsg, ARRAY_A);
     //pour la pagination
    $nbrMsgTotal=$wpdb->get_var("SELECT found_rows()");
    $nombreDePages = ceil($nbrMsgTotal / $limite);
    
} elseif ($params['type_message']==STATE_BDD_ARCH ||
          $params['type_message']==STATE_BDD_SUPPR ||
          $params['type_message']==STATE_BDD_SPAM) {

    if($params['type_message']==STATE_BDD_ARCH) {
        $subPageActive="archive";
    } elseif ($params['type_message']==STATE_BDD_SUPPR) {
        $subPageActive="supprime";
    } elseif ($params['type_message']==STATE_BDD_SPAM) {
        $subPageActive="spam";
    }
    
    //message que l'utilisateur a recu et qu'il a archivé ou supprimé ou mis en indésirables
    $queryRecupMsg="select SQL_CALC_FOUND_ROWS message_id as id,"
            . "message_objet as objet, "
            . "message_contenu as contenu,"
            . "message_datecrea as date_envoi, "
            . "utilisateur_prenom as prenom_exp, "
            . "utilisateur_nom as nom_exp, "
            . "dest_mess_etat_lecture as etat "
            . "from ".TBL_MESSAGES.", "
            . TBL_UTILISATEURS.", "
            . TBL_MSG_DEST." "
            . " where dest_mess_id_membre=".$idUtilisateur." "
            . " and dest_mess_etat_gestion='".$params['type_message']."' "
            . " and dest_mess_id_mess=message_id "
            . " and message_exp=utilisateur_id"
            . " order by message_datecrea desc limit ".$limite." offset ".$debut;
    
    $tabMsg=$wpdb->get_results($queryRecupMsg, ARRAY_A);
    //pour la pagination
    $nbrMsgTotal=$wpdb->get_var("SELECT found_rows()");
    $nombreDePages = ceil($nbrMsgTotal / $limite);
    
} elseif ( $params['type_message'] == STATE_USER_BLOQUE) {
    $subPageActive="user-blocked";
    $queryRecupUserBlocked="Select SQL_CALC_FOUND_ROWS "
        . "utilisateur_id_bloque, "
        . "utilisateur_prenom, "
        . "utilisateur_nom, "
        . "utilisateur_bloque_date "
        . "from ".TBL_UTILISATEURS_BLOQUES.", "
        . TBL_UTILISATEURS." "
        . "where utilisateur_id_bloquant=".$idUtilisateur." "
        . "and utilisateur_id_bloque=utilisateur_id "
        . "order by utilisateur_bloque_date desc limit ".$limite." offset ".$debut;
    $tabUserBlocked   = $wpdb->get_results($queryRecupUserBlocked, ARRAY_A);
    //pour la pagination
    $nbrMsgTotal=$wpdb->get_var("SELECT found_rows()");
    $nombreDePages = ceil($nbrMsgTotal / $limite);

} else {
    $subPageActive="reception";
    
    //message que l'utilisateur a recu 
    //(=dont il est destinataire à l'état reçu)
    $queryRecupMsg="select SQL_CALC_FOUND_ROWS message_id as id,"
            . "message_objet as objet, "
            . "message_contenu as contenu,"
            . "message_datecrea as date_envoi, "
            . "utilisateur_prenom as prenom_exp, "
            . "utilisateur_nom as nom_exp,"
            . "dest_mess_etat_lecture as etat "
            . "from ".TBL_MESSAGES.", "
            . TBL_UTILISATEURS.", "
            . TBL_MSG_DEST." "
            . " where dest_mess_id_membre=".$idUtilisateur." "
            . " and dest_mess_etat_gestion='".STATE_BDD_RECU."' "
            . " and dest_mess_id_mess=message_id "
            . " and message_exp=utilisateur_id"
            . " order by message_datecrea desc limit ".$limite." offset ".$debut;
    
    $tabMsg=$wpdb->get_results($queryRecupMsg, ARRAY_A);
    
    //pour la pagination
    $nbrMsgTotal=$wpdb->get_var("SELECT found_rows()");
    $nombreDePages = ceil($nbrMsgTotal / $limite);
    
}
//quota : le nombre de messages envoyé par un employeur est vérifié
$nbMsg=0;
if($_SESSION['utilisateur_groupe']=='EMP') {
    $date=$now=date('Y-m-d');
    $queryCheckNbMsg= "select message_id from ".TBL_MESSAGES." where message_exp=".$idUtilisateur." and "
            . "DATE_FORMAT(message_datecrea, '%Y-%m-%d') = '".$date."'";
    $wpdb->get_results($queryCheckNbMsg);
    $nbMsg=$wpdb->num_rows;
}

// affichage
$meta['title']="Accueil messagerie | Particulier Emploi";
$meta['desc']="Accueil messagerie de l'espace de mise en relation de Particulier Emploi, le site de l'emploi à domicile ";
$pageActive = "messagerie";
include_once(dirname(dirname(__FILE__)).'/templates/header-espacepe.php');
include_once(dirname(dirname(__FILE__)).'/templates/messagerie.php');
include_once(dirname(dirname(dirname(__FILE__))).'/common-templates/footer.php');


