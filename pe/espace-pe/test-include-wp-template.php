<?php

/**
 *
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

//pour pouvoir utiliser les fonctions natives de wordpress
require( dirname(dirname(dirname(__FILE__))).'/wp-load.php' );

//header('location:/index.php');

get_header('espacepe');
echo 'new content outside WordPress';

//PDO ok
/*$conn = new PDO('mysql:host=localhost;dbname=wp_pe;', 'root', 'admMSKIWI');
foreach ($conn->query("SELECT * FROM tbl_utilisateurs limit 10") as $row) 
    echo $row['utilisateur_id'];*/

//Query builder with custom table OK
$resultats = $wpdb->get_results("SELECT * FROM tbl_utilisateurs limit 10") ;
foreach ($resultats as $post) {
  echo $post->utilisateur_id ;
  echo '<br/>' ;
}


get_template_part("logos-partenaires");
get_footer();