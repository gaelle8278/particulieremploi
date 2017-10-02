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
        'supprdef' => FILTER_SANITIZE_STRING,
        'bloquer' => FILTER_SANITIZE_STRING,
        'in-spam' => FILTER_SANITIZE_STRING,
        'reset-spam' => FILTER_SANITIZE_STRING,
        'reset-blocked' => FILTER_SANITIZE_STRING
    );
    $params = filter_input_array(INPUT_POST, $options);
} elseif (isset($_GET) && !empty($_GET)) {
    $options = array(
        'type_message' => FILTER_SANITIZE_STRING,
        'sous_type_msg' => FILTER_SANITIZE_STRING,
        'id_mess' => FILTER_VALIDATE_INT,
        'bloquer' => FILTER_SANITIZE_STRING,
        'in-spam' => FILTER_SANITIZE_STRING,
        'reset-spam' => FILTER_SANITIZE_STRING
    );
    $params = filter_input_array(INPUT_GET, $options);
    $params['listmsg']=explode(" ",$params['id_mess']);
}
//echo "<pre>";print_r($params);echo"</pre>";
//vérification que l'utilisateur est toujours connecté
if(!isset($_SESSION['utilisateur_groupe']) || empty($_SESSION['utilisateur_groupe']) ) {
    header('Location: /index.php');
    exit();
}
$idUtilisateur = $_SESSION['utilisateur_id'];

global $wpdb;

// echo "<pre>";print_r($_POST);echo "</pre>";
// echo "<pre>";print_r($params);echo "</pre>";
//Les actions possibles
if((isset($params['supprimer']) && !empty($params['supprimer'])) ||
    (isset($params['archiver']) && !empty($params['archiver'])) ||
    (isset($params['supprdef']) && !empty($params['supprdef'])) ||
    (isset($params['in-spam']) && !empty($params['in-spam'])) ||
    (isset($params['bloquer']) && !empty($params['bloquer'])) ||
    (isset($params['reset-blocked']) && !empty($params['reset-blocked'])) ||
    (isset($params['reset-spam']) && !empty($params['reset-spam']))
) {
    //mise a jour des statuts des messages
    //pour les messages envoyés
    //////////////////////////////////
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
    ///////////////////////////////////////
    elseif( $params['type_message']==STATE_BDD_RECU ||
            $params['type_message']==STATE_BDD_ARCH ||
            $params['type_message']==STATE_BDD_SUPPR ||
            $params['type_message']==STATE_BDD_SPAM ||
            empty($params['type_message'])) {
            
            if(empty($params['supprdef'])) {
                //détermination du nouveau statut
                $updatestate="";
                if(!empty($params['supprimer'])) {
                    //message à mettre dans la corbeille : le message est mis supprimé
                    $updatestate=STATE_BDD_SUPPR;
                } elseif ( !empty($params['archiver']) ) {
                    //message à archiver : le message est mis en archive
                    $updatestate=STATE_BDD_ARCH;
                } elseif (!empty($params['reset-spam'])) {
                    //messages à enlever des spam
                        //le message revient dans la boite de réception
                    $updatestate=STATE_BDD_RECU;
                        //recherche des expéditeurs des messages pour les enlever des expéditeurs spammeur
                    $listMsg=implode(',',$params['listmsg']);
                    $queryRecupExp= "select distinct message_exp, "
                                        . "CASE utilisateur_civilite "
                                        . "WHEN '1' THEN 'Monsieur' "
                                        . "WHEN '2' THEN 'Madame' "
                                        . "WHEN '3' THEN 'Mademoiselle' "
                                        . "ELSE 'n/a' "
                                        . "END AS utilisateur_civilite,"
                                        . "utilisateur_nom, "
                                        . "utilisateur_prenom from "
                                        .TBL_MESSAGES.", ".TBL_UTILISATEURS." "
                                        . "where message_exp=utilisateur_id and message_id in (".$listMsg.")";
                    $tabExp=$wpdb->get_results($queryRecupExp, ARRAY_A);
                    $msgExp=array();
                    foreach($tabExp as $exp) {
                        $msgExp[]=$exp['utilisateur_civilite']." ".$exp['utilisateur_prenom']." ".$exp['utilisateur_nom'];
                        $wpdb->delete(
                                TBL_UTILISATEURS_BLOQUES,
                                array(
                                    'utilisateur_id_bloquant' => $idUtilisateur,
                                    'utilisateur_id_bloque' => $exp['message_exp']
                                )
                            );
                    }
                    //construction du message
                    if(count($msgExp) > 1) {
                        $msgInfo="Les messages de ".implode(', ',$msgExp)." ont été remis dans la boîte de réception.";
                    } else {
                        $msgInfo="Le message de ".implode(', ',$msgExp)." a été remis dans la boîte de réception.";
                    }
                } elseif ( !empty($params['in-spam'] ) || !empty($params['bloquer'])) {
                    //message à mettre en spam ou expéditeur à bloquer
                    if (!empty($params['in-spam']) ) {
                        //le message est mis en spam et l'expéditeur est marqué comme spammeur
                        $updatestate=STATE_BDD_SPAM;
                        $updateStateUser=STATE_USER_SPAM;
                    } else {
                        //l'expéditeur est bloqué et le message sera supprimé
                        $updateStateUser=STATE_USER_BLOQUE;
                    }
                    //récupération des expéditeurs des messages pour les marquer en tant que spammeur/bloqués
                    $listMsg=implode(',',$params['listmsg']);
                    $queryRecupExp= "select distinct message_exp, "
                                        . "CASE utilisateur_civilite "
                                        . "WHEN '1' THEN 'Monsieur' "
                                        . "WHEN '2' THEN 'Madame' "
                                        . "WHEN '3' THEN 'Mademoiselle' "
                                        . "ELSE 'n/a' "
                                        . "END AS utilisateur_civilite,"
                                        . "utilisateur_nom, "
                                        . "utilisateur_prenom from "
                                        .TBL_MESSAGES.", ".TBL_UTILISATEURS." "
                                        . "where message_exp=utilisateur_id and message_id in (".$listMsg.")";
                    $tabExp=$wpdb->get_results($queryRecupExp, ARRAY_A);
                    $msgExp=array();
                    foreach($tabExp as $exp) {
                        $msgExp[]=$exp['utilisateur_civilite']." ".$exp['utilisateur_prenom']." ".$exp['utilisateur_nom'];
                        //vérification si expéditeur déjà bloqué ou mis en spammeur
                        $queryCheckExp = "select count(*) as nb from ".TBL_UTILISATEURS_BLOQUES." "
                            ."where utilisateur_id_bloquant=".$idUtilisateur." and utilisateur_id_bloque=".$exp['message_exp'];
                        $resCheckExp   = $wpdb->get_row($queryCheckExp, ARRAY_A);
                        if ($resCheckExp['nb'] > 0) {
                            //si déjà en bdd update
                            $updateUser = $wpdb->update(
                                TBL_UTILISATEURS_BLOQUES,
                                array(
                                'utilisateur_bloque_etat' => $updateStateUser
                                ),
                                array(
                                'utilisateur_id_bloquant' => $idUtilisateur,
                                'utilisateur_id_bloque' => $exp['message_exp']
                                ),
                                array(
                                '%s'
                                ),
                                array(
                                '%d',
                                '%d',
                                )
                            );
                        } else {
                            //sinon insertion
                            $insertUser = $wpdb->insert(
                                TBL_UTILISATEURS_BLOQUES,
                                array(
                                'utilisateur_id_bloquant' => $idUtilisateur,
                                'utilisateur_id_bloque' => $exp['message_exp'],
                                'utilisateur_bloque_etat' => $updateStateUser,
                                'utilisateur_bloque_date' => current_time('mysql', 1)
                                ),
                                array(
                                '%d',
                                '%d',
                                '%s',
                                '%s'
                                )
                            );
                        }
                    }
                    //construction du message
                    if(count($msgExp) > 1) {
                        if(!empty($params['in-spam'])){
                            $msgInfo="Les messages de ".implode(', ',$msgExp)." ont été signalé à l'administrateur du site
                                comme étant potentiellement un abus. En attente de modération, les messages ont déplacé dans
                                les messages indésirables.";
                        } else {
                            $msgInfo="Vous avez bloqué l'envoi de message de ".implode(', ',$msgExp)."."
                                . " Vous pouvez gérer les expéditeurs bloqués dans Expéditeurs bloqués";
                        }
                    } else {
                        if(!empty($params['in-spam'])){
                            $msgInfo="Le message de ".implode(', ',$msgExp)." a été signalé à l'administrateur du site
                                comme étant potentiellement un abus. En attente de modération, le message ont déplacé dans
                                les messages indésirables.";
                        } else {
                            $msgInfo="Vous avez bloqué l'envoi de message de ".implode(', ',$msgExp)."."
                                . " Vous pouvez gérer les expéditeurs bloqués dans Expéditeurs bloqués";
                        }
                    }
                }
                //mise à jour des messages selon action
                if($updatestate!="") {
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
            }
            //les messages à supprimer définitivement ou les messages des expéditeurs bloqués
            if(!empty($params['supprdef']) || !empty($params['bloquer'])) {
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
    //pour les expéditeurs bloqués
    //////////////////////////////////
    elseif($params['type_message']==STATE_USER_BLOQUE) {
        //annulation du blocage
        if(!empty($params['reset-blocked'])) {
            foreach($params['listmsg'] as $user ) {
                    $wpdb->delete(
                        TBL_UTILISATEURS_BLOQUES,
                        array(
                            'utilisateur_id_bloquant' => $idUtilisateur,
                            'utilisateur_id_bloque' => $user
                        )
                    );
                }
            //construction du message
            $queryRecupExp= "select distinct "
                                        . "CASE utilisateur_civilite "
                                        . "WHEN '1' THEN 'Monsieur' "
                                        . "WHEN '2' THEN 'Madame' "
                                        . "WHEN '3' THEN 'Mademoiselle' "
                                        . "ELSE 'n/a' "
                                        . "END AS utilisateur_civilite,"
                                        . "utilisateur_nom, "
                                        . "utilisateur_prenom from "
                                        . TBL_UTILISATEURS." "
                                        . "where utilisateur_id in (".implode(',',$params['listmsg']).")";
            $tabExp=$wpdb->get_results($queryRecupExp, ARRAY_A);
            $msgExp=array();
            foreach($tabExp as $exp) {
                $msgExp[]=$exp['utilisateur_civilite']." ".$exp['utilisateur_prenom']." ".$exp['utilisateur_nom'];
            }
            if(count($msgExp) > 1) {
                $msgInfo="Les expéditeurs ".implode(', ',$msgExp)." ne sont plus des expéditeurs bloqués. "
                    . "Vous pouvez à nouveau recevoir des messages de leur part.";
            } else {
                $msgInfo="L'expéditeur ".implode(', ',$msgExp)." n'est plus un expéditeur bloqué. "
                    . "Vous pouvez à nouveau recevoir des messages de sa part.";
            }

        }

    }
    
    //redirection après traitement
    $urlRedirect="/pe/espace-pe/messagerie/accueil.php?type_message=".$params['type_message'];
    if(!empty($params['sous_type_msg'])) {
        $urlRedirect .= "&sous_type_msg=".$params['sous_type_msg'];
    }
    if(isset($msgInfo)) {
        $urlRedirect .= "&msginfo=".urlencode($msgInfo);
    }
    
    header("Location:".$urlRedirect);
    exit();
    
    
} else {
    //si action pas valide => redirection vers la boîte de réception
    $urlRedirect="/pe/espace-pe/messagerie/accueil.php";
    header("Location:".$urlRedirect);
    exit();
}