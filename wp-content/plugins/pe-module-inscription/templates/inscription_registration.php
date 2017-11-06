<?php
/**
 * Traitement de l'inscription
 */

/**
 * Constantes pe
 */
require_once(  __DIR__ .'/../../../../pe/config/constants.php' );
/**
 * Fonctions pe
 */
require_once(  __DIR__ .'/../../../../pe/config/functions.php' );
/**
 * Fonctions de Wordpress
 */
require_once( __DIR__ .'/../../../../wp-load.php' );

global $wpdb;

//1. vérifier que l'utilisateur est connecté avec le bon role
if(!check_access_to_module_inscription()) {
    header("Location: ".home_url( "page-non-accessible"));
    exit();
}


//2. Traitement du formulaire
$tabDisplayError=array();
if(isset($_POST['emploi'])) {
    

    //on récupère les valeurs soumises
    $fieldFilters = array(
        'type_compte' => FILTER_SANITIZE_STRING,
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
        'jobSelect' =>  FILTER_VALIDATE_INT,
        'erSelect' =>  array('filter' => FILTER_VALIDATE_INT,
                            'flags' => FILTER_REQUIRE_ARRAY),
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
        'particularites' => array('filter' => FILTER_SANITIZE_STRING,
                                    'flags' => FILTER_FLAG_NO_ENCODE_QUOTES),
        'tauxhoraire' =>  FILTER_VALIDATE_FLOAT,
        'dateprisefonction' => FILTER_SANITIZE_STRING,
        'durehebdojs' => FILTER_VALIDATE_FLOAT,
        'nbenfants1' => FILTER_SANITIZE_NUMBER_INT,
        'nbenfants2' =>FILTER_SANITIZE_NUMBER_INT,
        'nbenfants3' => FILTER_SANITIZE_NUMBER_INT,
        'nbenfants4' => FILTER_SANITIZE_NUMBER_INT,
        'job_adresse' => FILTER_SANITIZE_STRING,
        'job_codepostal' => FILTER_SANITIZE_STRING,
        'job_ville' => FILTER_SANITIZE_STRING,
        'geoadresse' => FILTER_SANITIZE_STRING
    );
    $params = filter_input_array(INPUT_POST, $fieldFilters);
    $tabErrorMsg = array(
            'civilite' => "Vous devez choisir une civilité",
            'email' => "L'email n'a pas un format valide",
            'jobSelect' => "Le métier choisit n'est pas valide.",
            'erSelect' => "Le(s) emploi(s)-repère(s) choisi(s) ne sont pas valide(s).",
            'tauxhoraire' => "Le taux horaire doit être un nombre",
            'durehebdojs' => "La durée hebdomadaire doit être un nombre"
    );
    $tabRequiredField = array('civilite','nom','prenom','adresse','cpo','ville','email','mdp','emailconfirm', 'mdpconfirm',
                                'jobSelect',
                                'experience','tauxhoraire','dateprisefonction','codepostal');
    foreach($fieldFilters as $field => $filter) {
        if(in_array($field, $tabRequiredField) && empty($_POST[$field])) {
            //empty submitted field
            $tabDisplayError[$field]='Veuillez remplir ce champ';
        } elseif(!empty($_POST[$field]) && $params[$field] === false) {
            //field not valid
            $tabDisplayError[$field]=$tabErrorMsg[$field];
        } elseif ( !empty($_POST[$field]) && $_POST[$field] != $params[$field] ) {
            //field different after sanitization
            //$tabDisplayError[$field]= 'Le champs contient des caractères non permis';
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
        $queryCheckEmail= " SELECT count(*) as nb "
            . " FROM ".TBL_UTILISATEURS." "
            . " WHERE utilisateur_mail = '".$params['email']."' "
            . " and (utilisateur_etat='ACT' or utilisateur_etat='INS' or utilisateur_etat='VAL') ";
        $checkEmailResult=$wpdb->get_row($queryCheckEmail);
        $nbDuplicate = $checkEmailResult->nb;

        if( $nbDuplicate != 0) {
            $tabDisplayError['email'] = "Cet e-mail est déjà associé à un compte existant. Veuillez en indiquer un autre.";
        }
    }

    //cp
    if(!empty($params['job_codepostal'])) {
        if(strlen($params['job_codepostal']) != 5) {
            $tabDisplayError['job_codepostal']= "Le code postal doit contenir 5 chiffres";
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


    if (!empty($tabDisplayError)) {
        //si il y a des erreurs => retour au formulaire avec affichage des erreurs
        $_SESSION['officer-inscription']=$params;
        $_SESSION['officer-inscription']['form-error'] = $tabDisplayError;
        header("Location: " . site_url( '/inscription-module-inscription/' ));
        exit();

    } else {
        //si pas d'erreur => enregistrement compte et annonce

        //on vide la tabeau de session d'inscription
        $_SESSION['officer-inscription']="";

        //1. récupération et formatage des données nécessaires
            //récupération du libéllé du métier choisi
        $queryLibelle = "SELECT referentiel_libelle
                        FROM ".TBL_METIERS."
                        WHERE referentiel_id=".$params['jobSelect'];
        $resLibelle=$wpdb->get_row($queryLibelle);
        $params['intitulemetier']=$resLibelle->referentiel_libelle;

            //latitude et longitude de l'adresse
        list( $params['latitude'], $params['longitude']) = explode("/",$params['geoadresse']);

            //si deja famille l'adresse est renseignée et validée
        if($params['dejafamille'] == 1) {
            list( $params['latitude2'], $params['longitude2']) = explode("/",$params['geoadresse2']);
        } else {
            //si pas de famille pas d'addresse de la famille et si annonce salarié pas de nombre d'enfants gardés
            $params['latitude2']='';
            $params['longitude2']='';
            $params['gp_codepostal']='';
            $params['gp_ville']='';
            $params['gp_localisation']='';
            if($params['type_compte']=="sal") {
                $params['annonce_nbenfgardes']=0;
            }
        }

            //retro-compatibilité date de naissance
        $naissance = '0000-01-01';

            //infos activation
        $token=uniqid(rand(), true);
        $tokenValidity=strtotime("+2 days");

            //encryptatge mot de passe
        $mdp = encodeMD5PE($params['mdp']);

            //etat du compte
        $etat="VAL";

        //1. enregistrement du compte
        $insert=$wpdb->insert(
                TBL_UTILISATEURS,
                array(
                    'utilisateur_groupe' => strtoupper($params['type_compte']),
                    'utilisateur_nom' => $params['nom'],
                    'utilisateur_prenom' => $params['prenom'],
                    'utilisateur_naissance' => $naissance,
                    'utilisateur_civilite' => $params['civilite'],
                    'utilisateur_adresse' => $params['adresse'],
                    'utilisateur_ville' => $params['ville'],
                    'utilisateur_telephone' => $params['telephone'],
                    'utilisateur_codepostal' => $params['cpo'],
                    'utilisateur_etat' => $etat,
                    'utilisateur_datecrea' => current_time('mysql', 1),
                    'utilisateur_mail' => $params['email'],
                    'utilisateur_password' => $mdp,
                    'utilisateur_cnil' => 1,
                    'utilisateur_cgu' => 1,
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
            //id de l'utilisateur inséré
            $id  = $wpdb->insert_id;

            $etatAnnonce="EN_ATTENTE";

            //2. enregistrement de l'annonce
            $fieldToInsert = array(
                    'annonce_idauteur' => $id,
                    'annonce_type' => strtoupper($params['type_compte']),
                    'annonce_datecrea' => current_time('mysql', 1),
                    'annonce_etat' => $etatAnnonce,
                    'annonce_idmetier' => $params['jobSelect'],
                    'annonce_titremetier' => $params['intitulemetier'],
                    'annonce_latitude' => $params['latitude'],
                    'annonce_longitude' => $params['longitude'],
                    'annonce_experience' => $params['experience'],
                    'annonce_description' => $params['particularites'],
                    'annonce_tauxhoraire' => $params['tauxhoraire'],
                    'annonce_dureehebdomadaire' => $params['durehebdojs'],
                    'annonce_dateprisefonction' => str_replace('-','',dateFormat($params['dateprisefonction'])),
                    'annonce_adresse' => $params['job_adresse'],
                    'annonce_codepostal' => $params['job_codepostal'],
                    'annonce_ville' => $params['job_ville'],
                    'annonce_localisation' => $params['localisation'],
                    'annonce_agrement' => $params['agrement'],
                    'annonce_dateagrement' => str_replace('-','',dateFormat($params['dateagrement'])),
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
                    'annonce_agenfants6' => $params['agenfants6'],
                    'annonce_nomprenom' => $params['nom']." ".$params['prenom'],
                    'annonce_diffusionpe' => 1
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
                if(!empty($params['erSelect'])) {
                    foreach($params['erSelect'] as $idER) {
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

        $email=false;
        if($insert==true) {
            //envoi de l'email d'activation
            $email=send_email_inscription($params['email'],$params['mdp'],$params['type_compte'],$token);
        }

        if($insert==true && $email==true) {
            $inscription="ok";
        } else {
            if($insert==false) {
                $inscription="record-nok";
            } elseif($email==false) {
                $inscription="email-nok";
                $inscription_email=$params['email'];
            }
        }
        $get_params=['registration'=> $inscription];
        if(isset($inscription_email)) {
            $get_params['registration_email']=$inscription_email;
        }
        $urlRedirect=esc_url( add_query_arg( $get_params , site_url( '/accueil-module-inscription/' ) ) );
        header("Location: ".$urlRedirect);
        exit();
    }
}

