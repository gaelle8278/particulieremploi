<?php
/**
 * Header
 */
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width">
        <title>
            Statistiques inscription pe.fr - Partenariat Valenciennes
        </title>
        <meta name="description" content="Interface d'acccès aux statistiques relatives au module d'inscription développé dans le cadre du partenariat avec Valenciennes Métropole">
        <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri() ?>/images/favicon-32x32.png">
        <!--[if lt IE 9]>
            <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <?php wp_head(); ?>
        <!--<link rel="stylesheet" href="inc/assets/datepicker/datepicker.min.css" type="text/css" media="all">-->
        <link rel="stylesheet" href="inc/assets/style.css" type="text/css" media="all">
    </head>
    <body class="colored-back-page">
        <div class="container">
            <header role="banner">
                <div class="site-branding">
                    <div class="content-central-column">
                        <div class="header-section logo-section">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <img src="images/logo.png" alt="logo de particulier emploi"/>
                            </a>
                        </div><!-- @whitespace
                        --><div class="header-section links-section">
                            <img src="images/Valenciennes-Metropole.png" alt="logo de Valenciennes Métropole"/>
                            
                        </div>
                        <nav class='module-menu'>
                            
                        </nav>
                    </div>
                </div>
            </header>
            <main> <!-- site content -->
