<?php

/**
 * Gestion de l'étape 4 du parcours d'inscription : récapitulation et validation
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

$params=array();
$tabErrorsValid=array();

$type_compte=$_SESSION['type'];
//si type de compte pas valide => redirection
if(!in_array($type_compte, array('EMP','SAL')) ) {
    header('Location: /index.php');
    exit();
}


global $wpdb;

$inscription=false;
if (isset($_POST['recap'])) {

    $options = array(
        'poleemploi' => array( 'filter' => FILTER_VALIDATE_BOOLEAN ),
        'cgu' => array( 'filter' => FILTER_VALIDATE_BOOLEAN )
    );
    $params = filter_input_array(INPUT_POST, $options);


    if (!empty($params['cgu'])) {
        $cgu = 1;
    } else {
        $cgu = 0;
    }
    if (!empty($params['poleemploi'])) {
        $poleemploi = 1;
    } else {
        $poleemploi = 0;
    }

    //1. enregistrement de l'utilisateur
    ///////////////////////////
    $naissance = '0000-01-01';
    $mdp = encodeMD5PE($_SESSION['inscription']['mdp']);
    $token=uniqid(rand(), true);
    $tokenValidity=strtotime("+2 days");
    $etat="VAL";

    $insertAnnonce="";
    $insert=$wpdb->insert(
                TBL_UTILISATEURS,
                array(
                    'utilisateur_groupe' => $_SESSION['type'],
                    'utilisateur_nom' => $_SESSION['inscription']['nom'],
                    'utilisateur_prenom' => $_SESSION['inscription']['prenom'],
                    'utilisateur_naissance' => $naissance,
                    'utilisateur_civilite' => $_SESSION['inscription']['civilite'],
                    'utilisateur_adresse' => $_SESSION['inscription']['adresse'],
                    'utilisateur_ville' => $_SESSION['inscription']['ville'],
                    'utilisateur_telephone' => $_SESSION['inscription']['telephone'],
                    'utilisateur_codepostal' => $_SESSION['inscription']['cpo'],
                    'utilisateur_etat' => $etat,
                    'utilisateur_datecrea' => current_time('mysql', 1),
                    'utilisateur_mail' => $_SESSION['inscription']['email'],
                    'utilisateur_password' => $mdp,
                    'utilisateur_cnil' => 1,
                    'utilisateur_cgu' => $cgu,
                    'utilisateur_jeton' => $token,
                    'utilisateur_jeton_valide' => $tokenValidity
                ),
                array(
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%d',
                    '%s',
                    '%s',
                    '%d',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%d',
                    '%d',
                    '%s',
                    '%d'
                )
    );
    if($insert > 0 ) {
        //id de l'auteur inséré
        $id  = $wpdb->insert_id;

        $etatAnnonce="EN_ATTENTE";
        //2. enregistrement de l'annonce
        //////////////
        if(isset($_SESSION['annonce']) && !empty($_SESSION['annonce'])) {
            $fieldToInsert = array(
                'annonce_idauteur' => $id,
                'annonce_type' => strtoupper($_SESSION['type']),
                'annonce_datecrea' => current_time('mysql', 1),
                'annonce_etat' => $etatAnnonce,
                'annonce_idmetier' => $_SESSION['annonce']['annonce_idmetier'],
                'annonce_titremetier' => $_SESSION['annonce']['annonce_intitulemetier'],
                'annonce_latitude' => $_SESSION['annonce']['annonce_latitude'],
                'annonce_longitude' => $_SESSION['annonce']['annonce_longitude'],
                'annonce_experience' => $_SESSION['annonce']['annonce_experience'],
                'annonce_description' => $_SESSION['annonce']['annonce_description'],
                'annonce_tauxhoraire' => $_SESSION['annonce']['annonce_tauxhoraire'],
                'annonce_dureehebdomadaire' => $_SESSION['annonce']['annonce_dureehebdomadaire'],
                'annonce_dateprisefonction' => str_replace('-','',$_SESSION['annonce']['annonce_dateprisefonction']),
                'annonce_adresse' => $_SESSION['annonce']['annonce_adresse'],
                'annonce_codepostal' => $_SESSION['annonce']['annonce_codepostal'],
                'annonce_ville' => $_SESSION['annonce']['annonce_ville'],
                'annonce_localisation' => $_SESSION['annonce']['annonce_localisation'],
                'annonce_agrement' => $_SESSION['annonce']['annonce_agrement'],
                'annonce_dateagrement' => str_replace('-','',$_SESSION['annonce']['annonce_dateagrement']),
                'annonce_nbenfants1' => $_SESSION['annonce']['annonce_nbenfants1'],
                'annonce_nbenfants2' => $_SESSION['annonce']['annonce_nbenfants2'],
                'annonce_nbenfants3' => $_SESSION['annonce']['annonce_nbenfants3'],
                'annonce_nbenfants4' => $_SESSION['annonce']['annonce_nbenfants4'],
                'annonce_dejanounou' => $_SESSION['annonce']['annonce_dejanounou'],
                'annonce_dejafamille' => $_SESSION['annonce']['annonce_dejafamille'],
                'annonce_gp_codepostal' => $_SESSION['annonce']['annonce_gp_codepostal'],
                'annonce_gp_ville' => $_SESSION['annonce']['annonce_gp_ville'],
                'annonce_gp_localisation' => $_SESSION['annonce']['annonce_gp_localisation'],
                'annonce_latitude2' => $_SESSION['annonce']['annonce_latitude2'],
                'annonce_longitude2' => $_SESSION['annonce']['annonce_longitude2'],
                'annonce_nbenfgardes' => $_SESSION['annonce']['annonce_nbenfgardes'],
                'annonce_agenfants1' => $_SESSION['annonce']['annonce_agenfants1'],
                'annonce_agenfants2' => $_SESSION['annonce']['annonce_agenfants2'],
                'annonce_agenfants3' => $_SESSION['annonce']['annonce_agenfants3'],
                'annonce_agenfants4' => $_SESSION['annonce']['annonce_agenfants4'],
                'annonce_agenfants5' => $_SESSION['annonce']['annonce_agenfants5'],
                'annonce_agenfants6' => $_SESSION['annonce']['annonce_agenfants6'],
                'annonce_nomprenom' => $_SESSION['inscription']['nom']." ".$_SESSION['inscription']['prenom'],
                'annonce_diffusionpe' => $poleemploi
            );
            $formatFieldToInsert = array(
                '%d',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%f',
                '%f',
                '%s',
                '%s',
                '%f',
                '%f',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%f',
                '%f',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
            );

            //insertion de l'annonce
            $insertAnnonce=$wpdb->insert(
                    TBL_ANNONCES,
                    $fieldToInsert,
                    $formatFieldToInsert
            );

            //si annonce insérée => ajout des ER associés
            if($insertAnnonce > 0) {
                //1 récupération de l'id de l'annonce nouvelle créee
                $idAnnonceUpdated  = $wpdb->insert_id;
                //2 ajout des associations annonce/ER si besoin
                if(!empty($_SESSION['emploi']['erSelect'])) {
                    $listER = explode(',',$_SESSION['emploi']['erSelect']);
                    foreach($listER as $idER) {
                        $wpdb->insert(
                            TBL_ASSOC_ER_ANNONCE,
                            array(
                                'annonce_id'=>$idAnnonceUpdated,
                                'emploi_repere_id'=>$idER
                            ),
                            array(
                                '%d',
                                '%d',
                            )
                        );
                    }
                }

            }
        }
        ////////////////////////////////
    }
    
    //3. si pas d'erreur lors de insertions => finalisation puis redirection
    if ($insert !== false && $insertAnnonce !== false) {
        //on envoie à Pole Emploi le fichier des annonces => désactivé
        if($poleemploi==1 && $type_compte=='EMP') {
            //include_once("flux/envoi_fichier_pole_emploi.php");
        }

        //on stocke en favori l'annonce choisie
        if(!empty($_SESSION['idAnnonce'])) {
            $wpdb->insert(
                TBL_FAVORIS,
                array(
                    'maselection_utilisateurid'=> $id,
                    'maselection_annonceid' => $_SESSION['idAnnonce'],
                    'maselection_datecrea' => current_time('mysql', 1)
                ),
                array(
                    '%d',
                    '%d',
                    '%s'
                )

            );
        } 

        //envoi de l'email d'activation
        $to = $_SESSION['inscription']['email'];
        $linkActivation="/pe/inscription/activation.php?login=".$_SESSION['inscription']['email']."&token=".$token;
        include_once(dirname(dirname(__FILE__)).'/emails/email_activation.php' );

        //on détruit les tableaux de session ayant servi à l'inscription
        unset($_SESSION['type']);
        unset($_SESSION['inscription']);
        unset($_SESSION['emploi']);
        unset($_SESSION['annonce']);
        unset($_SESSION['idAnnonce']);

        //redirection
        $inscription=TRUE;

    } else {
       $tabErrorsValid['error']="Erreur lors de l'enregistrement. Veuillez réessayer ultérieurement";
    }
  
}
if($inscription==TRUE) {
    $meta['title']="Validation | Particulier Emploi";
} else {
    $meta['title']="Récapitulation | Particulier Emploi";
}
$meta['desc']="Le site officiel de petites annonces gratuites pour l'emploi a domicile entre particuliers: "
        . "garde d'enfants (nounou, baby sitting), femme de ménage, assistante maternelle, jardinier ...";
include_once(dirname(__FILE__).'/templates/header-inscription.php');
if($inscription==TRUE) {
    include_once(dirname(__FILE__).'/templates/confirmation.php');
} else {
    include_once(dirname(__FILE__).'/templates/recapitulation.php');
}
include_once(dirname(dirname(__FILE__)).'/common-templates/footer.php');
