<?php

/**
 * Affichage du header
 *
 * Contient les éléments de la balise <head> et le contenu du <body> avec le contenu principal
 * 
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
?>
<!doctype html>
<!--[if (lte IE 7)&!(IEMobile)]> <html lang="fr" class="ie7 old-ie no-js"> <![endif]-->
<!--[if (IE 8)&!(IEMobile)]> <html lang="fr" class="ie8 old-ie no-js"> <![endif]-->
<!--[if (gt IE 8)&!(IEMobile)]><!--> <html lang="fr" class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width">
        <title>
            <?php
            if ( is_search() ) {
                echo 'Résultats de recherche pour "'.get_search_query().'" | ';
            } elseif (is_front_page() ) {
                echo " Particulieremploi.fr le site de l’emploi à domicile ";
            } else {
                wp_title('',true);
            }
            ?>
        </title>
        <?php
        if (is_single() || is_page()) {
            $metaDescription = get_post_meta((int)$post->ID, 'meta-description', true);
        }
        if(!isset($metaDescription) || empty($metaDescription)) {
            $metaDescription= wp_title('', false);
        }
        ?>
        <meta name="description" content="<?php echo $metaDescription; ?>">
        <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri() ?>/images/favicon-32x32.png">
        <!--[if lt IE 9]>
            <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <!--- popup de connexion --->
        <?php get_template_part("popup-connexion") ?>
        <div class="container">
            
            <header  role="banner">
                <!-- header is fixed, so out of flow, a wrap div is necessary 
                to center header content  as the site content -->
                <div class="site-branding">
                    <div class="content-central-column">
                        <div class="header-section logo-section">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <img src="<?php echo get_template_directory_uri() ?>/images/logo-new-pe.png" alt="logo de particulier emploi"/>
                            </a>
                        </div><!-- @whitespace
                        --><div class="header-section buttons-section">
                            <?php
                            if(isset($_SESSION['utilisateur_id']) && !empty($_SESSION['utilisateur_id'])) {
                                ?>
                                <div class="user-menu-section">
                                    <ul>
                                        <li><a href="/pe/espace-pe/compte.php" title="Accès à mon espace de mise en relation">
                                            <?php echo ucwords($_SESSION['utilisateur_nomprenom']); ?></a>
                                            <ul>
                                                <li><a href="/pe/espace-pe/compte.php" title="Accès à mon espace de mise en relation"> 
                                                        Mon compte </a>
                                                </li>
                                                <li><a href="/pe/espace-pe/logout.php" title="déconnexion"> Déconnexion </a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                <?php
                                } else {
                                    ?>
                                    <div class="header-button espace-relation">
                                        <a href="/pe/espace-pe/connexion.php" class="popup-button" data-modal="popup">
                                            Accès à mon espace <br />de mise en relation</a>
                                    <?php
                                }
                                ?>
                                </div><!-- @whitespace
                                --><div class="header-button espace-pe">
                                    <a href="http://reseau.fepem.fr">Accès à mon espace <br /> particulier employeur</a>
                                </div>
                        </div>
                            
                         <div class="banner">
                           <a href="http://particulieremploi.fr/offres-accompagnement-de-la-fepem/" target="_blank">
                                <?php
                               /* $img="FOED_Banniere_employeur.gif";
                                if (is_single()) { 
                                    $postCategories = get_the_category();
                                    if (!empty($postCategories)) {
                                        foreach ($postCategories as $category) {
                                            $postCatSlugs[] = $category->slug;
                                        }
                                    }
                                    if(in_array(SLUGCATSPE, $postCatSlugs)) {
                                        $img="FOED_Banniere_salarie.gif";
                                    } 
                                }*/
                                ?>
                                <img src="<?php echo get_template_directory_uri() ?>/images/banners/banniere-ods-970x90.gif" border="0" />
                            </a>
                        </div>
                        <?php
                            
                        //menu principal
                        //wp_nav_menu(array('theme_location' => 'main_menu', 'container' => 'nav', 'menu_class'=>'main-dropdown', 'container_class'=>'main-menu'));
                        custom_main_menu();
                        get_search_form();
                        ?>
                    </div>
                </div>
            </header>
            <main> <!-- site content -->
               
                
