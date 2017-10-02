<?php

/**
 * Gestion du module "Mes offres/Mes annonces" de l'espace perso
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

if(!empty($_GET)) {
    $options = array(
        'part' => FILTER_SANITIZE_STRING, 
        'annonceid' => FILTER_SANITIZE_NUMBER_INT,
    );
    $params= filter_input_array(INPUT_GET, $options);
}

global $wpdb;

/****************************************
 * Suppression d'une annonce/offre 
 ****************************************/
if(isset($params['part']) && $params['part']=="supprimer") {
    $update=$wpdb->update(
                TBL_ANNONCES,
                array (
                    'annonce_etat' => 'SUPPRIME'
                ),
                array(
                    'annonce_id' => $params['annonceid'],
                    'annonce_idauteur' => $utilisateurId
                ),
                array(
                    '%s'
                ),
                array(
                    '%d',
                    '%d'
                )
                
            );
    header("Location: /pe/espace-pe/annonces.php");
    exit();
}


//récupération des annonces/offres de l'utilisateur
$queryAnnonces= "select
	  utilisateurs.utilisateur_civilite as civilite
    , utilisateurs.utilisateur_nom as nom
    , utilisateurs.utilisateur_prenom as prenom
    , annonces.annonce_id as annonceid
    , annonces.annonce_codepostal as codepostal
    , annonces.annonce_ville as ville
    , annonces.annonce_adresse as adresse
    , annonces.annonce_description as description
    , annonces.annonce_tauxhoraire as tauxhoraire
    , annonces.annonce_experience as experience
    , annonces.annonce_dureehebdomadaire as dureehebdomadaire
    , annonces.annonce_titremetier as metier
    , annonces.annonce_idmetier as idmetier
    , annonces.annonce_datecrea as annoncedatecrea
    , annonces.annonce_dateprisefonction as annoncedateprisefonction
    , annonces.annonce_visites as annoncevisites
FROM
    ".TBL_UTILISATEURS." as utilisateurs
    INNER JOIN ".TBL_ANNONCES." as annonces
        ON (utilisateurs.utilisateur_id = annonces.annonce_idauteur)
WHERE
	annonces.annonce_idauteur = ".$utilisateurId."
AND
	annonces.annonce_etat = 'ACTIF'";

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
       
        $annonceid[$f] = $data['annonceid'];
        $metier[$f] = $data['metier'];
        $idmetier[$f] = $data['idmetier'];
        
        $annoncevisites [$f] = $data ['annoncevisites'];
        
        
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


//affichage
$meta['title']="Gestion des annonces | Particulier Emploi";
$meta['desc']="Gestion des annonces de l'espace de mise en relation de Particulier Emploi, le site de l'emploi à domicile ";
$pageActive = "annonces";
include_once(dirname(__FILE__).'/templates/header-espacepe.php');
include_once(dirname(__FILE__).'/templates/annonces.php');
include_once(dirname(dirname(__FILE__)).'/common-templates/footer.php');