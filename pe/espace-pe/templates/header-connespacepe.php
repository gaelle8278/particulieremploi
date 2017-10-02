<?php

/**
 *
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
            <?php if(isset($title)) {
                echo $title;
            } else {
                echo "Connexion espace de mise en relation";
            }
            ?>
        </title>
        <meta name="description" content="Connexion à l'espace de mise en relation de Particulier Emploi, le site de l'emploi à domicile">
        <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri() ?>/images/favicon-32x32.png">
        <!--[if lt IE 9]>
            <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <?php wp_head(); ?>
    </head>

    <body <?php echo isset($classes)?$classes:""; ?> >
        <div class="container">
            <header role="banner">
                <div class="site-branding">
                    <div class="content-central-column">
                        <div class="header-section logo-section">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <img src="<?php echo get_template_directory_uri() ?>/images/logo.png" alt="logo de particulier emploi"/>
                            </a>
                        </div><!-- @whitespace
                        --><div class="header-section links-section">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Retour à la page d'accueil</a> 
                        </div>
                        
                        <div class="banner">
                            <!--<a href="http://participons.emploietdomicile.org/?utm_source=pe&utm_medium=banner&utm_campaign=ban_site" target="_blank">
                                <img src="<?php echo get_template_directory_uri() ?>/images/banners/Banniere_Promo_Pe.fr_728x90.png" border="0" />
                            </a>-->
                        </div>
                        <?php
                        //menu principal
                        custom_main_menu();
                        get_search_form();
                        ?>
                    </div>
                </div>
            </header>
            
            <main> <!-- site content -->