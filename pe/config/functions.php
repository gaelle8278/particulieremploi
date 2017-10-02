<?php

/**
 * Fonction utiles au fonctionnement de pe
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

/**
 * 
 * @param type $unite
 * @param type $operateur
 * @param type $valeur
 * @return type
 */
function diffdate($unite, $operateur, $valeur) {
    //$unite : month year day
    // $operateur : + ou -
    // $valeur : nombre
    $datej = date("d", strtotime($operateur . '' . $valeur . ' ' . $unite));
    $datem = date("m", strtotime($operateur . '' . $valeur . ' ' . $unite));
    $datey = date("Y", strtotime($operateur . '' . $valeur . ' ' . $unite));
    return "$datey-$datem-$datej";
}
/**
 * 
 * @param type $enreg
 * @return string
 */
function convert_datetime($enreg)
{
	if($enreg != ''){
	    list($date,$heure) = explode(" ",$enreg);
	    list($year,$month,$day) = explode("-",$date);
	    list($hour,$min,$sec) = explode(":",$heure);
	    /*$tablo = array (
	        "Heure"=>$hour,
	        "Minute"=>$min,
	        "Seconde"=>$sec,
	        "Jour"=>$day,
	        "Mois"=>$month,
	        "Annee"=>$year
	    );*/
            return "le $day-$month-$year à $hour:$min";
	}else{
		return '';
	}
}
/**
 * 
 * @param type $date
 * @param type $delimiter
 * @return string
 */
function convert_date($date, $delimiter) {
    if ($date != '') {
        $tableau = explode("-", $date);

        // on formate
        $annee = $tableau[0];
        $mois = $tableau[1];
        $jour = $tableau[2];

        // affichage
        return $jour . $delimiter . $mois . $delimiter . $annee;
    } else {
        return '';
    }
}

/**
 * Fonction pour récupérer la version "humaine" de la civilité
 * 
 * @param   string    $code_civilite  code de la civilité en bdd
 * @return  string    $label_civilite    label de la civilité correspondand au code
 */
function get_civilite($code_civilite) {
    switch ($code_civilite) {
        case 1:
            $label_civilite = 'Monsieur';
            break;
        case 2:
            $label_civilite = 'Madame';
            break;
        case 3:
            //up 10/2014 mademoiselle n'est plus utilisée
            $label_civilite = 'Madame';
            break;
        default:
            $label_civilite = '';
            break;
    }
    return $label_civilite;
}

/**
 * Fonction qui retourne la csp à partir du codebdd  de la csp
 * 
 * @param   string  $code_csp   code de la csp
 * @return  string  $label_csp  label de la csp
 */
function get_csp($code_csp) {
    switch ($code_csp) {
        case '5b2c168d-3076-44fe-b1d7-7c98ded63285':
            $label_csp = 'Agriculteur';
            break;
        case '5c23ee13-7f17-4e93-8bdd-ed5155411e84':
            $label_csp = 'Artisan';
            break;
        case 'CA':
            $label_csp = 'Cadres';
            break;
        case 'b8a7c58e-2d55-4fe0-b100-a36d95202d00':
            $label_csp = 'Chef d\'entreprise';
            break;
        case '85244e7e-c158-4697-920b-17f5b78e1011':
            $label_csp = 'Commerçant';
            break;
        case 'MA':
            $label_csp = 'Contremaïtre, agent de maîtrise';
            break;
        case 'EM':
            $label_csp = 'Employé';
            break;
        case 'DEM':
            $label_csp = 'Demandeur d\'emploi';
            break;
        case 'TE':
            $label_csp = 'Enseignants';
            break;
        case 'ETU':
            $label_csp = 'Etudiant';
            break;
        case 'FAF':
            $label_csp = 'Femme au foyer';
            break;
        case 'RET':
            $label_csp = 'Retraité';
            break;
        case 'OU':
            $label_csp = 'Ouvrier';
            break;
        case '475ddc5a-fbe6-4700-aff1-7274a1804c31':
            $label_csp = 'Profession libérale';
            break;
        case '050042b8-d13f-4e1c-96b5-17db22a0782b':
            $label_csp = 'Autres';
            break;
        default:
            $csp = 'Indéfinie';
            break;
    }
    return $label_csp;
}

/**
 * Fonction qui retourne la localisation à partir du code de localisation
 * 
 * @param   string  $code_loc   code de la localisation
 * @param string $label_loc label de la localisation
 */
function get_localisation($code_loc) {
    switch ($code_loc) {
        case 'FRANCE':
            $label_loc = 'France Métropolitaine';
            break;
        case 'GUF':
            $label_loc = 'Guyane';
            break;
        case 'GLP':
            $label_loc = 'Guadeloupe';
            break;
        case 'MTQ':
            $label_loc = 'Martinique';
            break;
        case 'REU':
            $label_loc = 'R&eacute;union';
            break;
        case 'PYF':
            $label_loc = 'Polyn&eacute;sie Fran&ccedil;aise';
            break;
        default:
            $label_loc = 'Pas précisée';
            break;
    }
    return $label_loc;
}

/**
 * Fonction qui retourne l'experience à partir du code de l'expérience
 * 
 * @param   string  $code_exp  code de l'experience
 * @return  string  $exp    label correspondant au code
 */
function get_experience($code_exp) {
    switch ($code_exp) {
        case 'E510':
            $exp = '2 à 5 ans';
            break;
        case 'P10':
            $exp = 'plus de 5 ans';
            break;
        case 'M5':
            $exp = 'moins de 2 ans';
            break;
        default :
            $exp = 'Non renseigné !';
            break;
    }
    return $exp;
}
/**
 * Convertit une date pour l'enregistrement en bdd
 * 
 * @param   string    $date   format français
 * @param   string    $delimiter  séparateur utilisé dans la date
 * @return  string      la date au format bdd
 */
function datetodb($date, $delimiter = '.') {
    if (ereg("([0-9]{1,2})$delimiter([0-9]{1,2})$delimiter([0-9]{2,4})", $date, $regs)) {
        if (strlen($regs[1]) < 2)
            $regs[1] = "0$regs[1]";
        if (strlen($regs[2]) < 2)
            $regs[2] = "0$regs[2]";
        if (strlen($regs[3]) < 4)
            $regs[3] = "20$regs[3]";

        return "$regs[3]$regs[2]$regs[1]";
    }
    else {
        return false;
    }
}
function dateFormat($date, $currentDelimiter = '/', $newDelimite="-") {
    if($date!='') {
        $tableau = explode( $currentDelimiter, $date);
         // on formate
        $annee = $tableau[2];
        $mois = $tableau[1];
        $jour = $tableau[0];

        // affichage
        return $annee . $newDelimite . $mois . $newDelimite . $jour;

    }
    else {
        return false;
    }
}

/**
 * Formatage de la date pour son utilisation dans la messagerie
 * 
 * @param type $date_to_format datetime issu de la bdd à formater
 * @return type $date_formatted date au bon format
 */
function recup_date_msg($date_to_format) {
    list($date,$heure) = explode(" ",$date_to_format);
    list($year,$month,$day) = explode("-",$date);
    $timestamp = mktime(0, 0, 0, $month, $day, $year);
    
    setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
    // jour de la semaine en toute lettre/jour du mois/mois en toute lettre
    $date_formatted=strftime("%A %e %B",$timestamp);
    return $date_formatted;
}

/**
 * Fonction pour encoder le mot de passe
 * 
 * @param   string  $password   le mot de passe en clair
 * @return  string  $password   le mot de passe encodé
 */
function encodeMD5PE($password){
    $password = strtoupper(md5($password));
    $password = '0x'.$password.'00000000000000000000000000000000000000000000000000000000000000000000';
    return $password;
}

/** 
 * Permet de selectionner la bonne clé googlemap en fonction de l'url
 */
function getKey() {
    switch ($_SERVER['SERVER_NAME']) {
        case 'www.particulier-employeur.eu':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxQzQP8P_DzJxAj7FjJbxPFDCJXOpRR1hPJpjfJugdQrNx7yIb_c7FnIjA';
            break;
        case 'www.particulier-employeur.fr':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxRZITbcjten5qpAFdhCwuNwZpIAlhTJp7XhlUhSAqqNDnMomGFWnQxz4g';
            break;
        case 'www.particulier-employeur.net':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxQ27SR0lly_nIVSju27pWKkn6TyBRS6Tt6coF06OCMgZ3IzNpFSs1TCWg';
            break;
        case 'www.particulier-employeur.org':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxRH-p1P0NzhD9n4JyZlJGMag5Wb6BSw7WD9yUS2I_FPAwL6-ypizP7WhQ';
            break;
        case 'www.particuliers-employeurs.eu':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxR3Fnn772KvZxBznv-i0uk336bSEBQjFE4CETtPmq1hIYWvBsmGvpOg-w';
            break;
        case 'www.particuliers-employeurs.fr':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxTpqELfbymOPxIBS8Fc0ek2laZO5xRlcVGq2H6RKM2hCCh9wBGcW6FBCA';
            break;
        case 'www.particuliers-employeurs.net':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxQqKtzcuNmlJwp7X7zewS9xrHGZ7RRnyNq1NepDKwlsn2OJkKvCJF8HBw';
            break;
        case 'www.particuliers-employeurs.org':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxQTg21Btcfl5eq3HGz6v-9tPLYqJBRSBZLcI7v9X2XTzueVquSJWm_FTQ';
            break;
        case 'www.particulieremploi.info':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxSATVkYLL9O__9msYjjSzk3ECpr3BRA3E33t7H9AYc1L2XvwX1GhZxOCQ';
            break;
        case 'www.particulier-employeur.com':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxScRIWBezkyjn5loRXtOi_05mrJcBRwoLmDuhg84nJZ-wyTai66zQ6avA';
            break;
        case 'www.particuliersemployeurs.com':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxQufezUP_YexCC9eh-OEZXuFyTi9hQjlFSH3ph8bwp9MSSFFai9EpRT1Q';
            break;
        case 'www.particuliersemployeurs.eu':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxQFd_f6ocB3mkrrKKPDoFSzlZn20RRtmz2haofIpKt7d6yOXRrdVwsleA';
            break;
        case 'www.particulieremploi.com':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxT9hlvliJdEgpnlaHpfHCHgMKHeCBRZEjuhbDlMJ13d0daqmpFmeSKJGA';
            break;
        case 'www.particulieremploi.eu':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxTqNmwm_SzJ3E7R_cFGCz2qOcldaBQT03GQd3LJ2b_UpyK6W-aT9lE_cw';
            break;
        case 'www.particuliersemplois.com':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxTuWTBd5pVgBiIhW16xSP5kkdmvpxT2E2jCBXOrUUL0KQ5wzR9s5uIiVg';
            break;
        case 'www.particuliersemplois.eu':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxQbHJctxr5SXqcJyIOzxuxF9eGJ6hQdvewfPrIifzWeLsZN7ZFpLj7Kmg';
            break;
        case 'www.particuliers-emplois.com':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxTPSHpIvhl5SE53Ag7keDHyE-XOqRRtrNBw3hZdXHwdXVbjpNhpHFe8lg';
            break;
        case 'www.particuliers-emplois.eu':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxQoJle5yjAi8eS01oUMEPW6Wk2iIBQllWabfLNgq6qk1GdzoI7swvEHWg';
            break;
        case 'www.particulier-emploi.com':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxS5BZApoMEI9l8M--H-HpfDS5P9OxSPC4fkU17nw3buRymfyzOzMcPn0w';
            break;
        case 'www.particulier-emploi.eu':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxQpHzh4j26_UsqZMppi6YXsfIRwHxQvIiQ3Um0DTeQY4qcHJvN0BVVaqg';
            break;
        case 'www.particuliers-employeur.com':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxQqse1STc4BNP55l3kAnZjFySkZmBRbOOqR3G_lKsCwJXCBLl3a0eEmPw';
            break;
        case 'www.particuliers-employeur.fr':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxQ4_rsWkxc3S9V7QEx-XB0JkxL3hxR3AYpGkOugJd9zL2XjNVlwlJWOxA';
            break;
        case 'www.particulier-employeurs.com':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxSzEn-ND9YJtSiwZblYo4V_7WuDLBRg57XcVx2ftj24avEAPv-Fez-lOg';
            break;
        case 'www.particulier-employeurs.fr':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxRDdyDXGO_l4LYVp7S6CEjkk_2rNxQUOU0TunuhFzz8O8gr_Zy92N9D9Q';
            break;
        case 'www.particulieremployeur.com':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxSOLiChVDqAjv8W5N7s3iKQvGf2EhRHk2Ltel-nUL4dDf_7djKczJYvRw';
            break;
        case 'www.particulieremployeur.fr':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxQs8uoLCVGx-90WJtFGUBHcSSZmxRRvt29frsXvRREDJHilfzKCqf6FqQ';
            break;
        case 'www.particulieremployeurs.fr':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxSJx2RuatoXVQdy9hOnmWHjrWwrlhRMsiYrP9USU3zayJApx7lZnjJUAg';
            break;
        case 'www.particulieremployeurs.com':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxRz0fUxFE0HcSuBZJgwiCsA4fZK0xSm8y0ENCYhh9euPM-nMi1Ow9fFtA';
            break;
        case 'www.particuliersemployeur.fr':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxT0aOW1AnaZD7IM_BmodUZkGo32hBR3IG1Ljl5WnVI8NoAK2jYP-w9wBA';
            break;
        case 'www.particuliersemployeur.com':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxQE2BiSihoFtTJSidmXnPi0_7RzvxQHIWwwbKaMp6tvvbTTU8VadkZOaQ';
            break;
        case 'www.particuliersemployeurs.fr':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxT0aOW1AnaZD7IM_BmodUZkGo32hBR3IG1Ljl5WnVI8NoAK2jYP-w9wBA';
            break;
        case 'www.particulier-emplois.fr':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxTUXspQN5KVz9fYiw1XFG60tLGa5xTy_2C9YZUQDo8d55rOMzkvHtsZFg';
            break;
        case 'www.particulier-emplois.com':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxQAgXGcuf9XlQ33JtAgjocQoJ97RBR8WCJhJekMbag32iF5p5H7Di9yaA';
            break;
        case 'www.particuliers-emploi.fr':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxR312teJ95sOSnQtMpN505wEBFb-hRH93cNKPOWqLGdMqkoXwjvFuhHdA';
            break;
        case 'www.particuliers-emploi.com':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxRm2e7qvLKuyDRjQWDtPn8VBHg3pxTVzaMRV7XG3jDenoIscMV-zCeUFQ';
            break;
        case 'www.particulieremplois.fr':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxRJWE42NKMWIgO095-srvjW_VCpeRQDThHRdvO4R3HIRdo0aDzcgluAOg';
            break;
        case 'www.particulieremplois.com':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxQr1K4QhUY-M5yEnMJjE1yqfEnFzRRbMhCfpUeimYMUebCO-0yyovVGJg';
            break;
        case 'www.particuliersemploi.fr':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxTPTNb3Mh6Ug-iOfwHqN_Ow6zVwMhSCtLc-1TrUf-To7fW6DDu84XEjUQ';
            break;
        case 'www.particuliersemploi.com':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxSFJSyMKuH-JtwJirchaR6tojRJIRQoHAmKWraGddwcNUkWlQLivA6qwQ';
            break;
        case 'www.particulieremploi.fr':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxQN5rwnmdz20ejSjTDC116Y7jn3DxT5NrhI_QLX828csYM8R7SNzxdpQQ';
            break;
        case 'www.particuliersemplois.fr':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxQbVtSxtz_rGS014cv4NcXHBbX_bBQQ1ewbKrKBHMErp6P2dUZXwmxnwQ';
            break;
        case 'www.particuliers-emplois.fr':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxRgXc7O8gp7NQWOs4yBo8xtotxU_BTJzH74Ns7i22ZIiT2kJ9wxFgBV-Q';
            break;
        case 'www.particulier-emploi.fr':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxQb63ksug3haW9kBEJz53wr5jYqnRSy1rp57Di_izw9Bhs9YA-TlTufrQ';
            break;
        case 'localparticulier':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxTVhSlZIvnSmG36EglM4_Jdg6FithSv9jLVNh95MsSWkZo_OPwxcFXYZw';
            break;
        case '91.121.104.29':
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxQsK-aJtW3Wenr6UJ8g_m1ovcygmBRqb5GVkHx9IvyhGLTYrt_B4PW7gg';
            break;
        case 'www.fepem.info':
            $key = 'ABQIAAAAI5i5eesXl9ICWvT2JEIsNhQgcQThrqRY5gXVAIofCiZ6di14KBQAwPcc-XrkfitALeQG3OVA9xsqjg';
            break;
        case 'fepem-refonte.dev.sixandco.com':
            $key = 'ABQIAAAAfSQpJI8O5UWh0ZUE2vutKxTJW3zmKUu7iJkTSQMOfXPF94l0TBQwd__3TIt7PTkddoPNrOtTQDuGig';
            break;
        case 'perepeint.particulieremploi.fr':
            $key = 'ABQIAAAAGSunH-FG7HTykGeOLGTqrhQnl5vD2V19IYjNqZRkXaT4rLVf7xQ7ElWkxrzczSwLZYiP0EYWa6wg-A';
            break;
        default:
            $key = 'ABQIAAAAkbxdoJYdtuelQkpLkPK3CxQN5rwnmdz20ejSjTDC116Y7jn3DxT5NrhI_QLX828csYM8R7SNzxdpQQ';
            break;
    }
    return $key;
}

/**
 * Fonction pour générer un mot de passe aléatoire
 * 
 * @param int $length  longueur du mdp
 * @param string $chars   jeu de caractères
 * @return string $string mdp généré
 */
function makePassword($length=6,$chars='abcdefghijklmnopqrstuvwxyz0123456789'){
   $string = '';
   for($i = 0; $i <= $length-1; $i++) {
      $string .= $chars[rand(0,strlen($chars)-1)];
   }
   return $string;
}

function highlightWordsInText($words,$text) {
    $hightext=$text;
    foreach($words as $word) {
        $pos = stripos($word, "*");
        if($pos !== false) {
            $cleanword=substr($word,0,$pos);
            $hightext=preg_replace(array('/('.$cleanword.'\w+)[\s|.]/'),array('<b>$1</b>'),$hightext);
        } else {
            $hightext = str_ireplace($word, "<b>".$word."</b>",$hightext);
        }
        
    }
    return $hightext;
}
