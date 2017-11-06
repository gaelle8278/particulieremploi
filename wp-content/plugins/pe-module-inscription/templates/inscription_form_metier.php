<?php
?>
                    <div id="choix-metier">
                        <div class="msg-error-valid"></div>
                        <?php
                        if(isset($_SESSION['officer-inscription']['form-error']['jobSelect'])) {
                        ?>
                            <div class="error-valid">
                                <?php
                                echo $_SESSION['officer-inscription']['form-error']['jobSelect'];
                                ?>
                            </div>
                            <?php
                        }
                        foreach($affichageMetiers as $categorie=>$categorieInfos) {
                            ?>
                            <!--entête de la catégorie = entête de l'accordéon-->
                            <h3 id='cat_<?php echo $categorieInfos['id']; ?>'><?php echo ucfirst($categorie); ?>
                                <?php
                                if(!empty($categorieInfos['plusInfos'])) {
                                    ?>
                                    <p class='sousTitreEntete'><?php echo $categorieInfos['plusInfos']; ?></p>
                                    <?php
                                }
                                ?>
                            </h3>
                            <div>
                                <?php
                                foreach ($categorieInfos['listeMetiers'] as $metier) {
                                    $idMetier=$metier[0];
                                    $libelleMetier=$metier[1];
                                    ?>
                                    <div class='blocMetier'>
                                        <p class='optionMetier'>
                                            <input type='radio' name='jobSelect' id='job_<?php echo $idMetier; ?>'  value='<?php echo $idMetier; ?>' class='choixMetier' />
                                            <label for='job_<?php echo $idMetier; ?>'><?php echo ucfirst($libelleMetier); ?></label>
                                        </p>
                                        <?php
                                        if(!empty($metierER[$idMetier])) {
                                            $nbRefER=count($metierER[$idMetier]);
                                            $metierDomaine=$refLibDomaine[$idMetier];
                                            $listeER=$metierER[$idMetier];
                                            ?>
                                            <div class='optionER'>
                                                <!--texte description avant affichage des emplois-repère -->
                                                <p>
                                                    Parmi les 21 emplois-repères de la nouvelle classification, <?php echo $nbRefER; ?> d'entre eux sont relatifs au domaine d’activité &laquo; <?php echo $metierDomaine; ?> &raquo; et correspondent
                                                    chacun à  d’entre à un niveau d’activités. Nous vous invitons à sélectionner le niveau d’activité correspondant  pour qualifier l’emploi du salarié :
                                                </p>
                                                <?php
                                                //affichage des emplois-repères
                                                foreach($listeER as $propER) {
                                                    ?>
                                                    <div class='blocER'>
                                                        <input type='checkbox' name='erSelect[]' id='<?php echo $idMetier."_er_".$propER[0]; ?>' value='<?php echo $propER[0]; ?>' class='choixER' />
                                                        <label for='<?php echo $idMetier."_er_".$propER[0]; ?>' ><?php echo ucfirst($propER[1]); ?></label>
                                                        <div class='descER'><?php echo $propER[2]; ?></div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>

                                        <?php
                                        }
                                        ?>
                               </div>
                            <?php
                            }
                            ?>
                        </div>
                        <?php
                        }
                        ?>

                        <div class="bloc-submit-form text-right">
                            <button type="button" id="button-infos-metier" class="step-validation">Valider le choix du métier</button>
                        </div>
                    </div>

