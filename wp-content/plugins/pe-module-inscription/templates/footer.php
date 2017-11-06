<?php
/**
 * Footer du module d'inscription simplifiée
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
?>
        <footer role="contentinfo">
            <div class="sub-footer">
                    <a href="<?php echo get_permalink( ID_PAGE_CGU_FEPEM ); ?>" title="conditions générales d'utilisation et d'adhésion FEPEM">Conditions générales d'adhésion et d'utilisation FEPEM</a>
                    <a class="inside" href="<?php echo get_permalink( ID_PAGE_CGU_PE ); ?>" title="condiditions générales d'utilisation de la mise en relation">Conditions générales d'utilisation de la mise en relation</a>
                    <a class="inside" href="<?php echo get_permalink( ID_PAGE_MENTIONS ); ?>" title="mentions légales">Mentions légales</a>
                    <span class="inside">&copy; 2016 particulieremploi.fr</span>
                </div>
	</footer>

    </div><!-- .site container -->


    <!--avertissement sur l'utilisation des cookies-->
    <script src="<?php echo get_template_directory_uri(); ?>/js/cookiechoices.js"></script>
    <script>document.addEventListener('DOMContentLoaded', function(event){
        cookieChoices.showCookieConsentBar("Ce site utilise des cookies à des fins d'analyse d'audience. \n\
            En poursuivant votre navigation, vous acceptez l’utilisation des cookies.",
        "J'accepte",
        'En savoir plus',
        '<?php echo get_permalink(ID_PAGE_MENTIONS); ?>');
    });
    </script>

    
    <?php wp_footer(); ?>

    </body>
</html>