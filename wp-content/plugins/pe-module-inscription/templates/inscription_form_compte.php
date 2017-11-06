<?php
?>

                    <div id="compte">
                        <p class="section-title">Coordonnées du contact</p>
                        <div class="bloc-field-form">
                            <label class="field-label-inline">Civilité <span class="field-required">*</span></label>
                            <div class="field-req field-value-inline">
                                <input type="radio" name="civilite" value="1" id="civ-homme"
                                        <?php
                                        if((isset($_SESSION['officer-inscription']['civilite']) && $_SESSION['officer-inscription']['civilite'] == 1) ) {
                                        ?>
                                            checked="checked"
                                        <?php
                                        }
                                        ?>
                                       >
                                <label for="civ-homme">Monsieur</label>
                                <input type="radio" name="civilite" value="2" id="civ-femme"
                                         <?php
                                        if((isset($_SESSION['officer-inscription']['civilite']) && $_SESSION['officer-inscription']['civilite'] == 2) ) {
                                        ?>
                                            checked="checked"
                                        <?php
                                        }
                                        ?>
                                >
                                <label for="civ-femme">Madame</label>
                            </div>
                            <div class="msg-error-valid"></div>
                            <?php
                            if(isset($_SESSION['officer-inscription']['form-error']['civilite'])) {
                                ?>
                                <div class="error-valid">
                                    <?php
                                    echo $_SESSION['officer-inscription']['form-error']['civilite'];
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="bloc-field-form">
                            <div class='bloc-field-inline'>
                                <label class="field-label" for="form-nom">Nom <span class="field-required">*</span></label>
                                <div class="field-req field-value">
                                    <input type="text" placeholder="" name="nom" id="form-nom" class="input-style" size="20"
                                           value="<?php
                                            if(isset($_SESSION['officer-inscription']['nom'])){
                                               echo $_SESSION['officer-inscription']['nom'];
                                           }
                                           ?>"/>
                                </div>
                                <div class="msg-error-valid"></div>
                                    <?php
                                    if(isset($_SESSION['officer-inscription']['form-error']['nom'])) {
                                        ?>
                                        <div class="error-valid">
                                            <?php
                                            echo $_SESSION['officer-inscription']['form-error']['nom'];
                                            ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                            </div>
                            <div class='bloc-field-inline'>
                                <label class="field-label" for="form-prenom">Prénom <span class="field-required">*</span></label>
                                <div class="field-req field-value">
                                    <input type="text" placeholder="" name="prenom" id="form-prenom" class="input-style" size="20"
                                           value="<?php
                                                if(isset($_SESSION['officer-inscription']['prenom'])){
                                                    echo $_SESSION['officer-inscription']['prenom'];
                                                }
                                               ?>"/>
                                </div>
                                <div class="msg-error-valid"></div>
                                    <?php
                                    if(isset($_SESSION['officer-inscription']['form-error']['prenom'])) {
                                        ?>
                                        <div class="error-valid">
                                            <?php
                                            echo $_SESSION['officer-inscription']['form-error']['prenom'];
                                            ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                            </div>
                        </div>
                        <div class="bloc-field-form">
                            <label class="field-label" for="form-adresse">Adresse <span class="field-required">*</span></label>
                            <div class="field-req field-value">
                                <input type="text" placeholder="" name="adresse" id="form-adresse" class="input-style" size="50"
                                       value="<?php
                                            if(isset($_SESSION['officer-inscription']['adresse'])){
                                                echo $_SESSION['officer-inscription']['adresse'];
                                            }
                                            ?>"/>
                            </div>
                            <div class="msg-error-valid"></div>
                                    <?php
                                    if(isset($_SESSION['officer-inscription']['form-error']['adresse'])) {
                                        ?>
                                        <div class="error-valid">
                                            <?php
                                            echo $_SESSION['officer-inscription']['form-error']['adresse'];
                                            ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                        </div>
                        <div class="bloc-field-form">
                            <div class='bloc-field-inline'>
                                <label class="field-label" for="form-ville">Ville <span class="field-required">*</span></label>
                                <div class="field-req field-value">
                                    <input type="text" placeholder="" name="ville" id="form-ville" class="input-style" size="20"
                                           value="<?php
                                                if(isset($_SESSION['officer-inscription']['ville'])){
                                                    echo $_SESSION['officer-inscription']['ville'];
                                                }
                                                ?>"/>
                                </div>
                                <div class="msg-error-valid"></div>
                                    <?php
                                    if(isset($_SESSION['officer-inscription']['form-error']['ville'])) {
                                        ?>
                                        <div class="error-valid">
                                            <?php
                                            echo $_SESSION['officer-inscription']['form-error']['ville'];
                                            ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                            </div>
                            <div class='bloc-field-inline'>
                                <label class="field-label" for="form-cp">Code postal <span class="field-required">*</span></label>
                                <div class="field-req field-value">
                                    <input type="text" placeholder="" name="cpo" id="form-cp" class="input-style" size="20"
                                           value="<?php
                                                if (isset($_SESSION['officer-inscription']['cpo'])) {
                                                    echo $_SESSION['officer-inscription']['cpo'];
                                                }
                                                ?>" />
                                </div>
                                <div class="msg-error-valid"></div>
                                    <?php
                                    if(isset($_SESSION['officer-inscription']['form-error']['cpo'])) {
                                        ?>
                                        <div class="error-valid">
                                            <?php
                                            echo $_SESSION['officer-inscription']['form-error']['cpo'];
                                            ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                            </div>
                        </div>

                        <div class="form-separator"></div>
                        <p class="section-title">Création des identifiants du compte</p>
                        <p>L'adresse e-mail et le mot de passe renseignés dans les champs ci-après
                        permettront au contact d'accéder à son Espace de mise en relation
                        une fois que son inscription sera finalisée.
                        </p>
                        <div class="bloc-field-form">
                            <div class='bloc-field-inline'>
                                <label class="field-label" for="form-email">E-mail <span class="field-required">*</span></label>
                                <div class="field-req field-value">
                                    <input type="text" placeholder="" name="email" id="form-email" class="input-style" size="20"
                                           value="<?php
                                                if(isset($_SESSION['officer-inscription']['email'])){
                                                    echo $_SESSION['officer-inscription']['email'];
                                                }
                                                ?>"
                                                />
                                </div>
                                <div class="msg-error-valid"></div>
                                    <?php
                                    if(isset($_SESSION['officer-inscription']['form-error']['email'])) {
                                        ?>
                                        <div class="error-valid">
                                            <?php
                                            echo $_SESSION['officer-inscription']['form-error']['email'];
                                            ?>
                                        </div>
                                    <?php
                                    }
                                    ?>
                            </div>
                            <div class='bloc-field-inline'>
                                <label class="field-label" for="form-check-email">
                                    Confirmation E-mail <span class="field-required">*</span>
                                </label>
                                <div class="field-value">
                                    <input type="text" placeholder="" name="emailconfirm" id="form-check-email"
                                           class="input-style" size="20"
                                           value=""/>
                                </div>
                                <div class="msg-error-valid"></div>
                                <?php
                                if(isset($_SESSION['officer-inscription']['form-error']['emailconfirm'])) {
                                    ?>
                                    <div class="error-valid">
                                        <?php
                                        echo $_SESSION['officer-inscription']['form-error']['emailconfirm'];
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="bloc-field-form">
                            <div class='bloc-field-inline'>
                                <label class="field-label" for="form-mdp">Mot de passe <span class="field-required">*</span></label>
                                <div class="field-req field-value">
                                    <input type="password" placeholder="" name="mdp" id="form-mdp" class="input-style" size="20"
                                           value="" />
                                </div>
                                <div class="msg-error-valid"></div>
                                <?php
                                if(isset($_SESSION['officer-inscription']['form-error']['mdp'])) {
                                    ?>
                                    <div class="error-valid">
                                        <?php
                                        echo $_SESSION['officer-inscription']['form-error']['mdp'];
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class='bloc-field-inline'>
                                <label class="field-label" for="form-check-mdp">
                                    Confirmation mot de passe <span class="field-required">*</span>
                                </label>
                                <div class="field-value">
                                    <input type="password" placeholder="" name="mdpconfirm" id="form-check-mdp"
                                           class="input-style" size="20"
                                           value="" />
                                </div>
                                <div class="msg-error-valid"></div>
                                <?php
                                if(isset($_SESSION['officer-inscription']['form-error']['mdpconfirm'])) {
                                            ?>
                                    <div class="error-valid">
                                        <?php
                                        echo $_SESSION['officer-inscription']['form-error']['mdpconfirm'];
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="bloc-submit-form text-right">
                            <button type="button" id="button-infos-compte" class="step-validation">Valider les informations du compte</button>
                        </div>
                    </div>

