<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Constantes
 */
require( dirname(dirname(__FILE__)).'/config/constants.php' );
/**
 * Fonctions de Wordpress
 */
require( dirname(dirname(dirname(__FILE__))).'/wp-load.php' );

$params=array();
$nbDuplicate=0;
if (isset($_POST) && !empty($_POST)) {
    $options = array(
        'email' => FILTER_SANITIZE_STRING
    );
    $params = filter_input_array(INPUT_POST, $options);
}
//$params['email']="webmaster@kiwiscan.net";
if(isset($params['email']) && !empty($params['email'])) {
    $queryCheckEmail= " SELECT count(*) as nb "
            . " FROM ".TBL_UTILISATEURS." "
            . " WHERE utilisateur_mail = '".$params['email']."' "
            . " and (utilisateur_etat='ACT' or utilisateur_etat='INS' or utilisateur_etat='VAL') ";
    $checkEmailResult=$wpdb->get_row($queryCheckEmail);
    $nbDuplicate = $checkEmailResult->nb;

if($nbDuplicate == 0) {
        echo "OK";
    } else {
       echo "NOK";
    }
} 
