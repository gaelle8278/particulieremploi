<?php

/**
 * Affichage de la première étape du processus d'inscription : infos compte
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
?>
<div class="content-central-column">
    <?php
    $step_active="compte";
    include_once('parcours-navigation.php');
    ?>
    <section>
        <div class="bloc-content">
            <h1>Création de compte</h1>
            <p>Nous vous remercions de remplir le formulaire ci-après.<br />
                Pour avoir un compte actif, vous devez compléter votre inscription jusqu'à l’étape de confirmation.
            </p>
            <p>
                <p class="text-bold">
                <?php
                if($type_compte=="EMP") {
                    echo "Vous êtes déjà inscrit à Particulieremploi.fr
                        et souhaitez directement accéder aux profils de 
                        salariés ?";
                } else {
                    echo "Vous êtes déjà inscrit à Particulieremploi.fr 
                            et souhaitez directement accéder aux offres d’emploi ?";
                }
                ?>
            </p>
            <p>
                Nous vous invitons à vous connecter avec les identifiants 
                que vous avez renseignés lors de votre inscription 
                <?php
                    $linkConnexion="/pe/espace-pe/connexion.php";
                    if(!empty($_SESSION['idAnnonce'])) {
                        $linkConnexion .= "?idAnnonce=".$_SESSION['idAnnonce'];
                    } 
                ?>
            </p>
                <a class="content-link" href="<?php echo $linkConnexion; ?>" title="page de connexion à l'espace de mise en relation">
                > Se connecter
                </a>
            
            <p class="field-required text-right">* Saisie obligatoire</p>
        </div>
        <div class='bloc-content-effect'></div>
        
         <div class="bloc-content">
            <?php
            if(isset($message)) {
                ?>
                <p><?php echo $message; ?></p>
                <?php
            }
            ?>
            <form id="form-inscription" class="inscription-compte" action="/pe/inscription/compte.php" method="POST" >
                <p class="section-title">Mes coordonnées</p>
                <div class="section-separator"></div>
                <div class="bloc-field-form">
                    <label class="field-label-inline">Civilité <span class="field-required">*</span></label>
                    <div class="field-req field-value-inline">
                        <input type="radio" name="civilite" value="1" id="civ-homme"
                                <?php
                                if((isset($_SESSION['inscription']['civilite']) && $_SESSION['inscription']['civilite'] == 1) ||
                                (isset($_SESSION['submitted-values']['civilite']) && $_SESSION['submitted-values']['civilite']==1 )) {
                                ?>
                                    checked="checked"
                                <?php
                                }
                                ?>
                               >
                        <label for="civ-homme">Monsieur</label>
                        <input type="radio" name="civilite" value="2" id="civ-femme"
                                 <?php
                                if((isset($_SESSION['inscription']['civilite']) && $_SESSION['inscription']['civilite'] == 2) ||
                                (isset($_SESSION['submitted-values']['civilite']) && $_SESSION['submitted-values']['civilite']==2 )) {
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
                    if(isset($tabDisplayError['civilite'])) {
                        ?>
                        <div class="error-valid">
                            <?php
                            echo $tabDisplayError['civilite'];
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
                                   if(isset($_SESSION['submitted-values']['nom'])) {
                                       echo $_SESSION['submitted-values']['nom'];
                                   } else if(isset($_SESSION['inscription']['nom'])){
                                       echo $_SESSION['inscription']['nom'];
                                   }
                                   ?>"/>
                        </div>
                        <div class="msg-error-valid"></div>
                            <?php
                            if(isset($tabDisplayError['nom'])) {
                                ?>
                                <div class="error-valid">
                                    <?php
                                    echo $tabDisplayError['nom'];
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
                                        if(isset($_SESSION['submitted-values']['prenom'])) {
                                            echo $_SESSION['submitted-values']['prenom'];
                                        } else if(isset($_SESSION['inscription']['prenom'])){
                                            echo $_SESSION['inscription']['prenom'];
                                        }
                                       ?>"/>
                        </div>
                        <div class="msg-error-valid"></div>
                            <?php
                            if(isset($tabDisplayError['prenom'])) {
                                ?>
                                <div class="error-valid">
                                    <?php
                                    echo $tabDisplayError['prenom'];
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
                                    if(isset($_SESSION['submitted-values']['adresse'])) {
                                        echo $_SESSION['submitted-values']['adresse'];
                                    } else if(isset($_SESSION['inscription']['adresse'])){
                                        echo $_SESSION['inscription']['adresse'];
                                    }
                                    ?>"/>
                    </div>
                    <div class="msg-error-valid"></div>
                            <?php
                            if(isset($tabDisplayError['adresse'])) {
                                ?>
                                <div class="error-valid">
                                    <?php
                                    echo $tabDisplayError['adresse'];
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
                                        if(isset($_SESSION['submitted-values']['ville'])) {
                                            echo $_SESSION['submitted-values']['ville'];
                                        } else if(isset($_SESSION['inscription']['ville'])){
                                            echo $_SESSION['inscription']['ville'];
                                        }
                                        ?>"/>
                        </div>
                        <div class="msg-error-valid"></div>
                            <?php
                            if(isset($tabDisplayError['ville'])) {
                                ?>
                                <div class="error-valid">
                                    <?php
                                    echo $tabDisplayError['ville'];
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
                                        if(isset($_SESSION['submitted-values']['cpo'])) {
                                            echo $_SESSION['submitted-values']['cpo'];
                                        } else if (isset($_SESSION['inscription']['cpo'])) {
                                            echo $_SESSION['inscription']['cpo'];
                                        }
                                        ?>" />
                        </div>
                        <div class="msg-error-valid"></div>
                            <?php
                            if(isset($tabDisplayError['cpo'])) {
                                ?>
                                <div class="error-valid">
                                    <?php
                                    echo $tabDisplayError['cpo'];
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                    </div>
                </div>
                <?php
                if($type_compte=="SAL") {
                    ?>
                    <div class="bloc-field-form">
                        <div class='bloc-field-inline'>
                            <label class="field-label" for="form-tel">Téléphone</label>
                            <div class="field-check field-value">
                                <input type="text" placeholder="" name="telephone" id="form-tel" class="input-style" size="20"
                                       value="<?php
                                            if(isset($_SESSION['submitted-values']['telephone'])) {
                                                echo $_SESSION['submitted-values']['telephone'];
                                            } else if(isset($_SESSION['inscription']['telephone'])) {
                                                echo $_SESSION['inscription']['telephone'];
                                            }
                                            ?>"/>
                            </div>
                            <div class="msg-error-valid"></div>
                            <?php
                            if(isset($tabDisplayError['telephone'])) {
                                ?>
                                <div class="error-valid">
                                    <?php
                                    echo $tabDisplayError['telephone'];
                                    ?>
                                </div>
                                <?php
                            }
                           ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
                
                <div class="form-separator"></div>
                <p class="section-title">Créer mon identifiant et mot de passe</p>
                <div class="section-separator"></div>
                <p>L'adresse e-mail et le mot de passe renseignés dans les champs ci-après
                permettront de vous identifier pour accéder à votre Espace de mise en relation
                une fois que votre inscription sera finalisée.
                </p>
                <div class="bloc-field-form">
                    <div class='bloc-field-inline'>
                        <label class="field-label" for="form-email">E-mail <span class="field-required">*</span></label>
                        <div class="field-req field-value">
                            <input type="text" placeholder="" name="email" id="form-email" class="input-style" size="20"
                                   value="<?php
                                        if(isset($_SESSION['submitted-values']['email'])) {
                                                echo $_SESSION['submitted-values']['email'];
                                        } else if(isset($_SESSION['inscription']['email'])){
                                            echo $_SESSION['inscription']['email'];
                                        }
                                        ?>"
                                        />
                        </div>
                        <div class="msg-error-valid"></div>
                            <?php
                            if(isset($tabDisplayError['email'])) {
                                ?>
                                <div class="error-valid">
                                    <?php
                                    echo $tabDisplayError['email'];
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
                                   value="<?php
                                        if(isset($_SESSION['submitted-values']['emailconfirm'])) {
                                            echo $_SESSION['submitted-values']['emailconfirm'];
                                        }
                                        ?>"/>
                        </div>
                        <div class="msg-error-valid"></div>
                        <?php
                        if(isset($tabDisplayError['emailconfirm'])) {
                            ?>
                            <div class="error-valid">
                                <?php
                                echo $tabDisplayError['emailconfirm'];
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
                                   value="<?php
                                        if(isset($_SESSION['submitted-values']['mdp'])) {
                                            echo $_SESSION['submitted-values']['mdp'];
                                        }
                                        ?>" />
                        </div>
                        <div class="msg-error-valid"></div>
                        <?php
                        if(isset($tabDisplayError['mdp'])) {
                            ?>
                            <div class="error-valid">
                                <?php
                                echo $tabDisplayError['mdp'];
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
                                   value="<?php
                                        if(isset($_SESSION['submitted-values']['mdpconfirm'])) {
                                            echo $_SESSION['submitted-values']['mdpconfirm'];
                                        }
                                        ?>" />
                        </div>
                        <div class="msg-error-valid"></div>
                        <?php
                        if(isset($tabDisplayError['mdpconfirm'])) {
                                    ?>
                            <div class="error-valid">
                                <?php
                                echo $tabDisplayError['mdpconfirm'];
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>

                
                <div class="form-separator"></div>
                
                <div class="bloc-submit-form">
                    <?php
                    //condition d'affichage du bouton contacter directement le salarié/l'employeur
                    //si l'on vient de la recherche un bouton pour contacter directement le salarié/l'employeur aparaît
                    if($type_compte == "EMP" && !empty($_SESSION['idAnnonce'])) {
                        $label_contact="Contacter directement le salarié";
                        ?>

                        <input type="submit" name="contact" value="<?php echo $label_contact; ?>" class="submit_button_ins">
                        <?php 
                    }
                    
                    if($type_compte == "EMP" ) {
                        //si l'employeur vient de la recherche on adapte le label
                        if (!empty($_SESSION['idAnnonce'])) {
                            $label_depot="Déposer votre offre d'emploi et contacter le salarié";
                        } else {
                            $label_depot="Déposer votre offre d'emploi et contacter les salariés";
                        }
                    } elseif ($type_compte == "SAL") {
                        $label_depot="Déposer votre annonce et contacter les employeurs";
                    }
                    ?>
                    
                    <input type="submit" name="depot" value="<?php echo $label_depot; ?>" class="submit_button_ins">

                    <input type="hidden" id="form-button" name="form-button" value="" />
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