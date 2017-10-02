<?php

/**
 * Code la popup de connexion à l'espace de mise en relation
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
?>
<div class="modal blur-effect" id="popup">
    <div class="popup-content">
        <div class="popup-title">Accès à mon espace de mise en relation</div>
        <div class="page-column-demi page-column-highlight">
            <p class="section-title">Se connecter à mon compte</p>
            <div class="title-separator"></div>
            <form action="/pe/espace-pe/login.php" method="post">
                <div class="bloc-field-form">
                    <label class="field-label" for="form-email">Adresse e-mail <span class="field-required">*</span></label>
                    <div class="field-value">
                        <input type="text" placeholder="" name="email" id="form-email" class="input-style" size="50" />
                    </div>
                </div>
                <div class="bloc-field-form">
                    <label class="field-label" for="form-mdp">Mot de passe</label>
                    <div class="field-value">
                        <input type="password" placeholder="" name="password" id="form-mdp" class="input-style" size="20" />
                        <a href="/pe/espace-pe/motdepasse.php" class="content-link text-smaller">Mot de passe oublié ?</a>
                    </div>
                </div>
                <div class="bloc-submit-form">
                    <input type="submit" value="Se connecter">
                </div>
            </form>
            
        </div><!-- @whitespace
        --><div class="page-column-demi">
            <p class="section-title">Créer un compte</p>
            <div class="title-separator"></div>
            <ul class="content-list">
                <li>Un service de mise en relation de l'emploi à domicile entre particuliers 100% gratuit</li>
                <li>L'accès à des annonces au plus près de chez vous</li>
                <li>Un espace de mise en relation avec une messagerie sécurisée</li>
            </ul>
            <div class="compte-buttons">
                <a href="/pe/inscription/compte.php?type=sal" class="button-ins-sal">S'inscrire comme salarié</a>
                <a href="/pe/inscription/compte.php?type=emp" class="button-ins-emp">S'inscrire comme employeur</a>
            </div>
        </div>
        <div class="close"></div>
    </div>
</div>