<?php
/**
 * Gestion de l'activation du compte après inscription
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
$tabDisplayError=array();
if (isset($_GET) && !empty($_GET)) {
    $fieldFilters = array(
        'token' => FILTER_SANITIZE_STRING,
        'login' => FILTER_VALIDATE_EMAIL
    );
    $params = filter_input_array(INPUT_GET, $fieldFilters);
}

$tabErrorMsg = array(
    'login' => "Le login doit être une adresse e-mail valide."
);
$tabRequiredField = array('token','login');
foreach($fieldFilters as $field => $filter) {
    if(in_array($field, $tabRequiredField) && empty($_GET[$field])) {
        $tabDisplayError[]='Le champ '.$field.' est manquant';
    } elseif(!empty($_GET[$field]) && $params[$field] === false) {
        $tabDisplayError[]=$tabErrorMsg[$field];
    } elseif ( $_GET[$field] != $params[$field] ) {
        //field different after sanitization
        $tabDisplayError[]= 'Le champs '.$field.' contient des caractères non permis';
    }
}

if(empty($tabDisplayError)) {
    //verification du token
    $queryUser= " SELECT "
        . "utilisateur_id, "
        . "utilisateur_groupe, "
        . "utilisateur_etat, "
        . "utilisateur_mail, "
        . "utilisateur_jeton, "
        . "utilisateur_jeton_valide "
            . " FROM ".TBL_UTILISATEURS." "
            . " WHERE utilisateur_mail = '".$params['login']."' ";
    $infosUser=$wpdb->get_row($queryUser);

    $today=strtotime("now");
    if($infosUser==null) {
        //pas de compte avec ce mail
        $tabDisplayError[]= "Le compte associé à l'adresse e-mail ".$params['login']." n'existe pas.";
    } else {
        //compte pas dans le bon état
        if($infosUser->utilisateur_etat != "VAL") {
            if(isset($_SESSION['utilisateur_id']) && !empty($_SESSION['utilisateur_id'])) {
                $linkEPE='/pe/espace-pe/compte.php';
            } else {
                $linkEPE='/pe/espace-pe/connexion.php';
            }
            $tabDisplayError[]= "Le compte associé à l'adresse e-mail ".$params['login']." est déjà actif.<br><br>"
                . "<a href='".$linkEPE."' title='Accès à mon espace de mise en relation' class='text-bold content-link'>"
                . "Accéder à mon espace de mise en relation</a>";
        } else if ($infosUser->utilisateur_jeton != $params['token']) {
            //token ne correspond pas
            $tabDisplayError[]= "Votre compte n'a pas pu être activé. Pour tenter une nouvelle activation, veuillez cliquer sur le lien ci-dessous "
                . " afin de recevoir un autre lien de validation : "
                . "<div class='bar_call_buttons'>"
                . "<a class='call_button' href='/pe/inscription/validation.php?login=".$params['login']."&demande=1' >"
                . "Envoyez-moi un e-mail de validation</a></div>";
        } elseif ($infosUser->utilisateur_jeton_valide < $today) {
            //validité du lien d'activation dépassé
            $tabDisplayError[]= "L'activation n'est plus valide. Veuillez cliquer sur le lien ci-dessous "
                . " pour recevoir un autre lien de validation : "
                . "<div class='bar_call_buttons'>"
                . "<a class='call_button' href='/pe/inscription/validation.php?login=".$params['login']."&demande=1' >"
                . "Envoyez-moi un e-mail de validation</a></div>";
        } else {
            //tout est bon le compte est activé et la date de validation du compte mise à jour
            $fieldToUpdate = array(
                'utilisateur_etat' => "ACT",
                'utilisateur_jeton' => "",
                'utilisateur_jeton_valide' => "",
                'utilisateur_datevalidation' => current_time('mysql', 1),
            );
            $formatFieldToUpdate = array(
                '%s',
                '%s',
                '%s',
                '%s'
            );
            $update = $wpdb->update(
                TBL_UTILISATEURS,
                $fieldToUpdate,
                array(
                    'utilisateur_id' => $infosUser->utilisateur_id
                ), 
                $formatFieldToUpdate,
                array(
                    '%d'
                )
            );


            //activation des annonces en attente
            $updateAnnonce = $wpdb->update(
                TBL_ANNONCES,
                array(
                    'annonce_etat' => "ACTIF"
                    ),
                array(
                    'annonce_idauteur' => $infosUser->utilisateur_id,
                    'annonce_etat' => 'EN_ATTENTE'
                    ),
                array(
                    '%s'
                ),
                array(
                    '%d',
                    '%s'
                )
            );

            //vérification s'il y a une annonce en favori = une annonce préalablement choisi à l'inscription
            $queryFavAnnonce= " SELECT maselection_annonceid "
            . " FROM ".TBL_FAVORIS." "
            . " WHERE maselection_utilisateurid = '".$infosUser->utilisateur_id."' ";
            $infosFavAnnonce=$wpdb->get_row($queryFavAnnonce);

            if($infosFavAnnonce != null) {
                $insConnexion['idAnnonce'] = $infosFavAnnonce->maselection_annonceid;
            }

            //envoi du mail d'inscription
            $to = $params['login'];
            $type_compte=$infosUser->utilisateur_groupe;
            $email=$params['login'];
            include_once(dirname(dirname(__FILE__)).'/emails/email_inscription.php' );

        }
    }
}

$meta['title']="Activation compte | Particulier Emploi";
$meta['desc']="Le site officiel de petites annonces gratuites pour l'emploi a domicile entre particuliers: "
        . "garde d'enfants (nounou, baby sitting), femme de ménage, assistante maternelle, jardinier ...";
include_once(dirname(__FILE__).'/templates/header-inscription.php');
include_once(dirname(__FILE__).'/templates/activation.php');
include_once(dirname(dirname(__FILE__)).'/common-templates/footer.php');