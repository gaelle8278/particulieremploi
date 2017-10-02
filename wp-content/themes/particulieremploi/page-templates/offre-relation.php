<?php

/*
 * Template Name: offre FEPEM La relation de travail
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
get_header('without-nav');
?>
<section class="essentiels-tpl2 essentiels-formule">
    <!-- aplat gris d'entete -->
    <div class="wrap-image">
        <div class="top-link"><a href="<?php echo get_permalink( ID_PAGEESSENTIEL ); ?>" title="lien page Les Essentiels">< Toutes nos offres d'accompagnement</a></div>
    </div>
    <div class="content-central-column section-content">
        <div class="bloc-page-offre">
            <div class="bloc-page-wrap">
                <div class="head-formule">
                    <img class="img-formule" src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/picto-relation.png" alt=""/>
                    <h1 class="section-content-title">3 bonnes raisons de souscrire <br>une formule « <span class="text-bold">Relation de travail</span> »</h1>
                </div>
                <div class="wrap-clear"></div>
                <div class="summary-formule">
                    <div class="wrapper">
                        <div>
                            1
                        </div>
                        <p>
                           Vous maitrisez la gestion des absences imprévues de votre salarié.
                        </p>
                    </div>
                    <div class="wrapper">
                        <div>
                            2
                        </div>
                        <p>
                            Vous souhaitez organiser la formation de votre salarié.
                        </p>
                    </div>
                    <div class="wrapper">
                        <div>
                            3
                        </div>
                        <p>
                            Vous savez comment intervenir en cas de non respect des horaires, de vos instructions, des règles de sécurité...
                        </p>
                    </div>
                </div>
                <div class="logo"><img src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/logo-servive-FEPEM.png" alt="logo service FEPEM"/></div>
            </div>
        </div>
        <div class="inter-bloc"></div>
        <div class="bloc-formule bloc-formule-alone">
            <div class="bloc-wrapper-offre">
                <div class="bloc-offre">
                    <div class="aplat-intro-offre">
                        <p>Formule Relation <br> <span class="text-bold text-italic">Déclic <span class="text-super">*</span></span></p>
                        <div class="intro-offre-sep"></div>
                        <div class="market-formule">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/icon-1consultation.png" alt=""/>
                            <p><span class="high-text">1</span><span class="text-bold"> consultation<br>80€ </span>/ 3 mois</p>
                        </div>
                    </div>
                    <div class="sous-bloc-aplat"></div>
                    <div class="bloc-page-wrap">
                        <div class="desc-formule">
                            Faire face à l’absence  de votre salarié ou à un conflit
                            ne doit pas troubler votre organisation.
                            <br>Prenez conseil et agissez !
                        </div>
                        <div>
                             <form name="declic" id="declic" action="http://services.fepem.fr/web/guest/les-offres" method="GET">
                                <input type="hidden" name="typeFormule" value="fRelationlDeclic" >
                                <p class="text-formule">Je choisis une consultation parmi :</p>
                                <div class="aplat-option aplat-option-choosen">
                                    <div>
                                        <input type="radio" name="consultation" value="cGestionAbsenceSalarie" id="opt1form1">
                                        <label for="opt1form1">Gestion de l'absence du salarié : maladie, accident du travail, formation ... (hors congés payés)</label>
                                    </div>
                                </div>
                                <p class="text-formule">ou :</p>
                                <div class="aplat-option aplat-option-choosen">
                                    <div>
                                        <input type="radio" name="consultation" value="cConseilProcDiciplinaire" id="opt2form1">
                                        <label for="opt2form1">Conseil pour la procédure disciplinaire (hors licenciement) </label>
                                    </div>
                                </div>
                                <div class="submit-button">
                                    <p class="error-msg"></p>
                                    <input type="submit" value="Je souscris" >
                                </div>
                             </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            jQuery(document).ready( function($) {
                $('form').submit(function () {
                    valid=true;
                    if( $(this).find('input[type=radio][name=consultation]:checked').length !=1 ) {
                        $(this).find(".error-msg").fadeIn().text("Veuillez sélectionner une consultation");
                        valid= false;
                    } else {
                        $(this).find(".error-msg").hide().text("");
                    }

                    return valid;
                });
            });
        </script>
        <p class='nb-formule'><span class='text-super'>*</span> Pour en bénéficier, vous devez vous acquitter
            d'un droit d’entrée de 12€, payable 1 fois pour une durée illimitée,<br>
            vous permettant de devenir membre de la FEPEM et de profiter des « Essentiels
            du particulier employeur » (modèles, fiches pratiques, réseau social dédié)</p>
        <div class="bloc-page-offre">
            <div class="bloc-page-wrap">
                <div class="bloc-contacter">
                    <div class="wrapper">
                        <div class="contact-postal">
                            <span class="text-bold">Je préfère souscrire par voie postale</span>
                            <p>
                                Je télécharge <a class="content-link"
                               href="http://particulieremploi.fr/wp-content/uploads/2017/01/FEPEM_Souscription-services_Bulletin-papier.doc"
                                                 target="_blank">le bulletin pour souscrire aux formules d’accompagnement juridique</a>
                                et le renvoie complété, accompagné d'un règlement par chèque du montant
                                indiqué : à FEPEM, 79 rue de Monceau, 75008 Paris
                            </p>
                        </div>
                    </div><!-- @whitespace
                    --><div class="wrapper">
                        <div class="contact-tel">
                            <span class="text-bold">Vous avez besoin de précisions ?</span>
                            <p>
                                Contactez nos conseillers du lundi au jeudi, de 9h à 18h, 
                                et le vendredi de 9h à 17h, au
                                <span class="text-bold">0825 07 64 64</span> (0,15 €/min + prix de l’appel)
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
get_footer('mini');
