<?php

/**
 * Traitement du changement de statut des messages
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
/**
 * Constantes
 */
require( dirname(dirname(dirname(__FILE__))).'/config/constants.php' );
/**
 * Fonctions
 */
require( dirname(dirname(dirname(__FILE__))).'/config/functions.php' );
/**
 * Fonctions de Wordpress
 */
require( dirname(dirname(dirname(dirname(__FILE__)))).'/wp-load.php' );

session_start();

if (isset($_POST) && !empty($_POST)) {
    $options = array(
        'type_message' => FILTER_SANITIZE_STRING,
        'sous_type_msg' => FILTER_SANITIZE_STRING,
        'listmsg' => array( 'filter' => FILTER_VALIDATE_INT,
                           'flags'  => FILTER_REQUIRE_ARRAY,
                    ),
        'supprimer'=>FILTER_SANITIZE_STRING,
        'archiver' => FILTER_SANITIZE_STRING,
        'supprdef' => FILTER_SANITIZE_STRING
    );
    $params = filter_input_array(INPUT_POST, $options);
}

//vérification que l'utilisateur est toujours connecté
if(!isset($_SESSION['utilisateur_groupe']) || empty($_SESSION['utilisateur_groupe']) ) {
    header('Location: /index.php');
    exit();
}
$idUtilisateur = $_SESSION['utilisateur_id'];

global $wpdb;

// echo "<pre>";print_r($_POST);echo "</pre>";
// echo "<pre>";print_r($params);echo "</pre>";
if((isset($params['supprimer']) && !empty($params['supprimer'])) ||
    (isset($params['archiver']) && !empty($params['archiver'])) ||
    (isset($params['supprdef']) && !empty($params['supprdef']))
) {
    //mise a jour des statuts des messages
    //pour les messages envoyés 
    if( $params['type_message']==STATE_BDD_ENV ) {
        if ( empty($params['supprdef']) ) {
            if(!empty($params['supprimer'])) {
                $updatestate=STATE_BDD_SUPPR;
            } else if ( !empty($params['archiver']) ) {
                $updatestate=STATE_BDD_ARCH;
            }
            foreach($params['listmsg'] as $msg ) {
                $qupdate=$wpdb->update(
                    TBL_MSG_EXP,
                    array(
                        'exp_mess_etat_gestion'=> $updatestate
                    ),
                    array(
                        'exp_mess_id_membre' => $idUtilisateur,
                        'exp_mess_id_mess' => $msg
                    ),
                    array(
                        '%s'
                    ),
                    array(
                        '%d',
                        '%d'
                    )
                );
            }
            
            
        } elseif(!empty($params['supprdef'])) {
            foreach($params['listmsg'] as $msg ) {
                    $wpdb->delete(
                        TBL_MSG_EXP,
                        array(
                            'dest_mess_id_membre' => $idUtilisateur,
                            'dest_mess_id_mess' => $msg
                        )
                    );
                }
        }
    } 
    // pour les messages reçus
    elseif( $params['type_message']==STATE_BDD_RECU ||
            $params['type_message']==STATE_BDD_ARCH ||
            $params['type_message']==STATE_BDD_SUPPR ||
            empty($params['type_message'])) {
            
            if(empty($params['supprdef'])) {
                if(!empty($params['supprimer'])) {
                    $updatestate=STATE_BDD_SUPPR;
                } else if ( !empty($params['archiver']) ) {
                    $updatestate=STATE_BDD_ARCH;
                }
                foreach($params['listmsg'] as $msg ) {
                    $qupdate=$wpdb->update(
                        TBL_MSG_DEST,
                        array(
                            'dest_mess_etat_gestion'=> $updatestate
                        ),
                        array(
                            'dest_mess_id_membre' => $idUtilisateur,
                            'dest_mess_id_mess' => $msg
                        ),
                        array(
                            '%s'
                        ),
                        array(
                            '%d',
                            '%d'
                        )
                    );
                }
            }
            elseif(!empty($params['supprdef'])) {
                foreach($params['listmsg'] as $msg ) {
                    $wpdb->delete(
                        TBL_MSG_DEST,
                        array(
                            'dest_mess_id_membre' => $idUtilisateur,
                            'dest_mess_id_mess' => $msg
                        )
                    );
                }
            }
    }
    
    //redirection après traitement
     $urlRedirect="/pe/espace-pe/messagerie/accueil.php?type_messge=".$params['type_message'];
    if(!empty($params['sous_type_msg'])) {
        $urlRedirect .= "&sous_type_msg=".$params['sous_type_msg'];
    }
    header("Location:".$urlRedirect);
    exit();
    
    
} 