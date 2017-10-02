<?php

/**
 * Fichier de déconnexion
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

// Initialisation de la session.
// 
// session_name("autrenom")
session_start();

// Détruit toutes les variables de session
$_SESSION = array();

// Finalement, on détruit la session.
session_destroy();

header('Location: /index.php');
