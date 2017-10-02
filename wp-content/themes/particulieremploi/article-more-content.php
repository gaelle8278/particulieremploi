<?php

/**
 * Template part qui affiche les articles en relation de l'article
 * Les articles en relation sont définis grâce au "plugin Manual Related Post"
 * 
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

$relatedPosts=do_shortcode( '[manual_related_posts]' );
if ( isset ( $relatedPosts ) && !empty( $relatedPosts )) {
?>

<div class="article-more-content">
    <div class="related-post-title"> Sur le même sujet</div>
    <div class="section-title-separator"></div>
    <?php
    //related post
    
    echo $relatedPosts; 
    ?>
</div>
<?php
}