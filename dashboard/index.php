<?php
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

global $wpdb;

$params=array();
$tabDisplayError=array();
//Traitement formulaire de recherche utilisateurs
////////////////////////////////////////////////////
if(isset($_POST['usearch'])) {
    $fieldFilters = array(
        'ufname' => FILTER_SANITIZE_STRING,
        'ulname' =>  FILTER_SANITIZE_STRING,
        'uemail' => FILTER_VALIDATE_EMAIL,
        'uid' => FILTER_SANITIZE_NUMBER_INT
    );
    $params = filter_input_array(INPUT_POST, $fieldFilters);
    if(empty($params["uid"]) && empty($params["ufname"]) && empty($params["ulname"]) && empty($params["uemail"]) ) {
        $tabDisplayError[]="Au moins un critère de recherche doit être saisi";
    }
    if(!empty($_POST['uemail']) && $params['uemail'] === false) {
        $tabDisplayError[]="L'email n'a pas un format valide";
    }

    if(empty($tabDisplayError)) {
        //préparation de la recherche
        if(!empty($params['uid'])) {
            $whereclause[]= "utilisateur_id =".$params['uid'];
        }
        if(!empty($params['ufname'])) {
            $whereclause[]= "utilisateur_prenom like '%".$params['ufname']."%'";
        }
        if(!empty($params['ulname'])) {
            $whereclause[]= "utilisateur_nom like '%".$params['ulname']."%'";
        }
        if(!empty($params['uemail'])) {
            $whereclause[]= "utilisateur_mail ='".$params['uemail']."'";
        }
        //exécution de la recherche
        $reqSearchUsers = "select "
            . "utilisateur_id, "
            . "utilisateur_nom, "
            . "utilisateur_prenom,"
            . "utilisateur_mail "
            . "from ".TBL_UTILISATEURS." "
            . "where ".implode(' AND ', $whereclause)." "
            . "limit 10";
        //echo "<pre>";print_r($reqSearchUsers);echo "</pre>";
        $exeSearchUser=$wpdb->get_results($reqSearchUsers, ARRAY_A);
        $nbUsers= $wpdb->num_rows;
    }

}
//Récup infos pour afficher statistiques
/////////////////////////////////////////////////
$queryRecupComptes="SELECT "
        . "utilisateur_groupe, "
        . "CASE utilisateur_etat "
        . "WHEN 'ACT' THEN 'actif' "
        . "WHEN 'INS' THEN 'incomplètement inscrit' "
        . "WHEN 'SUP' THEN 'supprimé' "
        . "WHEN 'BAN' THEN 'banni' "
        . "WHEN 'VAL' THEN 'non validé' "
        . "ELSE 'n/a' "
        . "END AS utilisateur_etat, "
        . "count(*) as nb "
        . "FROM ".TBL_UTILISATEURS." ";
$queryRecupAnnonces="SELECT "
        . "annonce_type, "
        ."CASE annonce_etat "
        ."WHEN 'ACTIF' THEN 'active' "
        ."WHEN 'INS' THEN 'inscription incomplète' "
        ."WHEN 'SUP' THEN 'supprimée' "
        ."WHEN 'SUPPRIME' THEN 'supprimée' "
        ."WHEN 'BAN' THEN 'bannie' "
        ."WHEN 'EN_ATTENTE' THEN 'non validée' "
        ."ELSE 'n/a' "
        ."END AS annonce_etat,  "
        . "count(*) as nb "
        . "FROM ".TBL_ANNONCES." ";

//1. comptes et annonces du jour
$todayDate       = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$queryRecupComptesToday=$queryRecupComptes
        . "WHERE  DATE_FORMAT(utilisateur_datecrea, '%Y-%m-%d') = '".$todayDate."' "
        . "GROUP BY utilisateur_groupe, utilisateur_etat";
//echo "<pre>";print_r($queryRecupComptesToday);echo "</pre>";
$exeRecupComptesToday    = $wpdb->get_results($queryRecupComptesToday, ARRAY_A);
$tabStatsAccount=array();
foreach ($exeRecupComptesToday as $countComptes) {
    $tabStatsAccount[$countComptes['utilisateur_groupe']]['all']=$tabStatsAccount[$countComptes['utilisateur_groupe']]['all']+$countComptes['nb'];
    if($countComptes['utilisateur_etat']=="actif" || $countComptes['utilisateur_etat']=="non validé") {
       $tabStatsAccount[$countComptes['utilisateur_groupe']][$countComptes['utilisateur_etat']]=$countComptes['nb'];
    }
}
//echo "<pre>comptes";print_r($tabStatsAccount);echo "</pre>";
$queryRecupAnnoncesToday=$queryRecupAnnonces
        . "WHERE DATE_FORMAT(annonce_datecrea, '%Y-%m-%d') = '".$todayDate."' "
        . "GROUP BY annonce_type, annonce_etat";
$exeRecupAnnoncesToday    = $wpdb->get_results($queryRecupAnnoncesToday, ARRAY_A);
//echo "<pre>";print_r($queryRecupAnnoncesToday);echo "</pre>";
$tabStatsAnnonces=array();
foreach ($exeRecupAnnoncesToday as $countAnnonces) {
    $tabStatsAnnonces[$countAnnonces['annonce_type']]['all']=$tabStatsAnnonces[$countAnnonces['annonce_type']]['all']+$countAnnonces['nb'];
    if($countAnnonces['annonce_etat']=="active" || $countAnnonces['annonce_etat']=="non validée") {
        $tabStatsAnnonces[$countAnnonces['annonce_type']][$countAnnonces['annonce_etat']]=$countAnnonces['nb'];
    }
}
//echo "<pre>annonces";print_r($tabStatsAnnonces);echo "</pre>";
//2. comptes et annonces des 3 derniers mois
$minM3Date       = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-90, date("Y")));
$queryRecupComptesM3=$queryRecupComptes
        . "WHERE DATE_FORMAT(utilisateur_datecrea, '%Y-%m-%d') > '".$minM3Date."' "
        . "GROUP BY utilisateur_groupe, utilisateur_etat";
$exeRecupComptesM3    = $wpdb->get_results($queryRecupComptesM3, ARRAY_A);
//echo "<pre>";print_r($queryRecupComptesM3);echo "</pre>";
$tabStatsAccountM3=array();
foreach ($exeRecupComptesM3 as $countComptes) {
    $tabStatsAccountM3[$countComptes['utilisateur_groupe']]['all']=$tabStatsAccountM3[$countComptes['utilisateur_groupe']]['all']+$countComptes['nb'];
    if($countComptes['utilisateur_etat']=="actif" || $countComptes['utilisateur_etat']=="non validé") {
       $tabStatsAccountM3[$countComptes['utilisateur_groupe']][$countComptes['utilisateur_etat']]=$countComptes['nb'];
    }
}
//echo "<pre>comptes M3";print_r($tabStatsAccountM3);echo "</pre>";
$queryRecupAnnoncesM3=$queryRecupAnnonces
        . "WHERE DATE_FORMAT(annonce_datecrea, '%Y-%m-%d') > '".$minM3Date."' "
        . "GROUP BY annonce_type, annonce_etat";
$exeRecupAnnoncesM3   = $wpdb->get_results($queryRecupAnnoncesM3, ARRAY_A);
//echo "<pre>";print_r($queryRecupAnnoncesM3);echo "</pre>";
$tabStatsAnnoncesM3=array();
foreach ($exeRecupAnnoncesM3 as $countAnnonces) {
    $tabStatsAnnoncesM3[$countAnnonces['annonce_type']]['all']=$tabStatsAnnoncesM3[$countAnnonces['annonce_type']]['all']+$countAnnonces['nb'];
    if($countAnnonces['annonce_etat']=="active" || $countAnnonces['annonce_etat']=="non validée") {
        $tabStatsAnnoncesM3[$countAnnonces['annonce_type']][$countAnnonces['annonce_etat']]=$countAnnonces['nb'];
    }
}
//echo "<pre>annonce M3";print_r($tabStatsAnnoncesM3);echo "</pre>";
//Récupération utilisateurs bloqués
/////////////////////////////////////
$queryRecupUserBlocked="Select "
        . "utilisateur_id_bloquant, "
        . "utilisateur_id_bloque, "
        . "utilisateur_bloque_etat, "
        . "utilisateur_bloque_date "
        . "from ".TBL_UTILISATEURS_BLOQUES." "
        . "order by utilisateur_bloque_date desc "
        . "limit 30";
//echo "<pre>";print_r($queryRecupUserBlocked);echo "</pre>";
$exeRecupUserBlocked   = $wpdb->get_results($queryRecupUserBlocked, ARRAY_A);
//echo "<pre>";print_r($exeRecupUserBlocked);echo "</pre>";
$tabUsersBlocked=array();
foreach ($exeRecupUserBlocked as $userBlocked) {
    $infos=array();
    $queryUserBloquant="select utilisateur_nom, utilisateur_prenom from ".TBL_UTILISATEURS." "
            . "where utilisateur_id=".$userBlocked['utilisateur_id_bloquant'];
    $exeUserBloquant=$wpdb->get_row($queryUserBloquant, ARRAY_A);
    $infos['id_user_bloquant']=$userBlocked['utilisateur_id_bloquant'];
    $infos['nom_user_bloquant']=$exeUserBloquant['utilisateur_nom'];
    $infos['prenom_user_bloquant']=$exeUserBloquant['utilisateur_prenom'];
    $queryUserBloque="select utilisateur_nom, utilisateur_prenom from ".TBL_UTILISATEURS." "
            . "where utilisateur_id=".$userBlocked['utilisateur_id_bloque'];
    $exeUserBloque=$wpdb->get_row($queryUserBloque, ARRAY_A);
    $infos['id_user_bloque']=$userBlocked['utilisateur_id_bloque'];
    $infos['nom_user_bloque']=$exeUserBloque['utilisateur_nom'];
    $infos['prenom_user_bloque']=$exeUserBloque['utilisateur_prenom'];
    $infos['date_blocage']=convert_date($userBlocked['utilisateur_bloque_date'],"/");
    $infos['raison_blocage']=$userBlocked['utilisateur_bloque_etat'];
    $tabUsersBlocked[]=$infos;
}
//Récupération messages spam
////////////////////////////////////
$queryRecupMsgSpam="Select "
        . "dest_mess_id_membre, "
        . "message_objet,"
        . "message_contenu, "
        . "utilisateur_nom, "
        . "utilisateur_prenom,"
        . "message_exp "
        . "from ".TBL_MESSAGES.", "
        . TBL_MSG_DEST.", "
        . TBL_UTILISATEURS." "
        . "where dest_mess_etat_gestion='".STATE_BDD_SPAM."' "
        . "AND dest_mess_id_mess=message_id "
        . "AND message_dest=utilisateur_id "
        . "order by message_datecrea desc "
        . "limit 30";
//echo "<pre>";print_r($queryRecupMsgSpam);echo "</pre>";
$exeRecupMsgSpam   = $wpdb->get_results($queryRecupMsgSpam, ARRAY_A);
//echo "<pre>";print_r($exeRecupMsgSpam);echo "</pre>";
$tabMsgSpam=array();
foreach($exeRecupMsgSpam as $msg) {
    $infos=array();
    $queryExp="select utilisateur_nom, utilisateur_prenom from ".TBL_UTILISATEURS." "
            . "where utilisateur_id=".$msg['message_exp'];
    $exeExp=$wpdb->get_row($queryExp, ARRAY_A);
    $infos['dest_id']=$msg['dest_mess_id_membre'];
    $infos['dest_prenom']=$msg['utilisateur_prenom'];
    $infos['dest_nom']=$msg['utilisateur_nom'];
    $infos['message_objet']=$msg['message_objet'];
    $infos['message_contenu']=$msg['message_contenu'];
    $infos['exp_id']=$msg['message_exp'];
    $infos['exp_nom']=$exeExp['utilisateur_nom'];
    $infos['exp_prenom']=$exeExp['utilisateur_prenom'];
    
    $tabMsgSpam[]=$infos;
}

//Récupération des utilisateurs envoyant plus de 10 messages par jour
////////////////////////////////////
$queryExpUserOverLimit ="Select "
        . "message_exp, "
        . "utilisateur_nom, "
        . "utilisateur_prenom, "
        . "DATE(message_datecrea) as message_date, "
        . "count(*) as nb "
        . "FROM tbl_messages, "
        . "tbl_utilisateurs "
        . "where message_exp=utilisateur_id "
        . "and utilisateur_etat='ACT' "
        . "and utilisateur_groupe='EMP' "
        . "group by message_exp,utilisateur_nom,utilisateur_prenom,message_date "
        . "having nb > 10 "
        . "order by nb desc, message_date desc "
        . "limit 30";
$recupExpUserOverLimit = $wpdb->get_results($queryExpUserOverLimit, ARRAY_A);
//echo "<pre>";print_r($queryExpUserOverLimit); echo "</pre>";

//Traitement formulaire de recherche alertes
////////////////////////////////////////////////////
$tabDisplayErrorAlert=array();
if(isset($_POST['usearchmess'])) {
    $fieldFilters = array(
        'mess_env' => FILTER_VALIDATE_INT,
        'mess_filtre' =>  FILTER_VALIDATE_INT
    );
    $params = filter_input_array(INPUT_POST, $fieldFilters);
    if( empty($params["mess_env"]) && empty($params["mess_filtre"]) ) {
        $tabDisplayErrorAlert[]="Au moins un critère de recherche doit être saisi";
    }

    if(empty($tabDisplayErrorAlert)) {
        //messages émis par utilisateur actif/par jour
        if(!empty($params['mess_env'])) {
            $minDate       = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $params['mess_env'], date("Y")));
            $queryRecupCntMsgEnv  = "SELECT "
                    . "message_exp, "
                    . "utilisateur_nom, "
                    . "utilisateur_prenom, "
                    . "DATE(message_datecrea) as message_date, "
                    . "count(*) as nb "
                    . "FROM ".TBL_MESSAGES.", "
                    . TBL_UTILISATEURS." "
                    . "where message_exp=utilisateur_id "
                    . "and utilisateur_etat='ACT' "
                    . "and message_datecrea > '".$minDate."' "
                    . "group by message_exp,utilisateur_nom,utilisateur_prenom,message_date "
                    . "order by nb desc, message_datecrea desc "
                    . "limit 30";
            //echo "<pre>";print_r($queryRecupMsgEnv); echo "</pre>";
            $exeRecupCntMsgEnv = $wpdb->get_results($queryRecupCntMsgEnv, ARRAY_A);
            //echo "<pre>";print_r($exeRecupMsgEnv); echo "</pre>";
        }
        //messages d'utilisateurs actifs contenant des mots-clefs suspects
        if(!empty($params['mess_filtre'])) {
            $minDate       = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - $params['mess_filtre'], date("Y")));
            $keywords=array("urgen*", "sexe", "taf", "salaire d'avance", "étranger","chèque","compte bancaire","banque");
            $keywordsFulltext=array("urgen*", "sexe", "taf", "\"salaire d\'avance\"", "étranger","chèque","\"compte bancaire\"","banque");
            $queryRecupMsgFiltre="SELECT 
                                    message_exp, 
                                    message_dest,
                                    message_objet,
                                    message_contenu, 
                                    message_datecrea, 
                                    MATCH (message_objet, message_contenu) AGAINST (
                                    '".implode(" ",$keywordsFulltext)."'
                                    IN BOOLEAN MODE) AS  cpt
                                  FROM ".TBL_MESSAGES.", ".TBL_UTILISATEURS."
                                  WHERE message_exp=utilisateur_id
                                  AND utilisateur_etat='ACT'
                                  AND DATE_FORMAT(message_datecrea, '%Y-%m-%d') > '".$minDate."'
                                  AND MATCH (message_objet, message_contenu) AGAINST (
                                  '".implode(" ",$keywordsFulltext)."'
                                  IN BOOLEAN MODE)
                                  ORDER BY message_datecrea DESC ";
            //echo "<pre>";print_r($queryRecupMsgFiltre); echo "</pre>";
            $exeRecupMsgFiltre = $wpdb->get_results($queryRecupMsgFiltre, ARRAY_A);
            //echo "<pre>";print_r($exeRecupMsgFiltre); echo "</pre>";
            $tabMsgFiltre=array();
            foreach($exeRecupMsgFiltre as $msgFiltre) {
                $infos=array();
                $queryExp="select utilisateur_nom, utilisateur_prenom from ".TBL_UTILISATEURS." "
                    . "where utilisateur_id=".$msgFiltre['message_exp'];
                $exeExp=$wpdb->get_row($queryExp, ARRAY_A);
                $queryDest="select utilisateur_nom, utilisateur_prenom from ".TBL_UTILISATEURS." "
                    . "where utilisateur_id=".$msgFiltre['message_dest'];
                $exeDest=$wpdb->get_row($queryDest, ARRAY_A);
                $infos['message_exp']=$msgFiltre['message_exp'];
                $infos['message_dest']=$msgFiltre['message_dest'];
                $infos['message_objet']=highlightWordsInText($keywords,$msgFiltre['message_objet']);
                $infos['message_contenu']=highlightWordsInText($keywords,$msgFiltre['message_contenu']);
                $infos['message_datecrea']=$msgFiltre['message_datecrea'];
                $infos['exp_prenom']=$exeExp['utilisateur_prenom'];
                $infos['exp_nom']=$exeExp['utilisateur_nom'];
                $infos['dest_prenom']=$exeDest['utilisateur_prenom'];
                $infos['dest_nom']=$exeDest['utilisateur_nom'];
                $tabMsgFiltre[]=$infos;
            }
            //echo "<pre>";print_r($tabMsgFiltre); echo "</pre>";
        }
    }

}


$meta['title']="Tableau de bord | Particulier Emploi";
$meta['desc']="Partie administration back-end du site particulieremploi.fr";
include_once(dirname(__FILE__).'/templates/header-bo.php');
include_once(dirname(__FILE__).'/templates/index.php');

include_once(dirname(__FILE__).'/templates/footer-bo.php');

