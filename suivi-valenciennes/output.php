<?php
/* 
 * File that generates stats output
 */

/**
 * Fonctions de Wordpress
 */
require_once __DIR__ . '/../wp-load.php';

/**
 * Fonctions helper
 */
require_once __DIR__ . '/inc/helpers.php';

/**
 * Librairie PHPExcel
 */
require_once __DIR__ . '/../lib/excel/PHPExcel/IOFactory.php';

global $wpdb;

$wpdb->show_errors();

//récupération des données du formulaire 

if( !wp_verify_nonce($_POST['stats_action_nonce'], 'stats_value_token') ){
    $message="Source non fiable";
    include_once __DIR__ . "/inc/partials/page-error.php";
    exit();
} else {
    $fieldFilters = array(
        'date-debut' => FILTER_SANITIZE_STRING,
        'date-fin' => FILTER_SANITIZE_STRING,
    );
    $params = filter_input_array(INPUT_POST, $fieldFilters);
    if( isset($_POST['connexion']) && !empty( $_POST['connexion']) ) {
        $params['type']= "connexion";
    } elseif ( isset($_POST['inscription']) && !empty($_POST['inscription']) ) {
        $params['type']= "inscription";
    } elseif ( isset($_POST['inscription-val']) && !empty($_POST['inscription-val']) ) {
        $params['type']= "inscription_val";
    }
    if( (!empty($params['date-debut']) && !check_valid_date($params['date-debut']))
          || (!empty($params['date-fin']) && !check_valid_date($params['date-fin'])) ) {
        $message="Format date non valide";
        include_once __DIR__ . "/inc/partials/page-error.php";
        exit();
    }
    if( !isset($params['type']) ) {
        // si pas de demande => erreur
        $message="Aucun choix n'a été fait";
        include_once __DIR__ . "/inc/partials/page-error.php";
        exit();
    }   
}



// création des objets de base
$classeur = new PHPExcel;
$classeur->setActiveSheetIndex(0);
$feuille=$classeur->getActiveSheet();

// récupération des chargés d'informations enregistrés
// chargé d'informations est le role attribuée aux personnes ayant accès à l'inscription simplifiée
$args = array(
    'role' => 'pe-officer');
$user_query = new WP_User_Query( $args );

$list_users=[];
if ( ! empty( $user_query->results ) ) {
    foreach ( $user_query->results as $user ) {
        $user_id=$user->ID;
        $list_users[$user_id]['firstname']=get_user_meta($user_id, 'first_name',true);
        $list_users[$user_id]['lastname']=get_user_meta($user_id, 'last_name',true);
        $list_users[$user_id]['email']=$user->user_email;
        $type_user=get_user_meta($user_id, 'type-ci',true);
        if( $type_user == "acteur-emploi") {
            $list_users[$user_id]['type']="acteur de l’emploi";
        } else if ($type_user == "referent-info") {
            $list_users[$user_id]['type']="référent points infos";
        } else {
            $list_users[$user_id]['type']="non défini";
        }
    }
}

$list_user_id = array_map('intval',array_keys($list_users));
$in_sql = implode( ", ", $list_user_id );
if(!empty($params['date-debut'])) {
    $date_debut=format_date_db($params['date-debut']);
} else {
    //limite aux 30 derniers jours
    $date_debut=date("Y-m-d", mktime(0,0,0,date("m"),date("d")-30,date("Y")));
}
if(!empty($params['date-fin'])) {
    $date_fin=format_date_db($params['date-fin']);
} else {
    $date_fin = date("Y-m-d");
}



if ( $params['type'] == "connexion" ) {
    $query= "SELECT user_id, count(*) as nbconn from activity_connections 
                where user_id IN ({$in_sql}) 
                and DATE_FORMAT(connection_date, '%%Y-%%m-%%d') >= %s
                and DATE_FORMAT(connection_date, '%%Y-%%m-%%d') <= %s
                group by user_id";
    $sql = $wpdb->prepare($query,
                    $date_debut,
                    $date_fin   
                );
    $connexions = $wpdb->get_results($sql);
    foreach($connexions as $user_connexion ) {
        $list_users[$user_connexion->user_id]['nbconn'] = $user_connexion->nbconn;
    }
    
    $titleEntete=array("Nom","Prénom","E-mail","Type","Nombre de connexion");
    $colIndex=0;
    foreach($titleEntete as $key=>$value) {
        $feuille->getCellByColumnAndRow($colIndex, 1)->getStyle()->getFont()->setBold(true);
        $feuille->setCellValueByColumnAndRow($colIndex, 1, $value);
        $colIndex++;
    }
    
    $rowIndex=2;
    foreach($list_users as $user) {
        $colIndex=0;
        foreach($user as $key=>$value) {
            $feuille->setCellValueByColumnAndRow($colIndex, $rowIndex, $value);
            $colIndex++;
        }
        $rowIndex++;
    }
    
} elseif ( $params['type'] == "inscription" || $params['type'] == "inscription_val") {
    $list_cp=["59410","59269","59494","59300","59192","59860","59163","59154","59990",
    "59970","59199","59233","59770","59224","59264","59121","59243","59920",
    "59220","59880","59227","59690"];
    $in_sql_list_cp= implode("','",$list_cp);
    $list_group=["EMP","SAL"];

    //inscription par code postal
    $query_cp= "SELECT utilisateur_created_by, utilisateur_codepostal, count(distinct utilisateur_mail)  as nbins
                from tbl_utilisateurs 
                where utilisateur_created_by IN ({$in_sql})
                    and utilisateur_codepostal IN ('{$in_sql_list_cp}')
                and DATE_FORMAT(utilisateur_datecrea, '%%Y-%%m-%%d') >= %s
                and DATE_FORMAT(utilisateur_datecrea, '%%Y-%%m-%%d') <= %s";
    if($params['type'] == "inscription") {
        $query_cp .= "and utilisateur_etat IN ('VAL','ACT')";
    } else {
        $query_cp .= "and utilisateur_etat IN ('ACT')";
    }
    $query_cp .= "group by utilisateur_created_by, utilisateur_codepostal";
    $sql_cp = $wpdb->prepare($query_cp,
                    $date_debut,
                    $date_fin   
                );
    $inscriptions_cp = $wpdb->get_results($sql_cp);
    //echo "<pre>";print_r($inscriptions_cp); echo "</pre>";
    
    foreach($inscriptions_cp as $user_inscription ) {
        //$list_users[$user_inscription->utilisateur_created_by]
        $list_users[$user_inscription->utilisateur_created_by]['ins'][$user_inscription->utilisateur_codepostal] = $user_inscription->nbins;
       
    }
    
    //inscription employeur
    $query_groupe= "SELECT utilisateur_created_by, utilisateur_groupe, count(distinct utilisateur_mail)  as nbins
                from tbl_utilisateurs 
                where utilisateur_created_by IN ({$in_sql})
                    and utilisateur_codepostal IN ('{$in_sql_list_cp}')
                and DATE_FORMAT(utilisateur_datecrea, '%%Y-%%m-%%d') >= %s
                and DATE_FORMAT(utilisateur_datecrea, '%%Y-%%m-%%d') <= %s";
    if($params['type'] == "inscription") {
        $query_groupe .= "and utilisateur_etat IN ('VAL','ACT')";
    } else {
        $query_groupe .= "and utilisateur_etat IN ('ACT')";
    }
    $query_groupe .= "group by utilisateur_created_by, utilisateur_groupe";
        
    $sql_groupe = $wpdb->prepare($query_groupe,
                    $date_debut,
                    $date_fin   
                );
    $inscriptions_groupe = $wpdb->get_results($sql_groupe);
    
    foreach($inscriptions_groupe as $user_inscription ) {
        $list_users[$user_inscription->utilisateur_created_by]['group'][$user_inscription->utilisateur_groupe]= $user_inscription->nbins;
            
    }
    
    // ordonnancement des données
    foreach ($list_users as $id=>$user) {
        //d'abord les inscriptions par groupe
        foreach($list_group as $group) {
             if(isset($user['group'][$group])) {
                $list_users[$id][$group]=$user['group'][$group];
            } else {
                $list_users[$id][$group]=0;
            }
        }
        unset($list_users[$id]['group']);
        
        //puis les inscriptions pour l'ensemble des codes postaux
        foreach($list_cp as $cp) {
             if(isset($user['ins'][$cp])) {
                $list_users[$id][$cp]=$user['ins'][$cp];
            } else {
                $list_users[$id][$cp]=0;
            }
        }
        unset($list_users[$id]['ins']);
        
        
    }
    
    $titleEntete=array("Nom","Prénom","E-mail","Type","Nombre d'inscriptions employeur", "Nombre d'inscriptions salarié");
    $titleEntete=array_merge($titleEntete,$list_cp);
    $colIndex=0;
    foreach($titleEntete as $key=>$value) {
        $feuille->getCellByColumnAndRow($colIndex, 1)->getStyle()->getFont()->setBold(true);
        $feuille->setCellValueByColumnAndRow($colIndex, 1, $value);
        $colIndex++;
    }
    
    $rowIndex=2;
    foreach($list_users as $user) {
        $colIndex=0;
        foreach($user as $key=>$value) {
            $feuille->setCellValueByColumnAndRow($colIndex, $rowIndex, $value);
            
            $colIndex++;
        }
        $rowIndex++;
    }
    
}
//echo "<pre>";print_r($list_users); echo "</pre>";


/// envoi du fichier au navigateur
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
header('Content-Disposition: attachment;filename="statistiques.xlsx"'); 
header('Cache-Control: max-age=0'); 
$writer = PHPExcel_IOFactory::createWriter($classeur, 'Excel2007'); 
$writer->save('php://output');