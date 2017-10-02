<?php

/**
 *
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

/**
 * Fonction s'exécutant avant que Wordpress détermine le template à charger.
 * A utiliser si des redirections sont nécessaires.
 * 
 * @see https://codex.wordpress.org/Plugin_API/Action_Reference/template_redirect
 */
/*function pe_forms_process() {
    if (isset($_POST['cesu-load']) && isset($_POST['simu-cesu-verif']))  {
        if (wp_verify_nonce($_POST['simu-cesu-verif'], 'simu-cesu')) {
            //logique métier
            $locCesu=  htmlentities($_POST['cesu_loc']);
            $typeCesu=  htmlentities($_POST['cesu_type']);
            $salaireCesu= htmlentities($_POST['cesu_salaire']);
            $url = add_query_arg('locCesu', $locCesu, wp_get_referer());
            //redirection
            wp_safe_redirect($url);
	}
    }
}
add_action('template_redirect', 'pe_forms_process');*/