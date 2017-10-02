<?php

/**
 *
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
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
                    $menu_list_main .= "<li id='".$menu_item->ID."'>".$title;
                }
                
            }
            //l'élément suivant est un élément enfant du premier niveau
            if ( $parent_id == $menu_item->menu_item_parent ) {
                //et que le sous-menu n'est pas encore construit on l'ouvre
                if ( !$sub_menu ) {
                    $sub_menu=true;
                     $menu_list_main .= "<div class='sub-menu' id='sub_".$menu_item->menu_item_parent."'><ul>";
                }
                $subparent_id= $menu_item->ID;
                //l'élément n'a pas d'enfant = l'élément suivant n'a pas son id comme parent
                if($menu_items[  $count + 1 ]->menu_item_parent != $subparent_id) {
                      $menu_list_main .= "<li><a href='".$link."'>".$title."</a></li>";
                } else if ($menu_items[  $count + 1 ]->menu_item_parent == $subparent_id) {
                      $menu_list_main .= "<li>".$title
                             . "<ul id='".$menu_item->ID."'>";
                }
                
                //$menu_list_sub .= "<li><a href='".$link."'>".$title."</a>";
                
                
                //si l'élément suivant est un élement de 1er niveau le sous-niveau 1 est fermé
                if ( empty($menu_items[  $count + 1 ]->menu_item_parent) ) { 
                     $menu_list_main .= "</ul></div></li>";      
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
                     $menu_list_main .= "</ul></div></li>";      
                    $sub_menu = false;
                }
                
            }
            $count++;
                
        }
        $menu_list = "<nav class='main-menu'>";
        $menu_list .= "<ul class='main-dropdown'>";
        $menu_list .= $menu_list_main;
        $menu_list .= "</ul>";
        $menu_list .= $menu_list_sub;
        
        $menu_list .= "</nav>";