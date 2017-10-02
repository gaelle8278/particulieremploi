<?php

/**
 * Gestion du module de mot de passe oublié
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

if (!empty($_GET)) {
    $options = array(
        'erreurEmail' => FILTER_SANITIZE_STRING, 
        'erreurCodePostal' => FILTER_SANITIZE_STRING
    );
    $params = filter_input_array(INPUT_GET, $options);
} else if (!empty($_POST)) {
    $options = array(
        'email' => FILTER_VALIDATE_EMAIL, 
        'codepostal' =>  FILTER_SANITIZE_STRING, 
        'envoyer' =>  FILTER_SANITIZE_STRING
    );
    $paramsPost= filter_input_array(INPUT_POST, $options);
}

//vérification des champs soumis
if($paramsPost != null){
   
    $messageEmpty = array (
        'email' => "L'adresse e-mail doit être indiquée",
        'codepostal' => "Le code postal doit être indiqué"
    );
    
    $tabError=[];
    foreach($options as $field => $value) { 
        if(empty($_POST[$field])) { 
            $tabError[$field] = $messageEmpty[$field] ;
        } 
    }
    //redirection si champs manquants
    if(!empty($tabError)) {
        $urlRedirect = '/pe/espace-pe/motdepasse.php?erreurEmail='.urlencode($tabError['email']).'&erreurCodePostal='.urlencode($tabError['codepostal']);
        header('Location: '.$urlRedirect);
        exit();
    }
}

global $wpdb;

//mise a jour du mot de passe
if(isset($paramsPost['envoyer'])) {
    $queryVerifCompte="
        SELECT utilisateur_groupe, 
            utilisateur_id, 
            utilisateur_mail, 
            utilisateur_codepostal
        FROM ".TBL_UTILISATEURS." 
        WHERE utilisateur_mail ='".$paramsPost['email']."'
        and utilisateur_etat!='SUP'";
    $infosCompte=$wpdb->get_row($queryVerifCompte);

    //si le compte est retrouvé
    if($paramsPost['email']==$infosCompte->utilisateur_mail && $paramsPost['codepostal']==$infosCompte->utilisateur_codepostal) {
        //changement du mot de passe
        $password = makePassword();
        $passwordMD5 = encodeMD5PE($password);
        $update=$wpdb->update(
                TBL_UTILISATEURS,
                array (
                    'utilisateur_password' => $passwordMD5
                ),
                array(
                    'utilisateur_id' => $infosCompte->utilisateur_id
                ),
                array(
                    '%s'
                ),
                array(
                    '%d'
                )
                
                );
        //envoie de l'email
        $type_compte= strtoupper($infosCompte->utilisateur_groupe);
        $to=$infosCompte->utilisateur_mail;
        include_once(dirname(dirname(__FILE__)).'/emails/email_motdepasse.php' );
        
        
        //message pour indiquer la mise à jour
        $message='Un nouveau mot de passe vous a été envoyé à votre adresse e-mail';
    } else {
        $message= "Le compte associé à l'e-mail et au code postal fournis n'existe pas.";
    }
    
}
$meta['title']="Récupération mot de passe | Particulier Emploi";
$meta['desc']="Récupération mot de passe de l'espace de mise en relation de Particulier Emploi, le site de l'emploi à domicile ";
include_once(dirname(__FILE__).'/templates/header-connespacepe.php');
include_once(dirname(__FILE__).'/templates/motdepasse.php');
include_once(dirname(dirname(__FILE__)).'/common-templates/footer.php');
