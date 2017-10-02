<?php

/**
 * Gestion du module "Profil" de l'espace perso
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

//récupération des paramètres
if (isset($_GET) && !empty($_GET)) {
    $options = array(
        'part' => FILTER_SANITIZE_STRING, 
        'updatemsg' => FILTER_SANITIZE_STRING,
        'modif' => FILTER_SANITIZE_NUMBER_INT
    );
    $params = filter_input_array(INPUT_GET, $options);
} else if (isset($_POST) && !empty($_POST)) {
    $options = array(
        'part' => FILTER_SANITIZE_STRING,
        'civilite' => FILTER_SANITIZE_STRING,
        'nom' => FILTER_SANITIZE_STRING,
        'prenom' => FILTER_SANITIZE_STRING,
        'adresse' => FILTER_SANITIZE_STRING,
        'ville' => FILTER_SANITIZE_STRING,
        'mail' => FILTER_VALIDATE_EMAIL,
        'oldmdp' => FILTER_SANITIZE_STRING,
        'newmdp' => FILTER_SANITIZE_STRING,
        'confnewmdp' => FILTER_SANITIZE_STRING,
        'naissance' => FILTER_SANITIZE_NUMBER_INT,
        'codepostal' => FILTER_SANITIZE_STRING,
    );
    $params = filter_input_array(INPUT_POST, $options);
}

if(isset($params)) {
    //action switcher
    $action=$params['part']; 
    
    //si mise à jour du profil effectuée
    if(isset($params['modif']) && $params['modif']==1) {
        //si erreurs :affichage des erreurs
        if(isset($params['updatemsg'])) {
            $errorMessage=  str_replace('-', '<br />', $params['updatemsg']);
        }
        //sionon affichage du message indiquant que la mise à jour est ok
        else {
            $message="Mise à jour effectuée avec succès";
        }
    }
}

$utilisateurId = $_SESSION['utilisateur_id'];
global $wpdb;

//mise à jour des infos de profil
if(isset($action) && $action=="modifierdb") {
    
    $naissance = "01/01/".$params['naissance'];
    $naissance = datetodb($naissance, '/');
    
    $getMessage=[];
    $fieldToUpdate=array(
            'utilisateur_civilite' => $params['civilite'],
            'utilisateur_nom' => $params['nom'],
            'utilisateur_prenom' => $params['prenom'],
            'utilisateur_adresse' => $params['adresse'],
            'utilisateur_ville' => $params['ville'],
            'utilisateur_codepostal' => $params['codepostal'],
            'utilisateur_naissance' => $naissance);
    $formatFieldToUpdate=array(
            '%s',	
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%d'
        );
    
    //gestion du mot de passe
    $queryCheckMdp = "select
		utilisateur_password, utilisateur_mail
                from ". TBL_UTILISATEURS."
		where
		utilisateur_id = ".$utilisateurId;
    $dataCheckMdp=$wpdb->get_row($queryCheckMdp);
    $currentMdp=$dataCheckMdp->utilisateur_password;
    $login=$dataCheckMdp->utilisateur_mail;
    $checkCurrentMdp= encodeMD5PE($params['oldmdp']);
    
    if (!empty($params['newmdp'])) {
        //si la verification du mdp actuel est bonne => mise à jour
        if($currentMdp == $checkCurrentMdp ){
            $fieldToUpdate['utilisateur_password'] = encodeMD5PE($params['newmdp']);
            $formatFieldToUpdate[]='%s';
        } else {
            $getMessage[]= "Le vérification de l'ancien mot de passe a échoué. La mise à jour du mot de passe est impossible.";
        }
    }
    
    //gestion de l'adresse email 
    if(!empty($params['mail'])) {
        //verification si doublon
        $queryCheckMail= "select
                            count(*) as nb
			from ".TBL_UTILISATEURS." 
			where
                            utilisateur_mail = '".$params['mail']."'
                        AND utilisateur_id != ".$utilisateurId."
                        AND utilisateur_etat != 'SUP'";
        $checkMail = $wpdb->get_row($queryCheckMail);
        //si l'adresse email n'est pas déjà utilisée,
        // la mise à jour est autorisée
        if($checkMail->nb == 0) {
            $fieldToUpdate['utilisateur_mail'] = $params['mail'];
            $formatFieldToUpdate[]='%s';
        } else {
            $getMessage[]= "L'adresse email est déjà utilisée par un autre compte. L'adresse email n'a pas été mise à jour";
        }
    }
    
    
    //mise à jour
    $wpdb->update(
        TBL_UTILISATEURS, 
        $fieldToUpdate,
        array( 
            'utilisateur_id' =>  $utilisateurId,
        ),
        $formatFieldToUpdate,
        array( '%d' ) 
    );
    
    //redirection
    $urlRedirect="/pe/espace-pe/profil.php?modif=1";
    if(!empty($getMessage)) {
        $message=implode('-',$getMessage);
        $urlRedirect .= "&updatemsg=".urlencode($message);
        
    }
    header("Location: ".$urlRedirect);
    
}

//recup infos user
$queryUser = "select
		utilisateur_nom,
                utilisateur_prenom,
                utilisateur_naissance,
                utilisateur_civilite,
                utilisateur_codepostal,
                utilisateur_ville,
                utilisateur_adresse,
                utilisateur_mail,
                utilisateur_telephone,
                utilisateur_portable,
                utilisateur_etat,
                utilisateur_datecrea,
                utilisateur_datemodif,
                utilisateur_lastconnexion,
                utilisateur_cnil,
                utilisateur_csp,
                utilisateur_nbenfants,
                utilisateur_localisation
               from
		".TBL_UTILISATEURS."
               where
		utilisateur_id =". $utilisateurId;
$infos_user = $wpdb->get_row($queryUser);

$nom = $infos_user->utilisateur_nom;
$prenom = $infos_user->utilisateur_prenom;
//$vargroupe = $infos_user->utilisateur_groupe'];
$naissance = substr($infos_user->utilisateur_naissance, 0, 4);
$code_civilite=$infos_user->utilisateur_civilite;
$civilite = get_civilite($code_civilite);

$cpo = $infos_user->utilisateur_codepostal;
$ville = $infos_user->utilisateur_ville;
$adresse = $infos_user->utilisateur_adresse;
$mail = $infos_user->utilisateur_mail;
$telephone = $infos_user->utilisateur_telephone;
$portable = $infos_user->utilisateur_portable;
$etat = $infos_user->utilisateur_etat;
//$passeport = $infos_user->utilisateur_passeport'];
$datecrea = convert_datetime($infos_user->utilisateur_datecrea);
$datemodif = convert_datetime($infos_user->utilisateur_datemodif);
$lastconnexion = convert_datetime($infos_user->utilisateur_lastconnexion);
$cnil = $infos_user->utilisateur_cnil;
$csp = get_csp($infos_user->utilisateur_csp);
$nbenfants = $infos_user->utilisateur_nbenfants;
$localisation = get_localisation($infos_user->utilisateur_localisation);

//affichage
$meta['title']="Gestion du profil | Particulier Emploi";
$meta['desc']="Gestion du profil de l'espace de mise en relation de Particulier Emploi, le site de l'emploi à domicile ";
$pageActive = "profil";
include_once(dirname(__FILE__).'/templates/header-espacepe.php');
include_once(dirname(__FILE__).'/templates/profil.php');
include_once(dirname(dirname(__FILE__)).'/common-templates/footer.php');