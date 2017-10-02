<?php

/**
 * Header du processus d'inscription
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
?>

<!DOCTYPE html>

<html>
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
                <div class="site-branding">
                    <div class="content-central-column">
                        <div class="header-section logo-section">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <img src="<?php echo get_template_directory_uri() ?>/images/logo.png" alt="logo de particulier emploi"/>
                            </a>
                        </div><!-- @whitespace
                        --><div class="header-section links-section">
                                <a href="/index.php">Retour à la page d'accueil</a> 
                        </div>
                        <div class="banner">
                            <!--<a href="http://participons.emploietdomicile.org/?utm_source=pe&utm_medium=banner&utm_campaign=ban_site" target="_blank">
                                <?php
                                /*$img="FOED_Banniere_employeur.gif";
                                if ($type_compte == "SAL") {
                                    $img="FOED_Banniere_salarie.gif";
                                }*/
                                ?>
                                <img src="<?php echo get_template_directory_uri() ?>/images/banners/Banniere_Promo_Pe.fr_728x90.png" border="0" />
                            </a>-->
                        </div>
                    </div>
                </div>
            </header>
            <main class="inscription <?php echo "ins-".strtolower($type_compte); ?>"> <!-- site content -->