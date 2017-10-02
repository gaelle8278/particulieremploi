<?php

/**
 * Affichage d'un mini footer
 *
 * Fermeture de la balise <main> et de la <div> container et contenu du footer
 * 
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
?>
        </main> <!-- .site content -->
        <footer role="contentinfo">
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