<?php

/**
 * Header de l'espace perso de pe
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
            if ( isset($meta['title']) ) {
                echo $meta['title'];
            } else {
               wp_title('',true);
            }
            ?>
        </title>
        <?php
        if( isset($meta['desc']) ) {
            $metaDescription=$meta['desc'];
        } else {
            $metaDescription=wp_title('', false);;
        }
        ?>
        <meta name="description" content="<?php echo $metaDescription; ?>">
        <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri() ?>/images/favicon-32x32.png">
        <!--[if lt IE 9]>
            <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <?php wp_head(); ?>
    </head>

    <body class="colored-back-page">
        <div class="container">
            <header role="banner">
                <!-- header is fixed, so out of flow, a wrap div is necessary 
                to center header content  as the site content -->
                <div class="site-branding">
                    <div class="content-central-column">
                        <div class="header-section logo-section">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <img src="<?php echo get_template_directory_uri() ?>/images/logo-new-pe.png" alt="logo de particulier emploi"/>
                            </a>
                        </div><!-- @whitespace
                        --><div class="header-section header-section-espacepe">
                            <div class="header-espacepe-login"><?php echo ucwords($_SESSION["utilisateur_nomprenom"]); ?></div>
                            <div class="header-espacepe-logout">
                                <a href="/pe/espace-pe/logout.php">
                                    <img src="<?php echo get_template_directory_uri() ?>/images/pictos/btn-deconnexion.png"
                                         alt="croix de déconnexion" />
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="banner">
                        <a href="http://bit.ly/VideoPetiteEnfance" target="_blank">
                            <img src="<?php echo get_template_directory_uri() ?>/images/banners/Bannière-Particulieremploi.fr-TPEP-970x90.gif" border="0" />
                        </a>
                    </div>
                    
                    <?php
                    if ($_SESSION['utilisateur_groupe'] == "EMP") {
                        include_once(dirname(__FILE__).'/menu-espacepe-emp.php');
                        //get_template_part("menu-espacepe", "emp");
                    } else {
                        include_once(dirname(__FILE__).'/menu-espacepe-sal.php');
                        //get_template_part("menu-espacepe", "sal");
                    }
                    ?>
                </div>
            </header>
            <main class="espacepe-main"> <!-- site content -->