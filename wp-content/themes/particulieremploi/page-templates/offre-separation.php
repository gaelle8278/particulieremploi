<?php

/* 
 * Template Name: offre FEPEM Se séparer
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
                    <img class="img-formule" src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/picto-separer.png" alt=""/>
                    <h1 class="section-content-title">3 bonnes raisons de souscrire <br>une formule « <span class="text-bold">Se séparer</span> »</h1>
                </div>
                <div class="wrap-clear"></div>
                <div class="summary-formule">
                    <div class="wrapper small">
                        <div>
                            1
                        </div>
                        <p>
                            Vous êtes accompagné pour que la rupture se passe au mieux.
                        </p>
                    </div>
                    <div class="wrapper">
                        <div>
                            2
                        </div>
                        <p>
                            Vous versez à  votre salarié ce que vous lui devez.
                        </p>
                    </div>
                    <div class="wrapper">
                        <div>
                            3
                        </div>
                        <p>
                            Vous sécurisez votre fin de contrat en respectant les délais et les courriers à rédiger.
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
                        <p>Formule Séparation <br> <span class="text-bold text-italic">Sécurité <span class="text-super">*</span></span></p>
                        <div class="intro-offre-sep"></div>
                        <div class="market-formule">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/icon-1consultation.png" alt=""/>
                            <p><span class="high-text">1</span><span class="text-bold"> consultation<br>150€ </span>/ 6 mois</p>
                        </div>
                    </div>
                    <div class="sous-bloc-aplat"></div>
                    <div class="bloc-page-wrap">
                        <div class="desc-formule">
                            <p class="smaller-box"> Vous souhaitez mettre fin à votre contrat de travail 
                            avec votre salarié, ou c'est votre salarié qui le souhaite : 
                            quelles règles ? Quels délais ? Quels courriers ? Et comment calculer le solde de tout compte ?</p>
                        </div>
                        <div>
                             <form name="securite" id="securite" action="http://services.fepem.fr/web/guest/les-offres" method="GET">
                                <input type="hidden" name="typeFormule" value="fSeparationSecurite" >
                                <p class="text-formule">Je bénéficie de la consultation :</p>
                                <div class="aplat-option aplat-option-included">
                                    <div>
                                        <p><img src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/btn-radio-disable-orange.png" />
                                            Rupture du contrat de travail et calcul des indemnités de fin de contrat
                                        </p>
                                         <input type="hidden" name="consultation" value="cRuptureContrat" >
                                    </div>
                                </div>
                                <div class="submit-button">
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
                        <p>Formule Séparation <br> <span class="text-bold text-italic">Décès <span class="text-super">*</span></span></p>
                        <div class="intro-offre-sep"></div>
                        <div class="market-formule">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/icon-1consultation.png" alt=""/>
                            <p><span class="high-text">1</span><span class="text-bold"> consultation<br>150€ </span>/ 6 mois</p>
                        </div>
                    </div>
                    <div class="sous-bloc-aplat"></div>
                    <div class="bloc-page-wrap">
                        <div class="desc-formule">
                            <p class="smaller-box">Au décès d'un proche, que devez-vous faire s'il employait un salarié à domicile ? <br><br>
                                Faîtes-vous accompagner dans les formalités liées à la rupture du contrat de travail.</p>
                        </div>
                        <div>
                            <form name="deces" id="deces" action="http://services.fepem.fr/web/guest/les-offres" method="GET">
                                <input type="hidden" name="typeFormule" value="fSeparationDeces" >
                                <p class="text-formule">Je bénéficie de la consultation :</p>
                                <div class="aplat-option aplat-option-included">
                                    <div>
                                        <p><img src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/btn-radio-disable-orange.png" />
                                             Formalités liées au décès de l'employeur, 
                                             rupture du contrat de travail et calcul 
                                             des indemnités de fin de contrat
                                        </p>
                                        <input type="hidden" name="consultation" value="cRuptureContrat" >
                                    </div>
                                </div>
                                <div class="submit-button">
                                    <input type="submit" value="Je souscris" >
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>     
        <p class='nb-formule'><span class='text-super'>*</span> Pour en bénéficier, vous devez vous acquitter 
            d'un droit d'entrée de 12€, payable 1 fois pour une durée illimitée,<br>
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
                                <span class="text-bold">0825 07 64 64</span> (0,15 €/min + prix de l'appel)
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

