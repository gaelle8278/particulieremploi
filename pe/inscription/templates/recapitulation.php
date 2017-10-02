<?php
/**
 * Affichage de l'étape 4 du parcours d'inscription : récapitulation
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
?>

<div class="content-central-column">
    <?php
    $step_active="recap";
     include_once('parcours-navigation.php');
    ?>
    <section>
        <div class="bloc-content">
            <h1>Confirmer vos informations</h1>
            <?php
            if($_SESSION['inscription']['sansdepot']==1) {
                $text="Nous vous invitons à vérifier les informations renseignées.";
            } else {
                $text="Nous vous invitons à vérifier les informations renseignées et à valider votre annonce
            pour pouvoir la diffuser";
            }
            ?>
            <p><?php echo $text; ?></p>
            <?php
            if(isset($tabErrorsValid['error']) && !empty($tabErrorsValid['error'])) {
                ?>
                <p><?php echo $tabErrorsValid['error']; ?></p>
                <?php
            }
            ?>
        </div>
        <div class='bloc-content-effect'></div>

        <div class="bloc-content">
            <p class="section-title">Vos coordonnées</p>
            <div class="section-separator"></div>
            <div class="bloc-field-form">
                <div class='bloc-field-inline'>
                    <label class="field-label" >Civilité :</label>
                    <div class="field-value-readonly">
                        <?php echo get_civilite($_SESSION['inscription']['civilite']); ?>
                    </div>
                </div>
            </div>
            <div class="bloc-field-form">
                <label class="field-label" >Nom :</label>
                <div class="field-value-readonly">
                    <?php echo $_SESSION['inscription']['nom']; ?>
                </div>
            </div>
            <div class="bloc-field-form">
                <label class="field-label" >Prénom :</label>
                <div class="field-value-readonly">
                    <?php echo $_SESSION['inscription']['prenom']; ?>
                </div>
            </div>
            <div class="bloc-field-form">
                <label class="field-label" >Adresse :</label>
                <div class="field-value-readonly">
                    <?php echo $_SESSION['inscription']['adresse']; ?>
                </div>
            </div>
            <div class="bloc-field-form">
                <label class="field-label" >Ville :</label>
                <div class="field-value-readonly">
                    <?php echo $_SESSION['inscription']['ville']; ?>
                </div>
            </div>
            <div class="bloc-field-form">
                <div class='bloc-field-inline'>
                    <label class="field-label" >Code postal :</label>
                    <div class="field-value-readonly">
                        <?php echo $_SESSION['inscription']['cpo']; ?>
                    </div>
                </div>
            </div>
            <div class="bloc-field-form">
                <label class="field-label">E-mail :</label>
                <div class="field-value-readonly">
                    <?php echo $_SESSION['inscription']['email']; ?>
                </div>
            </div>
            <?php
            if($type_compte=="SAL") {
                ?>
                <div class="bloc-field-form">
                    <div class='bloc-field-inline'>
                        <label class="field-label" >Téléphone :</label>
                        <div class="field-value-readonly">
                            <?php
                            if(!empty($_SESSION['inscription']['telephone'])) {
                                echo $_SESSION['inscription']['telephone'];
                            } else {
                                echo "Non renseigné";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            }

            if(empty($_SESSION['inscription']['sansdepot'])) {
                ?>
                <p class="section-title">
                    <?php
                    if($type_compte=="SAL") {
                         echo "Votre annonce";
                    } else {
                        echo "Votre offre";
                    }
                    ?>
                </p>
                <div class="section-separator"></div>
                <?php

                //récupération des emplois-repère sélectionnés
                if(!empty($_SESSION['emploi']['erSelect'])) {
                    $queryErLibelle= "select emploi_repere_libelle "
                                . "from ".TBL_EMPLOI_REPERE.""
                                . " where emploi_repere_id in (".$_SESSION['emploi']['erSelect'].")";
                    $resErlibelle=  $wpdb->get_results($queryErLibelle, ARRAY_A);
                    $nbResERLib=$wpdb->num_rows;
                    $cntLib=1;
                    foreach ($resErlibelle as $dataErLib) {
                        if ($cntLib == $nbResERLib) {
                            $libelleER.=$dataErLib['emploi_repere_libelle'];
                        } else {
                            $libelleER.=$dataErLib['emploi_repere_libelle'] . ", ";
                        }
                        $cntLib++;
                    }

                }
                ?>
                <div class="bloc-field-form">
                    <label class="field-label" >Métier choisi :</label>
                    <div class="field-value-readonly">
                        <?php echo $_SESSION['annonce']['annonce_intitulemetier']; ?>
                    </div>
                </div>
                <div class="bloc-field-form">
                    <label class="field-label">Emploi(s)-repère(s) :</label>
                    <div class="field-value-readonly">
                        <?php
                        if(isset($libelleER)) {
                            echo $libelleER;
                        } else {
                            echo "non indiqué";
                        } ?>
                    </div>
                </div>
                <div class="bloc-field-form">
                    <div class='bloc-field-inline'>
                        <label class="field-label">
                           <?php
                            if($type_compte=='SAL') {
                                echo 'Expérience professionnelle';
                            } else {
                                echo 'Expérience demandée';
                            }
                            ?>
                        </label>
                        <div class="field-value-readonly">
                            <?php echo get_experience($_SESSION['annonce']['annonce_experience']); ?>
                        </div>
                    </div>
                    <div class='bloc-field-inline'>
                        <label class="field-label" >Taux horaire :</label>
                        <div class="field-value-readonly">
                            <?php echo $_SESSION['annonce']['annonce_tauxhoraire']." &euro;"; ?>
                        </div>
                    </div>
                </div>
                <div class="bloc-field-form">
                    <div class='bloc-field-inline'>
                        <label class="field-label">Date de prise de fonction </label>
                        <div class="field-value-readonly">
                            <?php echo convert_date($_SESSION['annonce']['annonce_dateprisefonction'], '/'); ?>
                        </div>
                    </div>
                    <div class='bloc-field-inline'>
                        <label class="field-label">Durée hebdomadaire :</label>
                        <div class="field-value-readonly">
                            <?php echo $_SESSION['annonce']['annonce_dureehebdomadaire']." heures"; ?>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>

            <form id="recapitulation" action="/pe/inscription/recapitulation.php" method="post" >
                <?php
                /*if(isset($params['idAnnonce'])) {
                    ?>
                    <input type="hidden" name="idAnnonce" value="<?php echo $params['idAnnonce']; ?>" />
                    <?php
                }*/
                if($type_compte=="EMP") {
                ?>
                    <div class="bloc-field-form">
                        <div class="field-value">
                            <input type='checkbox' name='poleemploi' id='poleemploi'>
                            <label for="poleemploi">En cochant la case, j’accepte que mon annonce soit diffusée sur un site partenaire de
                                Particulieremploi.fr (Pôle emploi)</label>
                        </div>
                    </div>
                <?php 
                }
                ?>
                <div class="bloc-field-form">
                    <div class="field-req field-value">
                        <input id='cgu' name='cgu' type='checkbox' />
                        <label for='cgu'>
                                En cochant la case, j'accepte <a href="<?php echo get_permalink( ID_PAGE_CGU_PE ) ; ?>" title="conditions générales" target="_blank" >les conditions générales d'utilisation du service</a> de particulieremploi.fr <span class='fieldrequired'>*</span>
                        </label>
                    </div>
                    <div class="msg-error-valid"></div>
                </div>

                <p class="field-required text-right">* Saisie obligatoire</p>
                <div class="bloc-submit-form bloc-submit-inscription">
                    <?php
                    if(empty($_SESSION['inscription']['sansdepot'])) {
                        $lienRetour="/pe/inscription/conditions.php";
                    } else {
                        $lienRetour="/pe/inscription/compte.php";
                    }
                    /*$lienRetour .= "?type=".$type_compte."&id=".$params['id']."&domaine_activite=".$params['domaine_activite'];
                    if(isset($params['idAnnonce'])) {
                        $lienRetour .="&idAnnonce=".$params['idAnnonce'];
                    }
                    if (isset($params['metierid'])) {
                        $lienRetour .="&metierid=".$params['metierid'];
                    }*/
                    ?>
                    <a href='<?php echo $lienRetour; ?>' title=''>Retour</a>
                    <input type="submit" name="recap" value="Valider" id="submit_button_recap"/>
                </div>
            </form>

        </div>
    </section><!--@whitespace
    --><aside>
        <?php
         include_once('sidebar-inscription.php');
        ?>
    </aside>
</div>
