<?php

/**
 *
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
?>
<section class="<?php echo $_SESSION['utilisateur_groupe'] == 'SAL'?"compte-sal":"compte-emp"; ?>">
    <div class="content-central-column">
        <div class="bloc-header-espacepe">
            <p class="bloc-header-title">
               Mon Profil
            </p>
            <p class="bloc-header-teaser">
               
            </p>
        </div>
        <div class="wrap-clear"></div>
        
        <div class="bloc-content">
            <p class="bloc-content-title">Mes coordonnées</p>
            <?php
            //édition
            if(isset($action) && $action=="modif") { 
                ?>
                <form id="formulaire" name="formulaire" action="/pe/espace-pe/profil.php" method="post" onsubmit="return checkform()">
                    <input type="hidden" name="part" value="modifierdb" />
                    <div>
                    </div>
                    <div class="bloc-field-form">
                        <div class='bloc-field-inline'>
                            <label class="field-label" for="civilite">Civilité : <span class="field-required">*</span></label>
                            <div class="field-value">
                                <div class="select-style">
                                    <select name="civilite" id="civilite">
                                        <option value="1" <?php echo $code_civilite == 1 ? "selected='selected'" : ""; ?>>Monsieur</option>
                                        <option value="2" <?php echo in_array($code_civilite,[2,3]) ? "selected='selected'" : ""; ?>>Madame</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php 
                        if($naissance!=0000) { 
                            ?>
                            <div class='bloc-field-inline'>
                                <label class="field-label" for="naissance">Année de naissance : </label>
                                <div class="field-value" >
                                    <input type="text" name="naissance"  id="naissance" class="input-style datepicker" value="<?php if($naissance!=0000) { echo $naissance;} ?>" />
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="bloc-field-form">
                        <div class='bloc-field-inline'>
                            <label class="field-label" for="nom">Nom :</label>
                            <div class="field-value">
                               <input type="text" name="nom" id="nom" class="input-style" value="<?php echo $nom; ?>" />
                            </div>
                        </div>
                            <div class='bloc-field-inline'>
                                <label class="field-label" for="prenom">Prénom : </label>
                                <div class="field-value">
                                    <input type="text" name="prenom" id="prenom" class="input-style" value="<?php echo $prenom ;?>" />
                                </div>
                            </div>
                    </div>
                    <div class="bloc-field-form">
                            <label class="field-label" for="adresse">Adresse : </label>
                            <div class="field-value">
                                <input type="text" id="adresse" name="adresse" class="input-style" value="<?php echo $adresse; ?>" />
                            </div>
                    </div>
                    <div class="bloc-field-form">
                        <div class='bloc-field-inline'>
                            <label class="field-label" for="ville">Ville : </label>
                            <div class="field-value">
                                 <input type="text" id="ville" name="ville" class="input-style" value="<?php echo $ville; ?>"/>
                            </div>
                        </div>
                        <div class='bloc-field-inline'>
                            <label class="field-label" for="codepostal">Code postal : </label>
                            <div class="field-value">
                                 <input type="text" id="codepostal" name="codepostal" class="input-style" value="<?php echo $cpo; ?>" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="bloc-field-form">
                        <label class="field-label" for="mail">Email : </label>
                        <div class="field-value">
                            <input type="text" id="mail" name="mail" class="input-style" value="<?php echo $mail; ?>" />
                        </div>
                    </div>
                    <div class="bloc-field-form">
                        <div class='bloc-field-inline'>
                            <label class="field-label" for="oldmdp">Ancien mot de passe : </label>
                            <div class="field-value">
                                <input type="password" id="oldmdp" name="oldmdp" class="input-style" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="bloc-field-form">
                        <div class='bloc-field-inline'>
                            <label class="field-label" for="newmdp">Nouveau mot de passe : </label>
                            <div class="field-value">
                                 <input type="password" id="newmdp" name="newmdp" class="input-style" />
                            </div>
                        </div>
                        <div class='bloc-field-inline'>
                            <label class="field-label" for="confnewmdp">Confirmer votre mot de passe : </label>
                            <div class="field-value">
                                <input type="password" id="confnewmdp" name="confnewmdp" class="input-style" />
                            </div>
                        </div>
                    </div>

                    <div class="bloc-buttons-espacepe">
                        <a href="/pe/espace-pe/profil.php">Retour</a>
                        <input type="submit" value="Enregister">
                    </div>
                </form>
            
                <script>
                    function checkform() {
                        comparaison = /[^A-Za-z0-9_\.@]+/;
                        string1= document.formulaire.newmdp.value;
                        string2=document.formulaire.confnewmdp.value;
                        if (string1==string2){
                            if (comparaison.test(string1)){
                                document.formulaire.newmdp.value='';
                                document.formulaire.confnewmdp.value='';
                                alert('Caractères spéciaux interdits ! Merci de resaisir votre mot de passe.');
                                return false;
                            } else {
                                return true;
                            }
                        } else {
                            document.formulaire.confnewmdp.value='';
                            alert('Votre mot de passe ne correspond pas au premier.');
                            return false;
                        }
                    }
                </script>
                <?php
               
            } else {
                //visualisation
                if(isset($errorMessage)) {
                    ?>
                    <p class="error-update"><?php echo $errorMessage; ?></p>
                    <?php
                } elseif(isset($message)) {
                    ?>
                    <p class="msg-update"><?php echo $message; ?></p>
                    <?php
                }
                ?>
                <div class="bloc-field-form">
                    <div class='bloc-field-inline'>
                        <label class="field-label">Civilité : </label>
                        <div class="field-value-readonly">
                            <?php echo $civilite; ?>
                        </div>
                    </div>
                    <?php 
                    if($naissance!=0000) { 
                        ?>
                        <div class='bloc-field-inline'>
                            <label class="field-label" >Année de naissance : </label>
                            <div class="field-value-readonly">
                                <?php echo $naissance; ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="bloc-field-form">
                    <div class='bloc-field-inline'>
                        <label class="field-label">Nom :</label>
                        <div class="field-value-readonly">
                            <?php echo $nom; ?>
                        </div>
                    </div>
                        <div class='bloc-field-inline'>
                            <label class="field-label" >Prénom : </label>
                            <div class="field-value-readonly">
                                <?php echo $prenom; ?>
                            </div>
                        </div>
                </div>
                <div class="bloc-field-form">
                        <label class="field-label">Adresse : </label>
                        <div class="field-value-readonly">
                            <?php echo $adresse; ?>
                        </div>
                </div>
                <div class="bloc-field-form">
                    <div class='bloc-field-inline'>
                        <label class="field-label">Ville : </label>
                        <div class="field-value-readonly">
                            <?php echo $ville; ?>
                        </div>
                    </div>
                    <div class='bloc-field-inline'>
                        <label class="field-label" >Code postal : </label>
                        <div class="field-value-readonly">
                            <?php echo $cpo; ?>
                        </div>
                    </div>
                </div>
                <div class="bloc-field-form">
                        <label class="field-label">Adresse e-mail : </label>
                        <div class="field-value-readonly">
                            <?php echo $mail; ?>
                        </div>
                </div>
                <div class="bloc-buttons-espacepe">
                    <a href="/pe/espace-pe/profil.php?part=modif">Modifier</a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    
</section>
