<?php
/**
 * Header du module d'inscription simplifiée
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
        <title>Module d'inscription simplifiée</title>
        <meta name="description" content="Module d'inscription simplifiée">
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
                            <?php
                            if (is_user_logged_in()) {
                                ?>
                                <a href="<?php echo wp_logout_url(); ?>">Se déconnecter</a>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="banner">

                        </div>
                    </div>
                </div>
            </header>
            
