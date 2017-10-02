<?php
/**
 * Barre latérale des pages et articles "magazine"
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

get_template_part('widget-offre-essentielle');
if (is_active_sidebar('article-magazine-sidebar')) {
?>
    <div class="sidebar-widget-article">
        <?php
        dynamic_sidebar('article-magazine-sidebar');
        ?>
    </div> 
    <?php
}
if (is_active_sidebar('article-magazine-sidebar2')) {
    ?>
    <div class="sidebar-widget-article">
        <?php
        dynamic_sidebar('article-magazine-sidebar2');
        ?>
    </div> 
    <?php
}
if (is_active_sidebar('article-magazine-sidebar3')) {
    ?>
    <div class="sidebar-widget-article">
        <?php
        dynamic_sidebar('article-magazine-sidebar3');
        ?>
    </div> 
    <?php
}