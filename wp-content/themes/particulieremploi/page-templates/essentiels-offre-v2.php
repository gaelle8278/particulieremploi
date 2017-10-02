<?php

/**
 * Template Name: Les Essentiels du Particulier Employeur
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
get_header('without-nav');
?>
<section class="essentiels-tpl2">
    <!-- aplat gris d'entete -->
    <div class="wrap-image">
    </div>
    
    <div class="content-central-column section-content">
        <div class="bloc-page-offre">
            <div class="bloc-page-wrap">
                <h1 class="section-content-title">Vous êtes Particulier Employeur ?</h1>
                <div class="section-content-separator"></div>
                <p class="text-teaser">Devenez membre de la FEPEM et bénéficiez d'un accompagnement <br>
                    personnalisé à tous les moments clés de la relation de travail
                </p>
                <div class="logo"><img src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/logo-servive-FEPEM.png" alt="logo service FEPEM"/></div>
            </div>
            <div class="aplat-intro"><span class="text-bold">Les Essentiels</span> 
                du Particulier Employeur
            </div>
            <div class="sous-aplat-intro">Droit d’entrée de 12€, acquitté une fois, valable pour une durée illimitée</div>
            <div class="bloc-page-wrap">
                <div class="bloc-list">
                    <ul>
                        <li> <span class="text-bold">Accès illimité à l'Espace
                                Particulier Employeur,</span><br>
                                Le seul réseau social réservé aux particuliers employeurs
                            <ul>
                                <li>Questions aux conseillers FEPEM et forum d’échanges </li>
                                <li>Espace documentaire juridique et pratique (modèles de contrats, conseils utiles et mémos, exemples, …)</li>
                                <li>Recherche de profils de salariés par métier et selon votre code postal</li>
                                <li>Simulateur du coût de l'emploi</li>
                                <li>Conventions collectives et grilles de salaires avec mises à jour</li>
                                <li>Tchats thématiques mensuels</li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- @whitespace
                --><div  class="bloc-list">
                    <ul>
                        <li>
                            <span class="text-bold">Numéro de téléphone réservé,</span><br>
                            appel et services gratuits
                        </li>
                        <li>
                            <span class="text-bold">Invitation aux événements,</span><br>
                            de votre région
                        </li>
                        <li>
                            <span class="text-bold">Lettre d'information des Particuliers Employeurs</span>
                            et alertes en cas d'actualités concernant l'emploi à domicile
                        </li>
                        <li>
                            <span class="text-bold">Défense du statut fiscal
                            et social du particulier employeur</span>
                        </li>
                    </ul>
                    
                </div>
                <div class="bloc-adhesion">
                    <a href="http://services.fepem.fr/web/guest/la-fepem-et-vous/adherer-a-la-fepem/formulaire"
                       title="accès inscription FEPEM">
                    Je souhaite devenir membre de la FEPEM et accéder aux Essentiels
                    </a>
                    <p class="text-bold">* Droit d'entrée de 12€, acquitté une fois, valable pour une durée illimitée</p>
                </div>
                <p class="text-center"> 
                    Je préfère souscrire par voie postale. Je télécharge
                    <a class="content-link" href="http://particulieremploi.fr/wp-content/uploads/2017/01/FEPEM_Souscription-services_Bulletin-papier.doc"
                       title="bulletin d'adhesion FEPEM" target="_blank">le bulletin d'adhésion</a>
                     et le renvoie complété, accompagné <br> d'un règlement par chèque d'un montant de 
                     12€, à FEPEM, 79 rue de Monceau, 75008 Paris 
                </p>
            </div>
        </div>
        <div class="bloc-page-offre">
            <div class="aplat-intro">
                Nos formules d'accompagnement
            </div>
            <div class="sous-aplat-intro text-upper">A partir de 80€</div>
            <div class="bloc-page-wrap">
                <div class="bloc-list-1-3 bloc-list-1-3-first">
                    <div  class="bloc-list">
                        <ul>
                            <li>
                                Une assistance et des conseils juridiques sur mesure
                            </li>
                        </ul>
                    </div>
                </div><!-- @whitespace
                    --><div class="bloc-list-1-3 bloc-list-1-3-middle">
                        <div  class="bloc-list">
                            <ul>
                                <li>
                                    Un accompagnement personnalisé par un juriste référent et 
                                    en fonction de votre région
                                </li>
                            </ul>
                        </div>
                    </div> <!-- @whitespace
                    --><div class="bloc-list-1-3">
                        <div class="bloc-list">
                            <ul>
                                <li>
                                    Une réponse rapide et opérationnelle par téléphone 
                                    et par courriel

                                </li>
                            </ul>
                        </div>
                    </div>
                <div class="bloc-presentation">
                            <div class="formule-encart">
                                <div class="wrapper">
                                    <a href="<?php echo get_permalink( ID_PAGE_OFFRE_CONTRAT ); ?>">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/img-contrat.png" alt="" />
                                        <div class='formule-encart-desc'>
                                            <p>
                                                <img src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/icon-juridique.png" alt="">
                                            </p>
                                            <p class="text-bold">
                                                Etablir le contrat <br>de travail
                                            </p>
                                            <p><span class="btn-souscrire">En savoir +</span></p>
                                        </div>
                                    </a>
                                </div>
                            </div><!-- @whitespace
                            --><div class="formule-encart">
                                <div class="wrapper">
                                    <a href="<?php echo get_permalink( ID_PAGE_OFFRE_REMUNERATION ); ?>">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/img-remuneration.png" alt="" />
                                        <div class='formule-encart-desc'>
                                            <p>
                                                <img src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/icon-juridique.png" alt="">
                                            </p>
                                            <p class="text-bold">
                                                Déclarer et<br> rémunérer
                                            </p>
                                            <p><span class="btn-souscrire">En savoir +</span></p>
                                        </div>
                                    </a>
                                </div>
                            </div><!-- @whitespace
                            --><div class="formule-encart">
                                <div class="wrapper">
                                    <a href="<?php echo get_permalink( ID_PAGE_OFFRE_RELATION ); ?>">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/img-relation.png" alt="" />
                                        <div class='formule-encart-desc'>
                                            <p>
                                                <img src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/icon-juridique.png" alt="">
                                            </p>
                                            <p class="text-bold">
                                                Gérer la relation<br> de travail
                                            </p>
                                            <p><span class="btn-souscrire">En savoir +</span></p>
                                        </div>
                                    </a>
                                </div>
                            </div><!-- @whitespace
                            --><div class="formule-encart">
                                <div class="wrapper">
                                    <a href="<?php echo get_permalink( ID_PAGE_OFFRE_SEPARATION ); ?>">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/img-se-separer.png" alt="" />
                                    <div class='formule-encart-desc'>
                                        <p>
                                            <img src="<?php echo get_template_directory_uri(); ?>/images/les-essentiels/icon-juridique.png" alt="">
                                        </p>
                                        <p class="text-bold">
                                            Se séparer
                                            <br>
                                            &nbsp;
                                        </p>
                                        <p><span class="btn-souscrire">En savoir +</span></p>
                                    </div>
                                    </a>
                                </div>
                            </div>
                </div>
                <div class="bloc-contacter">
                    <div class="wrapper">
                        <div class="contact-postal">
                            <span class="text-bold">Je préfère souscrire par voie postale</span>
                            <p>
                                Je télécharge <a class="content-link" 
                                href="http://particulieremploi.fr/wp-content/uploads/2017/01/FEPEM_Souscription-services_Bulletin-papier.doc"
                                                 target="_blank">le bulletin d'adhésion</a>
                                et le renvoie complété, accompagné d'un règlement par chèque d'un montant
                                de 12€ à FEPEM, 79 rue de Monceau, 75008 Paris
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