<?php

/**
 * Fichier contenant les constantes utilisées 
 * dans la logique métier de particulieremploi.fr
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

//tables BDD
define ('TBL_UTILISATEURS', 'tbl_utilisateurs');
define ('TBL_UTILISATEURS_BLOQUES', 'tbl_utilisateurs_bloques');
define ('TBL_DOMAINE_CLASSIF' , 'tbl_domaine_classif');
define ('TBL_CATEGORIES' , 'tbl_referentiel_categories');
define ('TBL_METIERS', 'tbl_referentiel');
define ('TBL_METIER_ER', 'tbl_referentiel_emploirepere');
define ('TBL_EMPLOI_REPERE', 'tbl_emploi_repere');
define ('TBL_ASSOC_ER_ANNONCE', 'tbl_annonce_emploirepere');
define ('TBL_ANNONCES', 'tbl_annonces');
define ('TBL_FAVORIS', 'tbl_maselection');
define ('TBL_VILLES', 'tbl_communes');
define ('TBL_REF_METIERS', 'tbl_ref_metiers');
define ('TBL_MESSAGES', 'tbl_messages');
define ('TBL_MSG_DEST', 'tbl_messages_dest');
define ('TBL_MSG_EXP', 'tbl_messages_exp');

//etats messagerie
define ('STATE_BDD_ARCH', 'archive');
define ('STATE_BDD_SUPPR', 'supprime');
define ('STATE_BDD_ENV', 'envoye');
define ('STATE_BDD_RECU', 'recu');
define ('STATE_BDD_SPAM', 'spam');
define ('MSG_STATE_LU', 'lu');
define ('MSG_STATE_NONLU', 'nonlu');
define ('STATE_USER_SPAM', 'spammeur');
define ('STATE_USER_BLOQUE', 'bloqué');

