<?php

/**
 *
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

//===== custom relations menus on homepage ========
function clean_custom_menus($theme_location, $class_menu) {
        $locations = get_nav_menu_locations();
	if (isset($locations[$theme_location])) {
            $menu = get_term($locations[$theme_location], 'nav_menu');
            $menu_items = wp_get_nav_menu_items($menu->term_id);

            $menu_list = "<nav class='menu_relation'>";
            $menu_list .= "<ul class='".$class_menu."'>";
            //compteur du nombre d'éléments
            $nb_items=1;
            $count=0;
            $sub_menu=false;
            foreach ( $menu_items as  $menu_item) {
                $link = $menu_item->url;
                $title = $menu_item->title;
                //l'élément n'est pas un élément enfant
                if ( !$menu_item->menu_item_parent ) {
                    $parent_id = $menu_item->ID;
                 
                    $menu_list .= "<li class='item'><div class='item-content'>";
                    $menu_list .= "<a href='".$link."' />";
                    $menu_list .= "<div class='relation_step'>".$nb_items."</div>";
                    $menu_list .= "<div class='relation_title'>".$title."</div>";
                    $menu_list .= "<div class='submenu_button'> + </div>";
                    $menu_list .= "</a>";
                
                    $nb_items++;
                }
                //l'élément est un élément enfant appartenant à l'élément précédent
                if ( $parent_id == $menu_item->menu_item_parent ) {
                    //et que le sous-menu n'est pas encore construit
                    if ( !$submenu ) {
                        $submenu = true;
                        $menu_list .= "<ul class='sub-menu'>";
                    }
 
                    $menu_list .= "<li>";
                    $menu_list .= "<span> > </span> <a href='".$link."' >".$title."</a>";
                    $menu_list .= "</li>";
                     
                    //si l'élément suivant n'est pas un élément enfant ou
                    //est un élément enfant mais n'ayant pas le même parent
                    //et que le sous-menu est ouvert
                    //=> le sous-menu est fermé et remis à zéro
                    if ( $menu_items[ $count + 1 ]->menu_item_parent != $parent_id && $submenu ){
                        $menu_list .= "</ul>";
                        $submenu = false;
                    }
                }
                //si l'élemnt suivant n'est pas un élément enfant
                // on ferme l'élément courant et on remet à zéro le sous-menu
                if ( $menu_items[  $count + 1 ]->menu_item_parent != $parent_id ) { 
                    $menu_list .= "</div></li>";      
                    $submenu = false;
                }
                
		 $count++;
            }
            $menu_list .= "</ul>";
            $menu_list .= "</nav>";
	} else {
            $menu_list = '<!-- no menu defined in location "'.$theme_location.'" -->';
	}
	echo $menu_list;
}

//========= custom main menu ============
function custom_main_menu () {
    $theme_location= 'main_menu';
    $locations = get_nav_menu_locations();
    if (isset($locations[$theme_location])) {
        $menu = get_term($locations[$theme_location], 'nav_menu');
        $menu_items = wp_get_nav_menu_items($menu->term_id);
        $menu_list_main='';
        $menu_list_sub='';
        
        $count=0;
        $sub_menu=false;
        $sub_menu_menu=false;
        
        foreach ( $menu_items as  $menu_item) {
            $link = $menu_item->url;
            $title = $menu_item->title;
            //élément de 1er niveau
            if ( !$menu_item->menu_item_parent ) {
                $parent_id = $menu_item->ID;
                //$ancestor_id = $menu_item->ID;
                //et l'élément n'a pas d'enfant = élément suivant est un élément de 1er niveau
                if ( empty($menu_items[  $count + 1 ]->menu_item_parent) ) {  
                     $menu_list_main .= "<li id='".$menu_item->ID."'><a href='".$link."'>".$title."</a></li>";
                }
                //si l'élément a des enfants
                else {
                    $menu_list_main .= "<li id='".$menu_item->ID."' class='sub'><a href='#'>".$title."</a>";
                }
                
            }
            //l'élément suivant est un élément enfant du premier niveau
            if ( $parent_id == $menu_item->menu_item_parent ) {
                //et que le sous-menu n'est pas encore construit on l'ouvre
                if ( !$sub_menu ) {
                    $sub_menu=true;
                    $menu_list_main .= "<ul class='sub-menu'>";
                }
                $subparent_id= $menu_item->ID;
                //l'élément n'a pas d'enfant = l'élément suivant n'a pas son id comme parent
                if($menu_items[  $count + 1 ]->menu_item_parent != $subparent_id) {
                     $menu_list_main .= "<li><a href='".$link."'>".$title."</a></li>";
                } else if ($menu_items[  $count + 1 ]->menu_item_parent == $subparent_id) {
                     $menu_list_main .= "<li class='show-subsub-menu'><a href='#'>".$title."</a>"
                             . "<ul id='".$menu_item->ID."'>";
                }
                
                //$menu_list_sub .= "<li><a href='".$link."'>".$title."</a>";
                
                
                //si l'élément suivant est un élement de 1er niveau le sous-niveau 1 est fermé
                if ( empty($menu_items[  $count + 1 ]->menu_item_parent) ) { 
                    $menu_list_main .= "</ul></li>";      
                    $sub_menu = false;
                }
            }
            //2ème et dernier sous-niveau
            if ( $subparent_id == $menu_item->menu_item_parent ) {
                if ( !$sub_menu_menu ) {
                    $sub_menu_menu=true;
                    $menu_list_main .= "<li><a href='".$link."'>".$title."</a></li>";
                } else {
                    $menu_list_main .= "<li><a href='".$link."'>".$title."</a></li>";
                }
                
                 if ( $menu_items[  $count + 1 ]->menu_item_parent != $subparent_id ) { 
                    $sub_menu_menu=false;
                     $menu_list_main .= "</ul></li>";      
                    
                }
                if ( empty($menu_items[  $count + 1 ]->menu_item_parent) ) { 
                     $sub_menu_menu=false;
                    $menu_list_main .= "</ul></li>";      
                    $sub_menu = false;
                }
                
            }
            $count++;
                
        }
        $menu_list = "<nav class='main-menu'>";
        // menu 
        $menu_list .= "<ul class='main-dropdown'>";
        // responsive menu title
        $menu_list .= "<li class='menu-res-title'></li>";
        // menu items
        $menu_list .= $menu_list_main;
        // responsive menu icon
        $menu_list .= '<li class="menu-res-icon">
                        <span id="menu-res"></span>
                       </li>';
        $menu_list .= "</ul>";
        //search icon
        $menu_list .= "<div class='search-menu'></div>";
        $menu_list .= "</nav>";
    } else {
        $menu_list = '<!-- no main menu  -->';
    }
    
    echo $menu_list;
}
//======= pagination ==========
/**
 * Pagination for list page
 *
 * @global $wp_query http://codex.wordpress.org/Class_Reference/WP_Query
 * @return Prints the HTML for the pagination if a template is $paged
 */
function base_pagination($custom_query='') {
    //if custom query
    if(!empty($custom_query)) {
        $wp_query=$custom_query;
    }
    //if main loop
    else {
        global $wp_query;
    }
    $big = 999999999; // need an unlikely integer
    ?>
    <div class="pagination">
        <?php 
            
        echo paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $wp_query->max_num_pages,
            'prev_text' => '<',
            'next_text' => '>'
        ) );
        ?>
    </div>
    <?php
}
//======== geolocalisation  ====
//sans utilisation de plugin
function geoloc2($ip_client) {
    require (dirname( __FILE__ ) . '/geoloc/geoip2.phar');

    // This creates the Reader object, which should be reused across
    // lookups.
    $reader = new GeoIp2\Database\Reader(dirname( __FILE__ ) . '/geoloc/GeoLite2-City.mmdb');

    // Replace "city" with the appropriate method for your database, e.g.,
    // "country".
    $record = $reader->city($ip_client);
    $regionInfos=$record['subdivisions'][0];
    $regionName=$regionInfos[names][fr];
    //echo "<pre>";print_r($record);echo "</pre>";
    
    return $regionName;
}
// grâce au plugin GeoIP Detection
function geolocalisation() {
    $geoip = geoip_detect2_get_info_from_current_ip()->raw;
    //echo "<pre>";print_r($geoip);echo "</pre>";
    if(!empty($geoip['postal'])) {
        $depCode= substr($geoip['postal']['code'],0, 2);
    } else {
        $depCode=$geoip['subdivisions'][0]['iso_code'];
    }
    //$region=$infosRegion['names']['fr'];
    return $depCode;
}

//============== fonctions diverses ================
function get_the_user_ip() {
    if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
    //check ip from share internet
    $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
    //to check ip is pass from proxy
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
    $ip = $_SERVER['REMOTE_ADDR'];
    }
    //$ip='88.186.168.159';
    return $ip;
}

function str_to_noaccent($str)
{
    $url = $str;
    $url = preg_replace('#Ç#', 'C', $url);
    $url = preg_replace('#ç#', 'c', $url);
    $url = preg_replace('#è|é|ê|ë#', 'e', $url);
    $url = preg_replace('#È|É|Ê|Ë#', 'E', $url);
    $url = preg_replace('#à|á|â|ã|ä|å#', 'a', $url);
    $url = preg_replace('#@|À|Á|Â|Ã|Ä|Å#', 'A', $url);
    $url = preg_replace('#ì|í|î|ï#', 'i', $url);
    $url = preg_replace('#Ì|Í|Î|Ï#', 'I', $url);
    $url = preg_replace('#ð|ò|ó|ô|õ|ö#', 'o', $url);
    $url = preg_replace('#Ò|Ó|Ô|Õ|Ö#', 'O', $url);
    $url = preg_replace('#ù|ú|û|ü#', 'u', $url);
    $url = preg_replace('#Ù|Ú|Û|Ü#', 'U', $url);
    $url = preg_replace('#ý|ÿ#', 'y', $url);
    $url = preg_replace('#Ý#', 'Y', $url);
     
    return ($url);
}
/**
 * Fonction qui utilise le code postal pour retrouver la région correspondante
 * 
 * Le code postal est le code retrounée par la géolocalisation
 * 
 * @param string $geo_code  code return by geoloc
 * @param array $tabRegion  array for correspondance code/region
 * @return string   the region
 */
function get_region_from_geocode($geo_code) {
    global $tabRegion;
    foreach($tabRegion as $regionName => $depCodeList) {
        if (in_array($geo_code,$depCodeList)) {
            return $regionName;
        }
    }
    
}