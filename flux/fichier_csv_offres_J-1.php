<?php
/**
 * Fonctions de Wordpress
 */
require( dirname(dirname(__FILE__)).'/wp-load.php' );

global $wpdb;

//nom du fichier csv et destination
// ici localisé dans le même dossier que le script de création du fichier
//le dossier de destination doit être autorisé en écriture pour le serveur web
$filename = "liste_offres_J-1.csv";

//ouverture du fichier contenant les résultats
$handle = fopen($filename, 'wb');
 
//séparateur des champs
$delimiter='|';
   
//constantes////////////////////////
//identifiant auprès de Pole Emploi
$identifiantpe='FEPEM';
//unité pour l'expérience
$uniteExp='AN';
//nature du contrat
$natureContrat='E1';
//type du contrat
$typeContrat='CDI';
//code pays
$offPays='01';

//correspondances experience
$arrayExpMin= array(0=>'M5',
        2=>'E510',
    5=>'P10');

$arrayExpMax=array(2=>'M5',
        5=>'E510'
    );

//ajout de la ligne d'entête
fputcsv($handle, array('Par_ref_offre','Par_cle','Par_nom','Code_rome','Code_OGR','Libelle_metier_OGR','Description','Off_experience_duree_min','Off_experience_duree_max','Exp_cle','Exp_libelle','Dur_cle_experience','Dur_libelle_experience','Off_experience_commentaire','Qua_cle','Qua_libelle','SCN_cle','SCN_libelle','Tfm_cle_1','Tfm_libelle_1','Dfm_cle_1','Dfm_libelle_1','Dfm_exi_cle_1','Dfm_exi_libelle_1','Tfm_cle_2','Tfm_libelle_2','Dfm_cle_2','Dfm_libelle_2','Dfm_exi_cle_2','Dfm_exi_libelle_2','Lan_cle_1','Lan_libelle_1','NVL_cle_1','NVL_libelle_1','Lan_exi_cle_1 ','Lan_exi_libelle_1 ','Lan_cle_2','Lan_libelle_2','NVL_cle_2','NVL_libelle_2','Lan_exi_cle_2 ','Lan_exi_libelle_2 ','Off_salaire_min','Off_salaire_max','TSA_cle','TSA_libelle','UMO_cle','UMO_libelle','Off_salaire_nb_mois','Off_salaire_cpt_commentaire','Off_travail_hebdo_nb_hh','Off_travail_hebdo_nb_mi','THO_cle','THO_libelle','Off_THO_commentaire','NTC_cle','NTC_libelle','TCO_cle','TCO_libelle','Off_contrat_duree_MO','Off_contrat_duree_JO','Off_adr_id','Off_adr_norme','Off_adr_compl_1','Off_adr_compl_2','Off_adr_no_voie','Off_adr_nom_voie','CPO_cle','COM_cle','COM_libelle','DEP_cle','DEP_libelle','REG_cle','REG_libelle','Pay_cle','Pay_libelle','CON_cle','CON_libelle','Coordonnee_geo_loc_1','Coordonnee_geo_loc_2','PCO_cle_1','PCO_libelle_1','PCO_exi_cle_1','PCO_exi_libelle_1','PCO_cle_2','PCO_libelle_2','PCO_exi_cle_2','PCO_exi_libelle_2','Off_date_creation','Off_date_modification','OST_poste_restant_nb','Off_client_final_siret','Off_client_final_nom','Off_etab_enseigne','Par_URL_offre','Col_cle','Col_nom','Col_URL_offre'),$delimiter);
$limiteValidite = date ("Y-m-d", mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$reqAnnonces="SELECT annonce_id,annonce_idmetier,annonce_description, annonce_experience, annonce_ville,annonce_codepostal, annonce_datecrea "
        . "from tbl_annonces "
        . "WHERE annonce_etat='ACTIF' "
        . "and annonce_type='EMP' "
        . "and annonce_datecrea >= '".$limiteValidite."' ";
//echo "<pre>";print_r($reqAnnonces); echo "</pre>";

$resReqAnnonces =$wpdb->get_results($reqAnnonces,ARRAY_A);
foreach ($resReqAnnonces as $result){
    //pour les tests
    $idMetier=$result['annonce_idmetier'];
    $reqRome="SELECT code_rome,code_ogr_appellation, lib_ogr_appelation from tbl_pe_rome WHERE Id_metier_pe=".$idMetier;
    //echo "<pre>";print_r($reqRome);"</pre>";
    $resReqRome = $wpdb->get_results($reqRome,ARRAY_A);
    foreach ($resReqRome as $resultRome){
        $coderome=$resultRome['code_rome'];
        $codeogr=$resultRome['code_ogr_appellation'];
        $libmetierOGR=$resultRome['lib_ogr_appelation'];
    }
    
    $offCom='non renseignée';
   
    $communeEchapApostrophes=trim(str_replace("'", "''", $result['annonce_ville']));
    $communeSansSlash=str_replace("\\", " ", $communeEchapApostrophes);
    
    if(!empty($communeSansSlash)) {
        $reqInseeCom="SELECT code from insee_commune WHERE nom='".strtoupper($communeSansSlash)."'";
        //echo "<pre>";print_r($reqInseeCom);"</pre>".
        $resInseeCom =  $wpdb->get_results($reqInseeCom,ARRAY_A);
        foreach ($resInseeCom as $resultInseeCom){
            $offCom=$resultInseeCom['code'];
        }
        if(empty($offCom)) {
            $offCom="non renseignée";
        }
    }
    //echo $offCom."<br>";
    
    //expérience
    $offExpMin=array_search($result['annonce_experience'],$arrayExpMin);
    $offExpMax=array_search($result['annonce_experience'],$arrayExpMax);
    if(!$offExpMax){
        $offExpMax='';
    }
    //codepostal sur 2 chiffre
    $offCodepostal=substr($result['annonce_codepostal'],0,2);
    //description
    if($result['annonce_description']==''){
        $offDescription='Description non disponible';
    }
    else {
        //suppression des retours à la ligne
        $offDescription=trim(stripslashes(str_replace(CHR(13).CHR(10),"",$result['annonce_description'])));
    }
   //url de l'annonce
    $offUrl='http://www.particulieremploi.fr/compte/details_offre.php?id='.$result['annonce_id'];
    //date creation annonce
    list($year,$month,$day) = explode("-",$result['annonce_datecrea']);
    $offDateCrea=$day.'/'.$month.'/'.$year;
    
    $arrayAnnonceCSV=array($result['annonce_id'], $identifiantpe,$identifiantpe,$coderome,$codeogr,$libmetierOGR,$offDescription,$offExpMin,$offExpMax,'','',$uniteExp,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',$natureContrat,'',$typeContrat,'','','','','','','','','','',$offCom,'',$offCodepostal,'','','',$offPays,'','','','','','','','','','','','','',$offDateCrea,'','','','','',$offUrl,'','','');
    fputcsv($handle,$arrayAnnonceCSV,$delimiter);
}


//fermeture du fichier de résultats
fclose($handle);

echo "Fichier créé.";





