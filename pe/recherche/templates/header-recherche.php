<?php

/**
 * Header pour la recherche= header principal à l'exception du body class
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
            Résultats de la recherche d'annonces
        </title>
        <meta name="description" content="Résultats de la recherche d'annonces sur Particulier Emploi, le site de l'emploi à domicile">
        <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri() ?>/images/favicon-32x32.png">
        <!--[if lt IE 9]>
            <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <?php wp_head(); ?>
    </head>

    <body class="colored-back-page">
        <!--- popup de connexion --->
        <?php get_template_part("popup-connexion") ?>
        <div class="container">
            
            <header role="banner">
                <!-- header is fixed, so out of flow, a wrap div is necessary 
                to center header content  as the site content -->
                <div class="site-branding">
                    <div class="content-central-column">
                        <div class="header-section logo-section">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <img src="<?php echo get_template_directory_uri() ?>/images/logo.png" alt="logo de particulier emploi"/>
                            </a>
                        </div><!-- @whitespace
                        --><div class="header-section buttons-section">
                            <div class="header-button espace-relation">
                                <a href="/pe/espace-pe/page-connexion.php" class="popup-button" data-modal="popup">
                                    Accès à mon espace <br />de mise en relation</a>
                            </div><!-- @whitespace
                            --><div class="header-button espace-pe">
                                <a href="http://reseau.fepem.fr">Accès à mon espace <br /> particulier employeur</a>
                            </div>
                        </div>
                        
                        <div class="banner">
                            <!--<a href="http://particulieremploi.fr/offres-accompagnement-de-la-fepem/" target="_blank">
                                <?php
                                /*$img="FOED_Banniere_employeur.gif";
                                if ($params['type_annonce'] == "emp") {
                                    $img="FOED_Banniere_salarie.gif";
                                }*/
                                ?>
                                <img src="<?php echo get_template_directory_uri() ?>/images/banners/BANNER-ODS-728X90.gif" border="0" />
                            </a>-->
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
               
                

