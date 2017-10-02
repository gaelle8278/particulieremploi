<?php

/**
 * Gestion de l'interface de lecture d'un message
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
        'idmsg' => FILTER_SANITIZE_NUMBER_INT,
        'type_message' => FILTER_SANITIZE_STRING,
        'sous_type_msg' => FILTER_SANITIZE_STRING
    );
    $params = filter_input_array(INPUT_GET, $options);
} 

if(!isset($_SESSION['utilisateur_groupe']) || empty($_SESSION['utilisateur_groupe']) ) {
    header('Location: /index.php');
    exit();
}

$idUtilisateur = $_SESSION['utilisateur_id'];

global $wpdb;

// si message envoyé
if($params['type_message'] == STATE_BDD_ENV) {
    $queryRecupMsg= "select "
                . "message_objet as objet, "
                . "message_contenu as contenu, "
                . "message_datecrea as date_envoi, "
                . "utilisateur_prenom as prenom_dest, "
                . "utilisateur_nom as nom_dest "
                . "from ".TBL_MESSAGES.", "
                . TBL_UTILISATEURS.", "
                . TBL_MSG_EXP." "
                . " where exp_mess_id_membre =".$idUtilisateur." "
                . " and exp_mess_id_mess=message_id  "
                . " and message_id=".$params['idmsg']." "
                . " and message_dest=utilisateur_id";
} 
//si message reçu
else {
    //passage du message de nonlu à lu
    $wpdb->update(
                    TBL_MSG_DEST,
                    array(
                        'dest_mess_etat_lecture'=> MSG_STATE_LU
                    ),
                    array(
                        'dest_mess_id_membre' => $idUtilisateur,
                        'dest_mess_id_mess' => $params['idmsg']
                    ),
                    array(
                        '%s'
                    ),
                    array(
                        '%d',
                        '%d'
                    )
                );
    //récupération des infos du messages
    $queryRecupMsg= "select "
                . "message_objet as objet, "
                . "message_contenu as contenu,"
                . "message_datecrea as date_envoi,"
                . "utilisateur_id as id_exp, "
                . "utilisateur_prenom as prenom_exp, "
                . "utilisateur_nom as nom_exp "
                . "from ".TBL_MESSAGES.", "
                . TBL_UTILISATEURS.", "
                . TBL_MSG_DEST." "
                . " where  dest_mess_id_membre =".$idUtilisateur." "
                . " and dest_mess_id_mess=message_id  "
                . " and message_id=".$params['idmsg']." "
                . " and message_exp=utilisateur_id";
}
$msg=$wpdb->get_row($queryRecupMsg,ARRAY_A);

//quota : le nombre de messages envoyé par un employeur est vérifié
$nbMsg=0;
if($_SESSION['utilisateur_groupe']=='EMP') {
    $date=$now=date('Y-m-d');
    $queryCheckNbMsg= "select message_id from ".TBL_MESSAGES." where message_exp=".$idUtilisateur." and "
                . "DATE_FORMAT(message_datecrea, '%Y-%m-%d') = '".$date."'";
    $wpdb->get_results($queryCheckNbMsg);
    $nbMsg=$wpdb->num_rows;
}
$meta['title']="Lecture message | Particulier Emploi";
$meta['desc']="Lecture message depuis la messagerie de l'espace de mise en relation de Particulier Emploi, le site de l'emploi à domicile ";
$pageActive = "messagerie";
include_once(dirname(dirname(__FILE__)).'/templates/header-espacepe.php');
include_once(dirname(dirname(__FILE__)).'/templates/lire.php');
include_once(dirname(dirname(dirname(__FILE__))).'/common-templates/footer.php');
