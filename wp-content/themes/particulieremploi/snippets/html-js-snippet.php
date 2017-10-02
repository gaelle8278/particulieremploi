<?php

/**
 *
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
?>

<!-- bibliothèque pour effet blur à l'appartion de la popup de connexion -->
<! -- voir le css associé dans style.css -->
<script>  
    var polyfilter_scriptpath = '<?php echo get_template_directory(); ?>/js/polyfill/lib/';  
</script>
<script src="<?php echo get_template_directory_uri(); ?>/js/polyfill/lib/cssParser.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/polyfill/lib/css-filters-polyfill.js"></script>