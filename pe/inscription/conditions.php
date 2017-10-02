<?php

/**
 * Gestion de l'étape 3 du parcours d'inscription : description de l'annonce
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
//arrivée par espace perso pour modifier une annonce => prise e compte des valeurs de session
if(isset($_SESSION['utilisateur_id'])) {
    $type_compte=$_SESSION['utilisateur_groupe'];
    if (isset($_GET) && !empty($_GET)) {
        $options = array(
            'metierid' =>  FILTER_SANITIZE_NUMBER_INT
        );
        $params = filter_input_array(INPUT_GET, $options);
        $_SESSION['emploi']['metierid']=$params['metierid'];
        $modifAnnonce=1;
    }

} else {
    $type_compte=$_SESSION['type'];
}

//si type de compte pas valide => redirection
if(!in_array($type_compte, array('EMP','SAL')) ) {
    header('Location: /index.php');
    exit();
}


$tabDisplayError=array();
$_SESSION['submitted-values']=array();

global $wpdb;

if(isset($_POST['emploi'])) {
    $fieldFilters = array(
        'metier' => FILTER_SANITIZE_STRING,
        'agrement' => FILTER_SANITIZE_STRING,
        'dateagrement'  => FILTER_SANITIZE_STRING,
        'dejanounou'=> FILTER_SANITIZE_NUMBER_INT,
        'dejafamille' =>  FILTER_SANITIZE_NUMBER_INT,
        'gp_codepostal' =>  FILTER_SANITIZE_STRING,
        'gp_ville' =>  FILTER_SANITIZE_STRING,
        'gp_localisation' => FILTER_SANITIZE_STRING,
        'geoadresse2' => FILTER_SANITIZE_STRING,
        'annonce_nbenfgardes' => FILTER_SANITIZE_NUMBER_INT,
        'agenfants1' => FILTER_SANITIZE_STRING,
        'agenfants2' => FILTER_SANITIZE_STRING,
        'agenfants3' => FILTER_SANITIZE_STRING,
        'agenfants4' => FILTER_SANITIZE_STRING,
        'agenfants5' => FILTER_SANITIZE_STRING,
        'agenfants6' => FILTER_SANITIZE_STRING,
        'experience' => FILTER_SANITIZE_STRING,
        'particularites' => FILTER_SANITIZE_STRING,
        'tauxhoraire' =>  FILTER_VALIDATE_FLOAT,
        'dateprisefonction' => FILTER_SANITIZE_STRING,
        'durehebdojs' => FILTER_VALIDATE_FLOAT,
        'nbenfants1' => FILTER_SANITIZE_NUMBER_INT,
        'nbenfants2' =>FILTER_SANITIZE_NUMBER_INT,
        'nbenfants3' => FILTER_SANITIZE_NUMBER_INT,
        'nbenfants4' => FILTER_SANITIZE_NUMBER_INT,
        'adresse' => FILTER_SANITIZE_STRING,
        'codepostal' => FILTER_SANITIZE_STRING,
        'ville' => FILTER_SANITIZE_STRING,
        'geoadresse' => FILTER_SANITIZE_STRING
    );
    $params = filter_input_array(INPUT_POST, $fieldFilters);
    // 0. faire la validation back
    /////////////////////////
    $tabErrorMsg = array(
            'tauxhoraire' => "Le taux horaire doit être un nombre",
            'durehebdojs' => "La durée hebdomadaire doit être un nombre"
    );
    $tabRequiredField = array('experience','tauxhoraire','dateprisefonction','codepostal');
    foreach($fieldFilters as $field => $filter) {
        if(in_array($field, $tabRequiredField) && empty($_POST[$field])) {
            //empty submitted field
            $tabDisplayError[$field]='Veuillez renseigner ce champ';
        } elseif(!empty($_POST[$field]) && $params[$field] === false) {
            //field not valid
            $tabDisplayError[$field]=$tabErrorMsg[$field];
        } /*elseif ( $_POST[$field] != $params[$field] ) {
            //field different after sanitization
            $tabDisplayError[$field]= 'Le champs contient des caractères non permis';
        }*/
    }
    //add specific checks after filtration
    //cp
    if(!empty($params['codepostal'])) {
        if(strlen($params['codepostal']) != 5) {
            $tabDisplayError['codepostal']= "Le code postal doit contenir 5 chiffres";
        }
    }
    if(!empty($params['gp_codepostal'])) {
        if(strlen($params['gp_codepostal']) != 5) {
            $tabDisplayError['gp_codepostal']= "Le code postal doit contenir 5 chiffres";
        }
    }
    //date
    if(!empty($params['dateprisefonction'])) {
        if(!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $params['dateprisefonction'])) {
            $tabDisplayError['dateprisefonction'] = "La date n'est pas valide";
        }
    }
    if(!empty($params['dateagrement'])) {
        if(!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $params['dateagrement'])) {
            $tabDisplayError['dateagrement'] = "La date n'est pas valide";
        }
    }
    ///////////////////////////////

    if (!empty($tabDisplayError)) {
        //si il y a des erreurs : stockage des valeurs soumisses pour réaffichage
        $_SESSION['submitted-values']=$_POST;

    } else {
        //si pas d'erreur, supprression du stockage des valeurs soumises
        if(isset($_SESSION['submitted-values'])) {
            unset($_SESSION['submitted-values']);
        }

        //1. récupération et formatage des données nécessaires
        list( $params['metierid'], $params['intitulemetier']) = explode("|",$params['metier']);
        list( $params['latitude'], $params['longitude']) = explode("/",$params['geoadresse']);

        //si deja famille l'adresse est renseignée et validée
        if($params['dejafamille'] == 1) {
            list( $params['latitude2'], $params['longitude2']) = explode("/",$params['geoadresse2']);
        }
        //si pas de famille pas d'addresse de la famille et si annonce salarié pas de nombre d'enfants gardés
        else {
            $params['latitude2']='';
            $params['longitude2']='';
            $params['gp_codepostal']='';
            $params['gp_ville']='';
            $params['gp_localisation']='';
            if($type_compte=="SAL") {
                $params['annonce_nbenfgardes']=0;
            }
        }

        ////si on est dans l'espace perso => ajout de l'annonce
        ///////////////////////////////////////////////////////////////////
        if(isset($_SESSION['utilisateur_id'])) {
            $params['annonce_etat'] = "ACTIF";

            //2. préparation des tablaux pour insertion des données
            $fieldToInsert = array(
                'annonce_idauteur' => $_SESSION['utilisateur_id'],
                'annonce_type' => strtoupper($_SESSION['utilisateur_groupe']),
                'annonce_datecrea' => current_time('mysql', 1),
                'annonce_etat' => $params['annonce_etat'],
                'annonce_idmetier' => $params['metierid'],
                'annonce_titremetier' => $params['intitulemetier'],
                'annonce_latitude' => $params['latitude'],
                'annonce_longitude' => $params['longitude'],
                'annonce_experience' => $params['experience'],
                'annonce_description' => $params['particularites'],
                'annonce_tauxhoraire' => $params['tauxhoraire'],
                'annonce_dureehebdomadaire' => $params['durehebdojs'],
                'annonce_dateprisefonction' => datetodb($params['dateprisefonction'], '/'),
                'annonce_adresse' => $params['adresse'],
                'annonce_codepostal' => $params['codepostal'],
                'annonce_ville' => $params['ville'],
                'annonce_localisation' => $params['localisation'],
                'annonce_agrement' => $params['agrement'],
                'annonce_dateagrement' => datetodb($params['dateagrement'], '/'),
                'annonce_nbenfants1' => $params['nbenfants1'],
                'annonce_nbenfants2' => $params['nbenfants2'],
                'annonce_nbenfants3' => $params['nbenfants3'],
                'annonce_nbenfants4' => $params['nbenfants4'],
                'annonce_dejanounou' => $params['dejanounou'],
                'annonce_dejafamille' => $params['dejafamille'],
                'annonce_gp_codepostal' => $params['gp_codepostal'],
                'annonce_gp_ville' => $params['gp_ville'],
                'annonce_gp_localisation' => $params['gp_localisation'],
                'annonce_latitude2' => $params['latitude2'],
                'annonce_longitude2' => $params['longitude2'],
                'annonce_nbenfgardes' => $params['annonce_nbenfgardes'],
                'annonce_agenfants1' => $params['agenfants1'],
                'annonce_agenfants2' => $params['agenfants2'],
                'annonce_agenfants3' => $params['agenfants3'],
                'annonce_agenfants4' => $params['agenfants4'],
                'annonce_agenfants5' => $params['agenfants5'],
                'annonce_agenfants6' => $params['agenfants']
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
                '%s'
            );

            //3. mise à jour ou insertion
                //Récupération des différents id métier deja present dans les annonces de l'utilisateur
            /*$reqMetierUpdate = "SELECT DISTINCT annonce_idmetier
                        FROM ".TBL_ANNONCES."
                        WHERE (annonce_etat = 'ACTIF' OR annonce_etat = 'INS') AND annonce_idauteur='".$_SESSION['utilisateur_id']."'";
            $resMetierUpdate = $wpdb->get_results($reqMetierUpdate, ARRAY_A);
            $annoncemetierutilisateur = array();
            foreach($resMetierUpdate as $data){
                $annoncemetierutilisateur[] = $data['annonce_idmetier'];
            }
            //TODO => notion de passport abandonnée

            // si l'utilisateur a deja une annonce dans ce métier
            // on update l'annonce correspondante
            if(in_array( $params['metierid'],$annoncemetierutilisateur)){
                $update=$wpdb->update(
                    TBL_ANNONCES,
                    $fieldToInsert,
                    array(
                        'annonce_idauteur' => $_SESSION['utilisateur_id'],
                        'annonce_idmetier' => $params['metierid']
                    ),
                    $formatFieldToInsert,
                    array(
                        '%d',
                        '%d',
                    )
                );

                //02/2016 nouvelle classif : mise à jour des emplois-reperes associés à l'annonce
                //1 récupération de l'id de l'annonce
                $qidAnnonce= "select annonce_id from
                         ".TBL_ANNONCES."
                         where annonce_idmetier = ".$params['metierid']."
                         AND annonce_idauteur=".$_SESSION['utilisateur_id'];

                $rowidAnnonce=$wpdb->get_row($qidAnnonce);
                $idAnnonceUpdated=$rowidAnnonce->annonce_id;
                //2 suppression des entrées existantes
                $wpdb->delete(
                        TBL_ASSOC_ER_ANNONCE,
                        array(
                            'annonce_id' => $idAnnonceUpdated
                        )
                    );
                //3 ajout des nouvelles entrées s'il y en a
                if(!empty($_SESSION['emploi']['erSelect'])) {
                    $idERSelected=explode(',',$_SESSION['emploi']['erSelect']);
                    foreach ($idERSelected as $idER) {
                        $wpdb->insert(
                            TBL_ASSOC_ER_ANNONCE,
                            array(
                                'annonce_id' => $idAnnonceUpdated,
                                'emploi_repere_id' => $idER
                            ),
                            array(
                                '%d',
                                '%d',
                            )
                        );
                    }
                }
            }
            //sinon ajout de l'annonce
            else { */
                //insertion de l'annonce
                $insert=$wpdb->insert(
                    TBL_ANNONCES,
                    $fieldToInsert,
                    $formatFieldToInsert
                );

                //si annonce insérée => ajout des ER associés
                if($insert > 0) {
                    //02/2016 nouvelle classif : les annonces peuvent être liées à des emplois-repères
                    //1 récupération de l'id de l'annonce nouvelle créee
                    $idAnnonceUpdated  = $wpdb->insert_id;
                    //2 ajout des associations annonce/ER si besoin
                    if(!empty($_SESSION['emploi']['erSelect'])) {
                        //$idERSelected=explode(',',$params['emploirepere']);
                        foreach($_SESSION['emploi']['erSelect'] as $idER) {
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
            //}
            //4. si pas d'erreur => redirection
            //if ($update !== false || $insert !== false) {
            if ($insert !== false) {
                header("Location: /pe/espace-pe/annonces.php");
                exit();
            } else {
                $tabErrorsValid['error']="Erreur lors de l'enregistrement. Veuillez réessayer ultérieurement";
            }
        }
        //si l'on vient du parcours d'inscription
        ////////////////////////////////////////////
        else {
            //mise en session des valeurs
            $_SESSION['annonce']=array();
            $_SESSION['annonce']['annonce_idmetier'] = $params['metierid'];
            $_SESSION['annonce']['annonce_intitulemetier'] = $params['intitulemetier'];
            $_SESSION['annonce']['annonce_latitude'] = $params['latitude'];
            $_SESSION['annonce']['annonce_longitude'] = $params['longitude'];
            $_SESSION['annonce']['annonce_experience'] = $params['experience'];
            $_SESSION['annonce']['annonce_description'] = $params['particularites'];
            $_SESSION['annonce']['annonce_tauxhoraire'] = $params['tauxhoraire'];
            $_SESSION['annonce']['annonce_dureehebdomadaire'] = $params['durehebdojs'];
            $_SESSION['annonce']['annonce_dateprisefonction'] = dateFormat($params['dateprisefonction']);
            $_SESSION['annonce']['annonce_adresse'] = $params['adresse'];
            $_SESSION['annonce']['annonce_codepostal'] = $params['codepostal'];
            $_SESSION['annonce']['annonce_ville'] = $params['ville'];
            $_SESSION['annonce']['annonce_localisation'] = $params['localisation'];
            $_SESSION['annonce']['annonce_agrement'] = $params['agrement'];
            $_SESSION['annonce']['annonce_dateagrement'] = dateFormat($params['dateagrement']);
            $_SESSION['annonce']['annonce_nbenfants1'] = $params['nbenfants1'];
            $_SESSION['annonce']['annonce_nbenfants2'] = $params['nbenfants2'];
            $_SESSION['annonce']['annonce_nbenfants3'] = $params['nbenfants3'];
            $_SESSION['annonce']['annonce_nbenfants4'] = $params['nbenfants4'];
            $_SESSION['annonce']['annonce_dejanounou'] = $params['dejanounou'];
            $_SESSION['annonce']['annonce_dejafamille'] = $params['dejafamille'];
            $_SESSION['annonce']['annonce_gp_codepostal'] = $params['gp_codepostal'];
            $_SESSION['annonce']['annonce_gp_ville'] = $params['gp_ville'];
            $_SESSION['annonce']['annonce_gp_localisation'] = $params['gp_localisation'];
            $_SESSION['annonce']['annonce_latitude2'] = $params['latitude2'];
            $_SESSION['annonce']['annonce_longitude2'] = $params['longitude2'];
            $_SESSION['annonce']['annonce_nbenfgardes'] = $params['annonce_nbenfgardes'];
            $_SESSION['annonce']['annonce_agenfants1'] = $params['agenfants1'];
            $_SESSION['annonce']['annonce_agenfants2'] = $params['agenfants2'];
            $_SESSION['annonce']['annonce_agenfants3'] = $params['agenfants3'];
            $_SESSION['annonce']['annonce_agenfants4'] = $params['agenfants4'];
            $_SESSION['annonce']['annonce_agenfants5'] = $params['agenfants5'];
            $_SESSION['annonce']['annonce_agenfants6'] = $params['agenfants'];

            $urlRedirect = "/pe/inscription/recapitulation.php";
            header("Location: " . $urlRedirect);
            exit();

        }
    }
}

//echo "<pre>";print_r($_SESSION);echo "</pre>";
//echo "<pre>";print_r($tabDisplayError);echo "</pre>";
//echo "<pre>";print_r($params);echo "</pre>";
//@TODO adaptation formulaire si erreur à la validation back du formulaire
    $meta['title']="Rédaction de l'annonce | Particulier Emploi";
    $meta['desc']="Le site officiel de petites annonces gratuites pour l\'emploi a domicile entre particuliers: garde d\'enfants (nounou, baby sitting), femme de ménage, assistante maternelle, jardinier ...";
    include_once(dirname(__FILE__).'/templates/header-inscription.php');
    include_once(dirname(__FILE__).'/templates/conditions.php');
    include_once(dirname(dirname(__FILE__)).'/common-templates/footer.php');
