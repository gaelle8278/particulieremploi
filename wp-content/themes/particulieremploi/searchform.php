<?php

/**
 * Affichage du formualire de recherche
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

?>

<form method="get" id="custom-form" action="<?php bloginfo('url'); ?>/">   
    <div>
        <input type="text" value="<?php the_search_query(); ?>" name="s" id="s" class="input-style">   
        <input type="submit" id="submit" value="Rechercher"> 
    </div>
</form>