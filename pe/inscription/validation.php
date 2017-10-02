<?php
/*
 * Page l'affichage pour les comptes non activés
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
$error=false;
$tabDisplayError=array();
if (isset($_GET) && !empty($_GET)) {
    $fieldFilters = array(
        'login' => FILTER_VALIDATE_EMAIL,
        'demande' => FILTER_VALIDATE_INT
    );
    $params = filter_input_array(INPUT_GET, $fieldFilters);
}


$tabRequiredField = array('login');
foreach($fieldFilters as $field => $filter) {
    if(in_array($field, $tabRequiredField) && empty($_GET[$field])) {
        $error=true;
    } elseif(!empty($_GET[$field]) && $params[$field] === false) {
        $error=true;
    } elseif ( $_GET[$field] != $params[$field] ) {
        //field different after sanitization
        $error=true;
    }
}

if($error==true) {
    header("Location: /404.php");
    exit();
}

$queryUser= " SELECT "
        . "utilisateur_groupe "
            . " FROM ".TBL_UTILISATEURS." "
            . " WHERE utilisateur_mail = '".$params['login']."' ";
$infosUser=$wpdb->get_row($queryUser);

if($infosUser==null) {
    $tabDisplayError[]= "Le compte associé à l'adresse e-mail ".$params['login']." n'existe pas.";
} else {
    $type_compte=$infosUser->utilisateur_groupe;

    if(isset($params['demande']) && $params['demande'] == 1) {
        //prépération du compte et envoi du mail d'activation
        $token         = uniqid(rand(), true);
        $tokenValidity = strtotime("+2 days");

        $update         = $wpdb->update(
            TBL_UTILISATEURS,
            array(
                'utilisateur_jeton' => $token,
                'utilisateur_jeton_valide' => $tokenValidity
            ), array(
                'utilisateur_mail' => $params['login']
            ), array(
                '%s',
                '%d'
            ), array(
                '%s'
            )
        );

        $to = $params['login'];
        $linkActivation="/pe/inscription/activation.php?login=".$params['login']."&token=".$token;
        include_once(dirname(dirname(__FILE__)).'/emails/email_activation.php' );

    }
}

$meta['title']="Demande d'activation | Particulier Emploi";
$meta['desc']="Le site officiel de petites annonces gratuites pour l'emploi a domicile entre particuliers: "
        . "garde d'enfants (nounou, baby sitting), femme de ménage, assistante maternelle, jardinier ...";
include_once(dirname(__FILE__).'/templates/header-inscription.php');
include_once(dirname(__FILE__).'/templates/validation.php');
include_once(dirname(dirname(__FILE__)).'/common-templates/footer.php');




