<?php
/**
 * Script de transfert de fichier csv vers Pole Emploi
 */

/**
 * Fonctions de Wordpress
 */
require( dirname(dirname(__FILE__)).'/wp-load.php' );

global $wpdb;

//nom du fichier csv à transférer
$filename = "offres_annonces_poleemploi.csv";
$logfile = "log_transfert.txt";

//ouverture du fichier de log
$fplog = fopen($logfile, 'wb');
$currentDate = date("d-m-Y");
$currentHour = date("H:i");

fwrite($fplog, "Début dernier transfert le ".$currentDate." à ".$currentHour."\r\n"); 

fwrite($fplog, "Début transfert fichier\r\n"); 


$cmd="curl -k -F login=FEPEM -F password=WaIOZ3iD -F nomFlux=FEPEMTTA -F fichierAenvoyer=@$filename -F periodeRef='''' -F nomDestinataire='' https://portail-partenaire.pole-emploi.fr/partenaire/depotcurl";
exec($cmd,$output);
$log=print_r($output, 1);
print_r($log);
fwrite($fplog, $log);

fwrite($fplog, "Fin transfert fichier \r\n");

fwrite($fplog, "Fin dernier transfert le ".$currentDate." à ".$currentHour."\r\n"); 

//fermeture du fichier de log
fclose($fplog);
