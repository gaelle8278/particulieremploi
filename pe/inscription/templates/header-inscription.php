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
                                <img src="<?php echo get_template_directory_uri() ?>/images/logo-new-pe.png" alt="logo de particulier emploi"/>
                            </a>
                        </div><!-- @whitespace
                        --><div class="header-section links-section">
                                <a href="/index.php">Retour à la page d'accueil</a> 
                        </div>
                        <div class="banner">
                            <a href="http://particulieremploi.fr/offres-accompagnement-de-la-fepem/" target="_blank">
                                <img src="<?php echo get_template_directory_uri() ?>/images/banners/banniere-ods-970x90.gif" border="0" />
                            </a>
                        </div>
                    </div>
                </div>
            </header>
            <main class="inscription <?php echo "ins-".strtolower($type_compte); ?>"> <!-- site content -->