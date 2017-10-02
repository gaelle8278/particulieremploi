<?php

/**
 * Affichage du formulaire de récupération du mot de passe
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

?>
<section>
    <div class="content-central-column">
        <p class="section-title">Récupération du mot de passe</p>
            <div class="title-separator"></div>
            <?php
            if (isset($message)) {
                echo "<p>" . $message . "</p>";
                ?>
                <a class="common-button" href="/pe/espace-pe/connexion.php" title="page de connexion"> Connectez-vous</a>
                <?php
            } else {
                ?>
                <form id="mdpform" action="/pe/espace-pe/motdepasse.php" method="post">
                    <div class="bloc-field-form">
                        <label class="field-label" for="form-email">Adresse e-mail associée à votre compte</label>
                        <div class="field-req field-value">
                            <input type="text" placeholder="" name="email" id="form-email" class="input-style" size="50" />
                            <?php
                            if(isset($params['erreurEmail'])) {
                                echo "<p  class='error-input'>".$params['erreurEmail']."</p>";
                            }
                            ?>
                        </div>
                        <div class="msg-error-valid"></div>
                    </div>
                    <div class="bloc-field-form">
                        <label class="field-label" for="form-cpo">Votre code postal</label>
                        <div class="field-req field-value">
                            <input type="text" placeholder="" name="codepostal" id="form-cpo" class="input-style" size="50" />
                            <?php
                            if(isset($params['erreurCodePostal'])) {
                                echo "<p  class='error-input'>".$params['erreurCodePostal']."</p>";
                            }
                            ?>
                        </div>
                        <div class="msg-error-valid"></div>
                    </div>
                    <div class="bloc-submit-form">
                        <input type="submit" value="Envoyer" name="envoyer">
                    </div>
                </form>
                <?php
            }
            ?>
    </div>
</section>