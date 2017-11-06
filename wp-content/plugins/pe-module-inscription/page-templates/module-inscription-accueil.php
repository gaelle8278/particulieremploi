<?php
/* 
 * Page d'accueil du module d'inscription
 */

//1. vérifier que l'utilisateur est connecté avec le bon role
if(!check_access_to_module_inscription()) {
    header("Location: ".home_url( "connexion"));
    exit();
}

//2. traitement
$registration= get_query_var( 'registration' );
$registration_email= get_query_var( 'registration_email' );


include_once(__DIR__ . '/../templates/header.php');
include_once(__DIR__ . '/../templates/inscription_accueil.php');
include_once(__DIR__ . '/../templates/footer.php');