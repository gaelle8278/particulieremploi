<?php
/**
 * Page fiche du BO
 *
 * Page qui affiche les informations relatives à un utilisateur
 */

/**
 * Constantes
 */
require( dirname(dirname(__FILE__)).'/pe/config/constants.php' );
/**
 * Fonctions
 */
require( dirname(dirname(__FILE__)).'/pe/config/functions.php' );
/**
 * Fonctions de Wordpress
 */
require( dirname(dirname(__FILE__)).'/wp-load.php' );

$params=array();
$error="";
if (isset($_GET) && !empty($_GET)) {
    $options = array(
        'id' => FILTER_VALIDATE_INT,
        'action' => FILTER_SANITIZE_STRING
    );
    $params = filter_input_array(INPUT_GET, $options);
} elseif (isset($_POST) && !empty($_POST)) {
    $options = array(
        'id' => FILTER_VALIDATE_INT,
        'mdate' => FILTER_SANITIZE_STRING,
        'mdatenb' => FILTER_SANITIZE_STRING,
        'mdestid' => FILTER_VALIDATE_INT
    );
    $params = filter_input_array(INPUT_POST, $options);
}

if(!isset($params['id']) || empty($params['id'])) {
    $error="Un identifiant utilisateur doit être fourni";
} else {

    //actions sur l'utilisateur
    ///////////////////////////
    //mise à jour des annonces et de l'utilisateur
    if (isset($params['action'])) {
        $updateEtat = "";
        if ($params['action'] == "bannir") {
            $updateEtat        = "BAN";
            $annonceFromEtat   = "ACTIF";
            $annonceUpdateEtat = "BAN";
        } elseif ($params['action'] == "activer") {
            $updateEtat        = "ACT";
            $annonceFromEtat   = "BAN";
            $annonceUpdateEtat = "ACTIF";
        }
        if ($updateEtat != "") {
            //mise à jour de l'état de l'utilisateur
            $update = $wpdb->update(
                TBL_UTILISATEURS,
                array(
                'utilisateur_etat' => $updateEtat
                ),
                array(
                'utilisateur_id' => $params['id']
                ), array(
                '%s'
                ), array(
                '%d'
                )
            );
            //mise à jour de l'état des annonces
            $update = $wpdb->update(
                TBL_ANNONCES,
                array(
                'annonce_etat' => $annonceUpdateEtat
                ),
                array(
                'annonce_idauteur' => $params['id'],
                'annonce_etat' => $annonceFromEtat
                ), array(
                '%s'
                ),
                array(
                '%d',
                '%s'
                )
            );
        }
    }

    //formulaire de recherche
    //////////////////////////
    //messages envoyés le jour x si demandé
    if (isset($params['mdate']) && !empty($params['mdate'])) {
        $tabDate        = explode('/', $params['mdate']);
        $minDate        = date("Y-m-d", mktime(0, 0, 0, $tabDate[1], $tabDate[0] - 1, $tabDate[2]));
        $maxDate        = date("Y-m-d", mktime(0, 0, 0, $tabDate[1], $tabDate[0] + 1, $tabDate[2]));
        $queryRecupMsg  = "select "
            ."message_objet, "
            ."message_contenu, "
            ."message_dest, "
            ."utilisateur_nom, "
            ."utilisateur_prenom, "
            ."message_datecrea "
            ."from ".TBL_MESSAGES." "
            ."left join ".TBL_UTILISATEURS." "
            ."on message_dest=utilisateur_id "
            ."where message_exp=".$params['id']." "
            ."and message_datecrea > '".$minDate."' "
            ."and message_datecrea < '".$maxDate."' ";
        $exeInfoRechMsg = $wpdb->get_results($queryRecupMsg, ARRAY_A);
        //echo "<pre>";print_r($exeInfoRechMsg);echo "</pre>";
    }
    //messages envoyés à x si demandé
    if (isset($params['mdestid']) && !empty($params['mdestid'])) {
        $queryRecupMsg      = "select "
            ."message_objet, "
            ."message_contenu, "
            ."message_dest, "
            ."utilisateur_nom, "
            ."utilisateur_prenom, "
            ."message_datecrea "
            ."from ".TBL_MESSAGES." "
            ."left join ".TBL_UTILISATEURS." "
            ."on message_dest=utilisateur_id "
            ."where message_exp=".$params['id']." "
            ."and message_dest=".$params['mdestid']." ";
        $exeInfoRechDestMsg = $wpdb->get_results($queryRecupMsg, ARRAY_A);
        //echo "<pre>";print_r($exeInfoRechMsg);echo "</pre>";
    }
    //messages envoyé par jour depuis le jour x si demandé
    if (isset($params['mdatenb']) && !empty($params['mdatenb'])) {
        $tabDate        = explode('/', $params['mdatenb']);
        $minDate        = date("Y-m-d", mktime(0, 0, 0, $tabDate[1], $tabDate[0] - 1, $tabDate[2]));
        $queryRecupNbMsg      = "select "
            ."DATE(message_datecrea) as message_date, "
            ."count(*) as nb "
            ."from ".TBL_MESSAGES." "
            ."where message_exp=".$params['id']." "
            ."and message_datecrea > '".$minDate."' "
            ."group by message_date "
            ."order by message_date desc ";
        //echo "<pre>";print_r($queryRecupNbMsg);echo "</pre>";
        $exeRecupNbMsg = $wpdb->get_results($queryRecupNbMsg, ARRAY_A);
    }
    
    
    //infos
    ////////////////////
    //recup des infos utilisateur
    $reqInfoUser = "select "
        . "utilisateur_id, "
        . "utilisateur_nom, "
        . "utilisateur_prenom,"
        . "CASE utilisateur_groupe "
        . "WHEN 'SAL' THEN 'Salarié' "
        . "WHEN 'EMP' THEN 'Employeur' "
        . "ELSE 'n/a' "
        . "END AS utilisateur_groupe, "
        . "CASE utilisateur_civilite "
        . "WHEN '1' THEN 'Monsieur' "
        . "WHEN '2' THEN 'Madame' "
        . "WHEN '3' THEN 'Mademoiselle' "
        . "ELSE 'n/a' "
        . "END AS utilisateur_civilite, "
        . "utilisateur_adresse, "
        . "utilisateur_codepostal, "
        . "utilisateur_ville, "
        . "utilisateur_mail,"
        . "utilisateur_telephone, "
        . "utilisateur_datecrea, "
        . "utilisateur_lastconnexion, "
        . "CASE utilisateur_etat "
        . "WHEN 'ACT' THEN 'actif' "
        . "WHEN 'INS' THEN 'Incomplètement inscrit' "
        . "WHEN 'SUP' THEN 'Supprimé' "
        . "WHEN 'BAN' THEN 'Banni' "
        . "WHEN 'VAL' THEN 'Non validé' "
        . "ELSE 'n/a' "
        . "END AS utilisateur_etat "
        . "from ".TBL_UTILISATEURS." "
        . "where utilisateur_id=".$params['id'];
        //echo "<pre>";print_r($reqInfoUser);echo "</pre>";
    $exeInfoUser=$wpdb->get_row($reqInfoUser, ARRAY_A);
    if($exeInfoUser==NULL) {
        $error="L'utilisateur d'identifiant ".$params['id']." n'existe pas";
    }


    //recup des annonces de l'utilisateur
    $queryRecupAnnonces = "select "
        ."annonce_id, "
        ."CASE annonce_etat "
        ."WHEN 'ACTIF' THEN 'active' "
        ."WHEN 'INS' THEN 'Inscription incomplète' "
        ."WHEN 'SUP' THEN 'Supprimée' "
        ."WHEN 'SUPPRIME' THEN 'Supprimée' "
        ."WHEN 'BAN' THEN 'Bannie' "
        ."WHEN 'EN_ATTENTE' THEN 'Inscription non validée' "
        ."ELSE 'n/a' "
        ."END AS annonce_etat,  "
        ."annonce_datecrea, "
        ."annonce_titremetier, "
        ."annonce_adresse, "
        ."annonce_ville, "
        ."annonce_codepostal, "
        ."annonce_description, "
        ."annonce_tauxhoraire, "
        ."CASE annonce_experience "
        ."WHEN 'E510' THEN 'de 2 à 5 ans' "
        ."WHEN 'M5' THEN 'moins de 2 ans' "
        ."WHEN 'P10' THEN 'plus de 5 ans' "
        ."ELSE 'n/a' "
        ."END AS annonce_experience, "
        ."annonce_dateprisefonction, "
        ."annonce_dureehebdomadaire "
        ."FROM ".TBL_ANNONCES." "
        ."where annonce_idauteur=".$params['id']." "
        . "order by annonce_datecrea desc";
    $exeInfoAnnonces    = $wpdb->get_results($queryRecupAnnonces, ARRAY_A);
    
    //recherche des messages envoyés ce jour
    $minDate       = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
    $maxDate       = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") + 1, date("Y")));
    $queryRecupMsg = "select "
        ."message_objet, "
        ."message_contenu, "
        ."message_dest, "
        ."utilisateur_nom, "
        ."utilisateur_prenom, "
        ."message_datecrea "
        ."from ".TBL_MESSAGES." "
        ."left join ".TBL_UTILISATEURS." "
        ."on message_dest=utilisateur_id "
        ."where message_exp=".$params['id']." "
        ."and message_datecrea > '".$minDate."' "
        ."and message_datecrea < '".$maxDate."' ";
    $exeInfoMsg    = $wpdb->get_results($queryRecupMsg, ARRAY_A);
    //echo "<pre>";print_r($exeInfoMsg);echo "</pre>";
}

global $wpdb;

$meta['title']="Tableau de bord | Particulier Emploi";
$meta['desc']="Partie administration back-end du site particulieremploi.fr";

include_once(dirname(__FILE__).'/templates/header-bo.php');
include_once(dirname(__FILE__).'/templates/fiche.php');

include_once(dirname(__FILE__).'/templates/footer-bo.php');

