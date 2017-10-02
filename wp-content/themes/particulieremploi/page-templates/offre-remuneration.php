<?php

/*
 * Template Name: offre FEPEM La rémunération
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
                    <img class="img-formule" src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/picto-remuneration.png" alt=""/>
                    <h1 class="section-content-title">3 bonnes raisons de souscrire <br>une formule « <span class="text-bold">Rémunération</span> »</h1>
                </div>
                <div class="wrap-clear"></div>
                <div class="summary-formule">
                    <div class="wrapper">
                        <div>
                            1
                        </div>
                        <p>
                            Vous connaissez le coût réel de l’emploi à domicile.
                        </p>
                    </div>
                    <div class="wrapper">
                        <div>
                            2
                        </div>
                        <p>
                            Vous rémunérez et déclarez votre salarié comme il se doit.
                        </p>
                    </div>
                    <div class="wrapper">
                        <div>
                            3
                        </div>
                        <p>
                            Vous devenez incollable sur les congés payés de votre salarié.
                        </p>
                    </div>
                </div>
                <div class="logo"><img src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/logo-servive-FEPEM.png" alt="logo service FEPEM"/></div>
            </div>
        </div>
        <div class="inter-bloc"></div>
        <div class="bloc-formule">
            <div class="bloc-wrapper-offre">
                <div class="bloc-offre">
                    <div class="aplat-intro-offre">
                        <p>Formule Rémunération <br> <span class="text-bold text-italic">Déclic <span class="text-super">*</span></span></p>
                        <div class="intro-offre-sep"></div>
                        <div class="market-formule market-formule-small">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/icon-1consultation.png" alt=""/>
                            <p><span class="high-text">1</span><span class="text-bold"> consultation<br>80€ </span>/ 3 mois</p>
                        </div>
                    </div>
                    <div class="sous-bloc-aplat"></div>
                    <div class="bloc-page-wrap">
                        <div class="desc-formule">
                            <p>Vous avez des questions sur les congés payés ou sur le calcul de la rémunération.
                            <br><br>
                            Laissez-nous vous guider !</p>
                        </div>
                        <div>
                             <form name="declic" id="declic" action="http://services.fepem.fr/web/guest/les-offres" method="GET">
                               <input type="hidden" name="typeFormule" value="fRemunerationDeclic" >
                                <p class="text-formule">Je choisis une consultation parmi :</p>
                                <div class="aplat-option aplat-option-choosen">
                                    <div>
                                        <input type="radio" name="consultation" value="cGestionConges"  id="opt1form1">
                                        <label for="opt1form1">la gestion des congés payés : acquisition, prise et paiement</label>
                                    </div>
                                </div>
                                <p class="text-formule">ou :</p>
                                <div class="aplat-option aplat-option-choosen">
                                    <div>
                                        <input type="radio" name="consultation" value="cCalculRenumeration" id="opt2form1">
                                        <label for="opt2form1">le calcul de la rémunération et aide à la déclaration</label>
                                    </div>
                                </div>
                                <p class="text-formule">&nbsp;</p>
                                <div class="aplat-option aplat-option-empty">
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
            <div class="bloc-inter-offre"></div>
            <div class="bloc-wrapper-offre">
                <div class="bloc-offre">
                    <div class="aplat-intro-offre">
                        <p>Formule Rémunération <br> <span class="text-bold text-italic">Sécurité <span class="text-super">*</span></span></p>
                        <div class="intro-offre-sep"></div>
                        <div class="market-formule  market-formule-small">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/icon-2consultations.png" alt=""/>
                            <p><span class="high-text">2</span><span class="text-bold"> consultations<br>150€ </span>/ 6 mois</p>
                        </div>
                    </div>
                    <div class="sous-bloc-aplat"></div>
                    <div class="bloc-page-wrap">
                        <div class="desc-formule">
                            <p>Vous avez des questions sur les
                                congés payés ou sur le calcul de la rémunération et
                                souhaitez une aide à la rédaction de votre contrat de travail.
                            </p>
                        </div>
                        <div>
                            <form name="securite" id="securite" action="http://services.fepem.fr/web/guest/les-offres" method="GET">
                                 <input type="hidden" name="typeFormule" value="fRemunerationSecurite" >
                                <p class="text-formule">Je bénéficie de la consultation :</p>
                                <div class="aplat-option aplat-option-included">
                                    <div>
                                        <p><img src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/btn-radio-disable-orange.png" />
                                            la rédaction ou vérification du contrat de travail
                                        </p>
                                         <input type="hidden" name="consultation" value="cRedacOuVerifContrat" >
                                    </div>
                                </div>
                                <p class="text-formule">et je choisis une consultation parmi :</p>
                                <div class="aplat-option aplat-option-choosen">
                                    <div>
                                        <input type="radio" name="consultation" value="cGestionConges" id="opt1form2">
                                        <label for="opt1form2">la gestion des congés payés </label>
                                    </div>
                                </div>
                                <p class="text-formule">ou :</p>
                                <div class="aplat-option aplat-option-choosen">
                                    <div>
                                        <input type="radio" name="consultation" value="cCalculRenumeration" id="opt2form2">
                                        <label for="opt2form2">le calcul de la rémunération et aide à la déclaration</label>
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
            <div class="bloc-inter-offre"></div>
            <div class="bloc-wrapper-offre">
                <div class="bloc-offre">
                    <div class="aplat-intro-offre">
                        <p>Formule Rémunération <br> <span class="text-bold text-italic">Tout compris <span class="text-super">*</span></span></p>
                        <div class="intro-offre-sep"></div>
                        <div class="market-formule  market-formule-small">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/icon-tout-compris.png" alt=""/>
                            <p><br><span class="text-bold">300€ </span>/ 12 mois</p>
                        </div>
                    </div>
                    <div class="sous-bloc-aplat"></div>
                    <div class="bloc-page-wrap">
                        <div class="desc-formule">
                            <p>Vous souhaitez une formule
                                tout en un : nous vous aidons
                                à rédiger le contrat de travail (et/ou le vérifions)
                                et établissons les bulletins de salaire.
                            </p>
                        </div>
                        <div>
                            <form name="tout_compris" id="tout_compris" action="http://services.fepem.fr/web/guest/les-offres" method="GET">
                                <input type="hidden" name="typeFormule" value="fRemunerationTcompris" >
                                <p class="text-formule">Je bénéficie de la consultation :</p>
                                <div class="aplat-option aplat-option-included">
                                    <div>
                                        <p><img src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/btn-radio-disable-orange.png" />
                                            la rédaction ou vérification du contrat de travail
                                        </p>
                                        <input type="hidden" name="consultation" value="cRedacOuVerifContrat" >
                                    </div>
                                </div>
                                <p class="text-formule">et de l’édition des bulletins de salaire :</p>
                                <div class="aplat-option aplat-option-included">
                                    <div>
                                        <p><img src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/btn-radio-disable-orange.png" />
                                            l'édition mensuelle des bulletins de salaire sur 12 mois pour un salarié
                                        </p>
                                        <input type="hidden" name="consultation" value="cBulletinsSalaire" >
                                    </div>
                                </div>
                                <p class="text-formule">&nbsp;</p>
                                <div class="aplat-option aplat-option-empty">
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
                    if($(this).find('input[type=radio][name=consultation]').length) {
                        if( $(this).find('input[type=radio][name=consultation]:checked').length !=1 ) {
                            $(this).find(".error-msg").fadeIn().text("Veuillez sélectionner une consultation");
                            valid= false;
                        } else {
                            $(this).find(".error-msg").hide().text("");
                        }
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
