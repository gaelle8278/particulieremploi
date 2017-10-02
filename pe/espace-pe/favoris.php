<?php

/**
 * Module annonces/offres sélectionnées de l'espac eperso
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

$utilisateurId = $_SESSION['utilisateur_id'];

if(isset($_GET) && !empty($_GET)) {
    $options = array(
        'part' => FILTER_SANITIZE_STRING, 
        'annonceid' => FILTER_SANITIZE_NUMBER_INT,
    );
    $validateDataInput = filter_input_array(INPUT_GET, $options);
} else if (isset($_POST) && !empty($_POST)) {
    $options = array(
        'part' => FILTER_SANITIZE_STRING, 
        'annonceid' => FILTER_SANITIZE_NUMBER_INT,
        'note' => FILTER_SANITIZE_STRING, 
    );
    $validateDataInput = filter_input_array(INPUT_POST, $options);
}

/****************************************
 * Ajout d'une annonce/offre en favori
 ****************************************/
if(isset($validateDataInput['part']) && $validateDataInput['part']=="ajout") {
    $wpdb->insert(
            TBL_FAVORIS, 
            array( 
                'maselection_annonceid' => $validateDataInput['annonceid'],
                'maselection_utilisateurid' => $utilisateurId,
            )
        );
}

/************************************************************************
Suppression d'une annonce dans la selection de l'utilisateur courant
************************************************************************/
if(isset($validateDataInput['part']) && $validateDataInput['part']=="suppression") {
    $wpdb->delete(
        TBL_FAVORIS, 
        array(
            'maselection_annonceid' => $validateDataInput['annonceid'],
            'maselection_utilisateurid' => $utilisateurId,
        )
    );
    unset($validateDataInput['annonceid']);
}
/************************************************************************
Ajout d'une note en BD par rapport à l'id d'une annonce
************************************************************************/
if(isset($validateDataInput['part']) && $validateDataInput['part']=="ajoutnotedb"){
    $wpdb->update(
        TBL_FAVORIS, 
        array(
            'maselection_blocnotes' => $validateDataInput['note'],
        ),
        array( 
            'maselection_annonceid' => $validateDataInput['annonceid'],
            'maselection_utilisateurid' => $utilisateurId,
        )
    );
}

global $wpdb;
$queryAnnonces= "SELECT DISTINCT
	  utilisateurs.utilisateur_civilite as civilite
    , utilisateurs.utilisateur_nom as nom
    , utilisateurs.utilisateur_prenom as prenom
    , annonces.annonce_codepostal as codepostal
    , annonces.annonce_ville as ville
    , annonces.annonce_adresse as adresse
    , annonces.annonce_description as description
    , annonces.annonce_tauxhoraire as tauxhoraire
    , annonces.annonce_experience as experience
    , annonces.annonce_dureehebdomadaire as dureehebdomadaire
    , annonces.annonce_titremetier as metier
    , annonces.annonce_type as type
    , annonces.annonce_idmetier as idmetier
    , annonces.annonce_idauteur as idauteur
    , annonces.annonce_datecrea as annoncedatecrea
    , annonces.annonce_dateprisefonction as annoncedateprisefonction
    , annonces.annonce_etat as annonceetat
    , favoris.maselection_annonceid as annonceid
    , favoris.maselection_datecrea as datecrea
    , favoris.maselection_blocnotes as blocnotes
FROM
    ".TBL_FAVORIS." as favoris
    INNER JOIN ".TBL_ANNONCES." as annonces
        ON (favoris.maselection_annonceid = annonces.annonce_id)
    LEFT JOIN ".TBL_UTILISATEURS." as utilisateurs
        ON (annonces.annonce_idauteur = utilisateurs.utilisateur_id)
WHERE
	favoris.maselection_utilisateurid = ".$utilisateurId;
//echo "<pre>";print_r($queryAnnonces);echo "</pre>";
$resultats= $wpdb->get_results($queryAnnonces,ARRAY_A);
$nbresult = $wpdb->num_rows;


$f=0;
if($nbresult > 0) {
    foreach ($resultats as $data) {
        $nom[$f] = $data['nom'];
        $prenom[$f] = $data['prenom'];
        $cpo[$f] = $data['codepostal'];
        $ville[$f] = $data['ville'];
        $adresse[$f] = $data['adresse'];
        $description[$f] = $data['description'];
        $tauxhoraire[$f] = $data['tauxhoraire'];
        $experience[$f] = get_experience($data['experience']);
        $dureehebdo[$f] = $data['dureehebdomadaire'];
        $blocnotes[$f] = $data['blocnotes'];
        $annonceid[$f] = $data['annonceid'];
        $groupeencours[$f] = strtolower($data['type']);
        $metierencours[$f] = $data['idmetier'];
        
        $idauteur[$f] = $data['idauteur'];
        
        
        $metier[$f] = $data['metier'];
        $annoncedatecrea[$f] = convert_date($data['annoncedatecrea'], '-');
        $annoncedateprisefonction[$f] = convert_date($data['annoncedateprisefonction'], '-');
        $annonceetat[$f] = $data['annonceetat'];
        $civilite[$f]=  get_civilite($data['civilite']);
            
        //02/2016 récupération des emplois-repères liés à l'annonce
        //récupération des emplois-repère liés à l'annonce
        $annonceemploirepere[$f]='';
        $queryRecupER = "select emploi_repere_libelle "
                . "from ".TBL_EMPLOI_REPERE." er, "
                . TBL_ASSOC_ER_ANNONCE." erannonce "
                . "where erannonce.annonce_id=".$data['annonceid']." "
                . "and erannonce.emploi_repere_id=er.emploi_repere_id";
        $resErlibelle= $wpdb->get_results($queryRecupER,ARRAY_A);
        $nbResERLib=  $wpdb->num_rows;
        $cntLib=1;
        foreach($resErlibelle as $dataErLib){
            if($cntLib==$nbResERLib) {
                    $annonceemploirepere[$f].=$dataErLib['emploi_repere_libelle'];
            } 
            else {
                $annonceemploirepere[$f].=$dataErLib['emploi_repere_libelle'].", "; 
            }
            $cntLib++;
        }
        $f++;
        
    } 
}
//echo "<pre>nom";print_r($annonceetat); echo "</pre>";

//affichage
$meta['title']="Gestion des annonces sélectionnées | Particulier Emploi";
$meta['desc']="Gestion des annonces sélectionnés de l'espace de mise en relation de Particulier Emploi, le site de l'emploi à domicile ";
$pageActive = "favoris";
include_once(dirname(__FILE__).'/templates/header-espacepe.php');
include_once(dirname(__FILE__).'/templates/favoris.php');
//inclusion du formulaire de recherche
include_once(dirname(dirname(__FILE__)).'/recherche/templates/form-espacepe.php');
include_once(dirname(dirname(__FILE__)).'/common-templates/footer.php');
