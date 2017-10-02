<?php

/**
 *
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
 * Fonctions de Wordpress
 */
require( dirname(dirname(dirname(__FILE__))).'/wp-load.php' );


//validation des données
$options = array(
    'password' => FILTER_SANITIZE_STRING, 
    'email' => FILTER_SANITIZE_STRING,
);
$validateDataInput = filter_input_array(INPUT_POST, $options);
//si redirection  lors de l'inscription
$optionsIns = array(
    'idAnnonce' => FILTER_SANITIZE_STRING
);
$params = filter_input_array(INPUT_POST, $optionsIns);

// les champs du formulaire sont présents (formulaire soumis)
// => validation
if($validateDataInput != null){
   
    $messageEmpty = array (
        'email' => "L'adresse e-mail doit être indiquée",
        'password' => "Le mot de passe doit être indiquée"
    );
    $messageInvalid = array (
        'email' => "L'adresse e-mail, ".htmlspecialchars($_POST['email'])." est invalide",
        'password' => "Le mot de passe, ".htmlspecialchars($_POST['password'])." est invalide"
    );
    $tabError=[];
    foreach($options as $field => $value) { 
        if(empty($_POST[$field])) { 
            $tabError[$field] = $messageEmpty[$field] ;
        } 
        //le champs n'est pas valide
        elseif($validateDataInput[$field] === false) { 
            $tabError[$field] = $messageInvalid[$field];
        }
    }
    
    if(!empty($tabError)) {
        
        $urlRedirect = '/pe/espace-pe/connexion.php?erreurEmail='.$tabError['email'].'&erreurPassword='.$tabError['password'];
        if(isset($params['idAnnonce'])) {
            $urlRedirect .= "&idAnnonce=".$params['idAnnonce'];
        }
        header('Location: '.$urlRedirect);
        exit();
    }
}
else {
    // le formulaire n'a pas été soumis
    $message="Veuillez remplir le formulaire";
    header('Location: /pe/espace-pe/connexion.php?erreurForm='.$message);
    exit();
}

//le formulaire est rempli et les données utilisateurs sont valides
//=> traitement
$mail=$validateDataInput['email'];
$passwordoriginal = $validateDataInput['password']; 

$password = strtoupper(md5(trim($validateDataInput['password'])));
$password = '0x'.$password.'00000000000000000000000000000000000000000000000000000000000000000000';

global $wpdb;
$data = $wpdb->get_row("SELECT * FROM ".TBL_UTILISATEURS."  
		WHERE utilisateur_mail ='$mail'
		AND utilisateur_etat != 'SUP'", ARRAY_A) ;
$nombre_retour = $wpdb->num_rows;

//compte inexistant ou mot de passe invalide
if($data['utilisateur_password'] !== $password) {
    //On vérifie que l'utilisateur a un numero passeport
    $datapasseport=$wpdb->get_row("SELECT utilisateur_id, utilisateur_nom, utilisateur_passeport 
			FROM tbl_utilisateurs 
			WHERE utilisateur_passeport = '$mail'
			AND utilisateur_etat != 'SUP'
			",  ARRAY_A);
    $nbresult = $wpdb->num_rows;
    // si le numero de passeport existe en base
    // on a trouvé un compte passeport associé
    if ($nbresult!=0) { 
        $utilisateurid = $datapasseport['utilisateur_id'];
	$nompasseport = $datapasseport['utilisateur_nom'];
	$numpasseport = $datapasseport['utilisateur_passeport'];
        if($nompasseport == $passwordoriginal) { 
            //le mot de passe est bon => redirection pour continuer ?
            header('Location: /pe/inscription/compte.php?type=sal&id='.$utilisateurid);
        } else {
            // le mot de passe ne correspond pas on avertit l'utilisateur
            $message="Le mot de passe saisi ne correspond pas à ce compte d'accès";
            $urlRedirect = "/pe/espace-pe/connexion.php?erreurForm=".urlencode($message);
            if(isset($params['idAnnonce'])) {
                $urlRedirect .= "&idAnnonce=".$params['idAnnonce'];
            }
            header('Location: '.$urlRedirect);
            exit();
        }
    } else {
        //on n' pas de compte passeport et le mdp est invalide => on averti l'utilisateur
        $message="Le mot de passe saisi ne correspond pas à ce compte d'accès";
        $urlRedirect = "/pe/espace-pe/connexion.php?erreurForm=".urlencode($message);
        if(isset($params['idAnnonce'])) {
            $urlRedirect .= "&idAnnonce=".$params['idAnnonce'];
        }
        header('Location: '.$urlRedirect);
        exit();
    }
} else {
    //le compte existe : traitement du login
    switch ($data['utilisateur_etat']) {
        // si l'utilisateur est actif
        case 'ACT': 
            //remplissage de la session
            session_start();
            $_SESSION['utilisateur_groupe'] = $data['utilisateur_groupe'];
            $_SESSION['utilisateur_nomprenom'] = $data['utilisateur_prenom']." ".$data['utilisateur_nom'];
            $_SESSION['utilisateur_id'] = $data['utilisateur_id'];
            
            // mise à jour de la date de connexion
            $wpdb->update(
                        TBL_UTILISATEURS, 
                        array(
                            'utilisateur_lastconnexion' => current_time('mysql', 1),
                        ),
                        array( 'utilisateur_id' => $data['utilisateur_id'] )
                    );
            
            
            //redirection vers la page d'accueil de l'espace perso
            $urlRedirect= "/pe/espace-pe/compte.php";
            //si idAnnonce redirigé vers la messagerie
            if(isset($params['idAnnonce'])) {
                
                //vérification que l'annonce choisie n'est pas déjà dans la sélection
                $verifSelectionAnnonce="select 
                                maselection_annonceid 
                                from ".TBL_FAVORIS."
		                WHERE maselection_utilisateurid = ".$_SESSION['utilisateur_id']."
		                AND maselection_annonceid = ".$params['idAnnonce'];
                $resultatselection = $wpdb->get_results($verifSelectionAnnonce);
                $resultatselec=$wpdb->num_rows;
	
                //ajout de l'annonce dans la sélection si elle n'est pas déjà présente
                if(empty($resultatselec))
                {
                    $wpdb->insert(
                        TBL_FAVORIS,
                        array(
                            'maselection_utilisateurid'=> $_SESSION['utilisateur_id'],
                            'maselection_annonceid' => $params['idAnnonce'],
                            'maselection_datecrea' => current_time('mysql', 1)
                        ),
                        array(
                            '%d',
                            '%d',
                            '%s'
                        )
                    );
                }
                
                $urlRedirect='/pe/espace-pe/favoris.php?annonceid='.$params['idAnnonce'].'&part=affiche-annonce';
                
            } 
            header('Location: '.$urlRedirect);
            exit();
            
        break;
        //si l'utilisateur n'a pas activé son compte
        case 'VAL':
            header('Location: /pe/inscription/validation.php?login='.$mail);
            exit();
        break;
        // si l'utilisateur est banni
        case 'BAN':
            //@TODO ajouter un message pour indiquer que l'utilisateur est banni
            header('Location: /pe/espace-pe/connexion.php');
            exit();
            break;
        default:
            header('Location: /pe/espace-pe/connexion.php');
            exit();
            break;
    }
}
