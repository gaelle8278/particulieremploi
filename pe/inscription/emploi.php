<?php

/**
 * Gestion de l'étape 2 du parcours d'inscription: choix du métier
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

//arrivée par espace perso => prise en compte des valeurs de session
if(isset($_SESSION['utilisateur_id'])) {
    $type_compte=$_SESSION['utilisateur_groupe'];
} else {
    $type_compte=$_SESSION['type'];
}

//si type de compte pas valide => redirection
if(!in_array($type_compte, array('EMP','SAL')) ) {
    header('Location: /index.php');
    exit();
}

global $wpdb;

$tabDisplayError=array();
$params=array();
if(isset($_POST['emploi'])) {
    $_SESSION['emploi']=array();
    $fieldFilters = array(
        'jobSelect' =>  FILTER_VALIDATE_INT,
        'erSelect' =>  array('filter' => FILTER_VALIDATE_INT,
                            'flags' => FILTER_REQUIRE_ARRAY)
    );
    $params = filter_input_array(INPUT_POST, $fieldFilters);

    //@TODO compléter validation back
    $tabErrorMsg = array(
            'jobSelect' => "Le métier choisit n'est pas valide.",
            'erSelect' => "Le(s) emploi(s)-repère(s) choisi(s) ne sont pas valide(s)."
    );
    $tabEmptyMsg= array(
        'jobSelect' => "Veuillez sélectionner un métier"
    );
    $tabRequiredField = array('jobSelect');
    foreach($fieldFilters as $field => $filter) {
        if(in_array($field, $tabRequiredField) && empty($_POST[$field])) {
            //empty submitted field
            $tabDisplayError[$field]=$tabEmptyMsg[$field];
        } elseif(!empty($_POST[$field]) && $params[$field] === false) {
            //field not valid
            $tabDisplayError[$field]=$tabErrorMsg[$field];
        } elseif ( $_POST[$field] != $params[$field] ) {
            //field different after sanitization
            $tabDisplayError[$field]= 'Le champs contient des caractères non permis';
        }
    }

    //si pas d'erreurs enregistrement en session des informations et redirections conditionnelles
    if(empty($tabDisplayError)) {
        $urlRedirect = "/pe/inscription/conditions.php";

        $_SESSION['emploi']['metierid']=$params['jobSelect'];
        $_SESSION['emploi']['erSelect']="";
        if(!empty($params['erSelect'])) {
            $_SESSION['emploi']['erSelect']=implode(',',$params['erSelect']);
        }
        header("Location:".$urlRedirect);
        exit();
    }
}
    $meta['title']="Choix du métier | Particulier Emploi";
    $meta['desc']="Le site officiel de petites annonces gratuites pour l\'emploi a domicile entre particuliers: garde d\'enfants "
        . "(nounou, baby sitting), femme de ménage, assistante maternelle, jardinier ...";
    include_once(dirname(__FILE__).'/templates/header-inscription.php');
    include_once(dirname(__FILE__).'/templates/emploi.php');
    include_once(dirname(dirname(__FILE__)).'/common-templates/footer.php');
