<?php

/**
 * Gestion de l'interface d'envoi de messages
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
        'id_dest_msg' => FILTER_SANITIZE_NUMBER_INT
    );
    $params = filter_input_array(INPUT_GET, $options);
} 
elseif (isset($_POST) && !empty($_POST)) {
    $options = array(
        'id_dest_msg' => FILTER_SANITIZE_NUMBER_INT,
        'objetmessage' => FILTER_SANITIZE_STRING,
        'contenumsg' => FILTER_SANITIZE_STRING,
        'envoyer' =>  FILTER_SANITIZE_STRING
    );
    $params = filter_input_array(INPUT_POST, $options);
}

if(!isset($_SESSION['utilisateur_groupe']) || empty($_SESSION['utilisateur_groupe']) ) {
    header('Location: /index.php');
    exit();
}

global $wpdb;

$idUtilisateur = $_SESSION['utilisateur_id'];

//recherche du nom et de l'email du destinataire
if(!empty($params['id_dest_msg'])) {
    $queryDestName= "select utilisateur_prenom, utilisateur_nom, utilisateur_mail "
            . "from ".TBL_UTILISATEURS." "
            . "where utilisateur_id=".$params['id_dest_msg']." AND utilisateur_etat='ACT'";
    $infosDest=$wpdb->get_row($queryDestName);
    $params['name_dest_msg']="";
    if(!empty($infosDest)) {
        $params['name_dest_msg']=ucfirst(strtolower($infosDest->utilisateur_nom))." ".ucfirst(strtolower($infosDest->utilisateur_prenom));
    }
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

//si le formulaire d'envoi est soumis, que le quota n'est pas dépassé et que le destinataire est renseigné
if(isset($params['envoyer']) && $nbMsg <= 10 && !empty($params['id_dest_msg']) && !empty($infosDest->utilisateur_mail)) {
    $send=true;
    $destStateMsg=STATE_BDD_RECU;
    //vérification si le destinataire a bloqué l'expéditeur
    $queryCheckStatutExp="select utilisateur_bloque_etat as etat "
            . "from ".TBL_UTILISATEURS_BLOQUES." "
            . "where utilisateur_id_bloquant=".$params['id_dest_msg']." "
            . "and utilisateur_id_bloque=".$idUtilisateur;
    //echo "<pre>";print_r($queryCheckStatutExp);echo "</pre>";
    $checkStatutExp=$wpdb->get_row($queryCheckStatutExp, ARRAY_A);
    if($checkStatutExp) {
        if($checkStatutExp['etat']==STATE_USER_BLOQUE) {
            $send=false;
        } elseif($checkStatutExp['etat']==STATE_USER_SPAM) {
            $destStateMsg=STATE_BDD_SPAM;
        }
    }
    if($send==true) {
        //enregistrement du message
        $insertMsg = $wpdb->insert(
                TBL_MESSAGES,
                array(
                    'message_objet' => $params['objetmessage'],
                    'message_contenu' => $params['contenumsg'],
                    'message_dest' => $params['id_dest_msg'],
                    'message_exp' => $idUtilisateur,
                    'message_datecrea' => current_time('mysql', 1)
                ),
                array(
                    '%s',
                    '%s',
                    '%d',
                    '%d',
                    '%s'
                )
            );
        $idMsg=$wpdb->insert_id;
        // si le message a bien été enregistré création des copies
        // pour la gestion indépendante du message par le destinataire
        // et l'expéditeur
        if (!empty($idMsg)) {
            //enregistrement pour le destinataire
            $insertDest= $wpdb->insert(
                TBL_MSG_DEST,
                    array(
                    'dest_mess_id_mess' => $idMsg,
                    'dest_mess_id_membre' => $params['id_dest_msg'],
                    'dest_mess_etat_lecture' => 'nonlu',
                    'dest_mess_etat_gestion' => $destStateMsg
                ),
                array(
                    '%d',
                    '%d',
                    '%s',
                    '%s'
                )
            );
            //enregistrement pour l'expéditeur
            $insertExp=$wpdb->insert(
                 TBL_MSG_EXP,
                     array(
                     'exp_mess_id_mess' => $idMsg,
                     'exp_mess_id_membre' => $idUtilisateur,
                     'exp_mess_etat_gestion' => 'envoye'
                 ),
                 array(
                     '%d',
                     '%d',
                     '%s'
                 )
             );
        }

        // si le message atterri dans la boite de réception
        // envoi d'un email au destinataire pour lui indiquer qu'il a un nouveau message
        if($destStateMsg==STATE_BDD_RECU) {
            $type_compte=$_SESSION['utilisateur_groupe'];
            $to=$infosDest->utilisateur_mail;
            $nameto=ucwords($_SESSION['utilisateur_nomprenom']);
            include_once(dirname(dirname(dirname(__FILE__))).'/emails/email_newmessage.php' );
        }

        // redirection
        $urlRedirect="/pe/espace-pe/messagerie/accueil.php?envoye=1";
        header("Location:".$urlRedirect);
        exit();
    } else {
        // redirection
        $urlRedirect="/pe/espace-pe/messagerie/accueil.php?envoye=2";
        header("Location:".$urlRedirect);
        exit();
    }
} else {
    $meta['title']="Envoi d'un message | Particulier Emploi";
    $meta['desc']="Envoi d'un message depuis la messagerie de l'espace de mise en relation de Particulier Emploi, "
        . "le site de l'emploi à domicile ";
    $pageActive = "messagerie";
    include_once(dirname(dirname(__FILE__)).'/templates/header-espacepe.php');
    include_once(dirname(dirname(__FILE__)).'/templates/envoyer.php');
    include_once(dirname(dirname(dirname(__FILE__))).'/common-templates/footer.php');
}