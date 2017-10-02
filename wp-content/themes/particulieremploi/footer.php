<?php

/**
 * Affichage du footer
 *
 * Fermeture de la balise <main> et de la <div> container et contenu du footer
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
?>

        </main> <!-- .site content -->
	<footer role="contentinfo">
                <div class="main-footer">
                    <div class="content-central-column">
                        <div class="top-footer">
                            <p>plan du site</p>
                            <?php
                            if(is_active_sidebar( 'footer-widget-1' )) {
                                ?>
                                <div class="widget-footer-container widget-footer-container-first">
                                    <?php
                                    dynamic_sidebar('footer-widget-1');
                                    ?>
                                </div>
                                <?php
                            }
                            if(is_active_sidebar( 'footer-widget-2' )) {
                                ?>
                                <div class="widget-footer-container widget-footer-container-middle">
                                    <?php
                                    dynamic_sidebar('footer-widget-2');
                                    ?>
                                </div>
                                <?php
                            }
                            if(is_active_sidebar( 'footer-widget-3' )) {
                                ?>
                                <div class="widget-footer-container widget-footer-container-last">
                                    <?php
                                    dynamic_sidebar('footer-widget-3');
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="bottom-footer">
                            <div class="widget-footer-container widget-footer-container-first">
                                <div class="footer-title">Les offres d'accompagnement</div>
                                <div class="footer-title-separator"></div>
                                <ul class="menu">
                                    <li><a href="<?php echo get_permalink( ID_PAGEESSENTIEL ); ?>">
                                            Les Essentiels du Particulier Employeur</a></li>
                                    <li><a href="<?php echo get_permalink( ID_PAGE_OFFRE_CONTRAT ); ?>">
                                            Formules d’accompagnement juridique Contrat de travail</a></li>
                                    <li><a href="<?php echo get_permalink( ID_PAGE_OFFRE_REMUNERATION ); ?>">
                                            Formules d’accompagnement juridique Rémunération</a></li>
                                    <li><a href="<?php echo get_permalink( ID_PAGE_OFFRE_RELATION ); ?>">
                                            Formules d’accompagnement juridique Relation de travail</a></li>
                                    <li><a href="<?php echo get_permalink( ID_PAGE_OFFRE_SEPARATION ); ?>">
                                            Formules d’accompagnement juridique Se séparer</a></li>
                                </ul>
                            </div>
                            <div class="widget-footer-container widget-footer-container-middle">
                                <div class="footer-title">Contact</div>
                                <div class="footer-title-separator"></div>
                                <ul class="menu">
                                    <li><a href="mailto:contact@particulieremploi.fr" title="écrire à contact@particulieremploi.fr">contact@particulieremploi.fr</a></li>
                                    <li>0825 07 64 64 (0,15€/min + prix de l’appel)</li>
                                </ul>
                            </div>
                            <div class="widget-footer-container widget-footer-container-last">
                                <div class="footer-title">Suivez-nous</div>
                                <div class="footer-title-separator"></div>
                                <div class="social-links">
                                    <a href="<?php echo LINK_FACEBOOK ?>"><img src="<?php echo get_template_directory_uri() ?>/images/pictos/footer-btn-facebook.png" /></a>
                                    <a href="<?php echo LINK_TWITTER ?>"><img src="<?php echo get_template_directory_uri() ?>/images/pictos/footer-btn-twitter.png" /></a>
                                     <!--<a href="<?php echo LINK_YOUTUBE ?>"><img src="<?php echo get_template_directory_uri() ?>/images/pictos/footer-btn-twitter.png" /></a>-->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="sub-footer">
                    <a href="<?php echo get_permalink( ID_PAGE_CGU_FEPEM ); ?>" title="conditions générales d'utilisation et d'adhésion FEPEM">Conditions générales d'adhésion et d'utilisation FEPEM</a>
                    <a class="inside" href="<?php echo get_permalink( ID_PAGE_CGU_PE ); ?>" title="condiditions générales d'utilisation de la mise en relation">Conditions générales d'utilisation de la mise en relation</a>
                    <a class="inside" href="<?php echo get_permalink( ID_PAGE_MENTIONS ); ?>" title="mentions légales">Mentions légales</a>
                    <span class="inside">&copy; 2016 particulieremploi.fr</span>
                </div>
	</footer>
    </div><!-- .site container -->
    <div class="overlay"></div><!-- La div overlay pour les effets popup -->
    <div class="overlay-menu"></div><!-- La div overlay pour les effets main menu -->


    <!-- google analytics -->
    <script src="<?php echo get_template_directory_uri(); ?>/js/google-analytics.js"></script>

    <?php wp_footer(); ?>

    </body>
</html>
