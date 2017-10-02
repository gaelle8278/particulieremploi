<?php

/**
 * Gestion de la première étape du parcours d'inscription : création du compte
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
if (isset($_GET) && !empty($_GET)) {
    $options = array(
        'type' => FILTER_SANITIZE_STRING,
        'idAnnonce' => FILTER_SANITIZE_STRING,
        'parcours' => FILTER_SANITIZE_STRING
    );
    $params = filter_input_array(INPUT_GET, $options);
} 

// si l'utilisateur tente d'accéder à l'inscription alors qu'il est déjà connecté
// redirection espace perso 
if( isset($_SESSION['utilisateur_id']) ){
    header('Location: /pe/espace-pe/compte.php');
    exit();
}

//mise en session de l'annonce si annonce choisie via la recherche ou pole emploi
//idAnnonce : paramètre optionnel
if(isset($params['idAnnonce'])) {
    $_SESSION['idAnnonce']=$params['idAnnonce'];
} else if(!isset($_SESSION['idAnnonce'])){
    $_SESSION['idAnnonce']="";
}
//type : paramètre obligatoire
if(isset($params['type'])) {
    $_SESSION['type']= strtoupper($params['type']);
}

//si type de compte pas valide 
// => redirection page d'accueil
if( !in_array($_SESSION['type'], array('EMP','SAL')) ) {
    header('Location: /index.php');
    exit();
} 
$type_compte=$_SESSION['type'];


global $wpdb;

$tabDisplayError=array();
$_SESSION['submitted-values']=array();

//traitement de l'inscription
if(isset($_POST['form-button'])) {
    //on vide la tabeau de session d'inscription
    $_SESSION['inscription']="";

    //on récupère les valeurs soumises
    $fieldFilters = array(
        'civilite' => FILTER_VALIDATE_INT,
        'nom' => FILTER_SANITIZE_STRING,
        'prenom' => FILTER_SANITIZE_STRING,
        'adresse' => FILTER_SANITIZE_STRING,
        'cpo' => FILTER_SANITIZE_STRING,
        'ville' => FILTER_SANITIZE_STRING,
        'telephone' => FILTER_SANITIZE_NUMBER_INT,
        'email' => FILTER_VALIDATE_EMAIL,
        'emailconfirm' => FILTER_VALIDATE_EMAIL,
        'mdp' => FILTER_SANITIZE_STRING,
        'mdpconfirm' => FILTER_SANITIZE_STRING,
        'idAnnonce' => FILTER_SANITIZE_STRING
    );
    $params = filter_input_array(INPUT_POST, $fieldFilters);
    
    //validation back
    /////////////////////////
    $tabErrorMsg = array(
            'civilite' => "Vous devez choisir entre Monsieur ou Madame",
            'email' => "L'email n'a pas un format valide"
    );
    $tabRequiredField = array('civilite','nom','prenom','adresse','cpo','ville','email','mdp','emailconfirm', 'mdpconfirm');
    foreach($fieldFilters as $field => $filter) {
        if(in_array($field, $tabRequiredField) && empty($_POST[$field])) {
            //empty submitted field
            $tabDisplayError[$field]='Veuillez remplir ce champ';
        } elseif(!empty($_POST[$field]) && $params[$field] === false) {
            //field not valid
            $tabDisplayError[$field]=$tabErrorMsg[$field];
        } elseif ( $_POST[$field] != $params[$field] ) {
            //field different after sanitization
            $tabDisplayError[$field]= 'Le champs contient des caractères non permis';
        }
    }
    //add specific checks after filtration
    //cpo
    if(!empty($params['cpo'])) {
        if(strlen($params['cpo']) != 5) {
            $tabDisplayError['cpo']= "Le code postal doit contenir 5 chiffres";
        }
    }
    //tel
    if(!empty($params['telephone'])) {
        if(strlen($params['telephone']) != 10) {
            $tabDisplayError['telephone']= "Le numéro de téléphone doit contenir 10 chiffres";
        }
    }
    //mdp
    if(!empty($params['mdp'])) {
        if(strlen($params['mdp']) < 6) {
            //lenght of mdp
            $tabDisplayError['mdp']= "Le mot de passe doit contenir au minimum 6 caractères";
        } else if( !preg_match("/^[a-z0-9_\.@]{6,}$/i", $params['mdp']) ) {
            // characters of mdp
            $tabDisplayError['mdp']= "Le mot de passe doit contenir au minimum 6 caractères alphanumériques, "
                    . "seuls les caractères _, \, . et @ sont également autorisés";
        } elseif ($params['mdp'] != $params['mdpconfirm']) {
            //equality with mdp confrm
            $tabDisplayError['mdpconfirm']= "Les mots de passe ne sont pas identiques";
        }
    }
    //email
    if ( !empty($params['email']) ) {
        //equality between email and confirmation of email
        if ( $params['email'] !== $params['emailconfirm']) {
            $tabDisplayError['emailconfirm']="Les emails ne sont pas identiques";
        }

        //availability of email
        // ERREUR dans la requete => plusieurs comptes à l'état VAL avec le même email peuvent existé !
        $queryCheckEmail= " SELECT count(*) as nb "
            . " FROM ".TBL_UTILISATEURS." "
            . " WHERE utilisateur_mail = '".$params['email']."' "
            . " and (utilisateur_etat='ACT' or utilisateur_etat='INS') ";
        $checkEmailResult=$wpdb->get_row($queryCheckEmail);
        $nbDuplicate = $checkEmailResult->nb;

        if( $nbDuplicate != 0) {
            $tabDisplayError['email'] = "Cet e-mail est déjà associé à un compte existant. Veuillez en indiquer un autre.";
        }
    }
    /////////////////////////////
    if (!empty($tabDisplayError)) {
        //si il y a des erreurs : stockage des valeurs soumisses pour réaffichage
        $_SESSION['submitted-values']=$_POST;

    } else {
        //si pas d'erreur, supprression du stockage des valeurs soumises
        if(isset($_SESSION['submitted-values'])) {
            unset($_SESSION['submitted-values']);
        }
        //si pas d'erreur, enregistrement en session des informations du formulaire et redirections conditionnelles
        $_SESSION['inscription']['mdp']       = $params['mdp'];
        $_SESSION['inscription']['nom']       = $params['nom'];
        $_SESSION['inscription']['prenom']    = $params['prenom'];
        $_SESSION['inscription']['civilite']  = $params['civilite'];
        $_SESSION['inscription']['adresse']   = $params['adresse'];
        $_SESSION['inscription']['ville']     = $params['ville'];
        $_SESSION['inscription']['telephone'] = $params['telephone'];
        $_SESSION['inscription']['cpo']       = $params['cpo'];
        $_SESSION['inscription']['email']     = $params['email'];

        //Redirection
        //accès direct à l'espace perso
        if ($_POST['form-button'] == 'contact' || isset($_POST['contact'])) {
            $urlRedirect                          = "/pe/inscription/recapitulation.php";
            $_SESSION['inscription']['sansdepot'] = 1;
        }
        //dépot d'annonce
        elseif ($_POST['form-button'] == 'depot' || isset($_POST['depot'])) {
            $urlRedirect                          = "/pe/inscription/emploi.php";
            $_SESSION['inscription']['sansdepot'] = 0;
        }

        //redirection
        header("Location: ".$urlRedirect);
        exit();
    }
}
/*echo "<pre>";print_r($params);echo "</pre>";
echo "<pre>";print_r($_SESSION);echo "</pre>";
echo "<pre>";print_r($tabDisplayError);echo "</pre>";*/

//affichage du formulaire d'inscription
$meta['title']="Inscription | Particulier Emploi";
$meta['desc']="Formulaire d'inscription pour accéder à un espace de mise en relation entre salariés et particuliers employeurs ";
include_once(dirname(__FILE__).'/templates/header-inscription.php');
include_once(dirname(__FILE__).'/templates/compte.php');
include_once(dirname(dirname(__FILE__)).'/common-templates/footer.php');


   


