<div id="plugin-cp">
    <div class="wrapper">
        <?php
        if (isset($popupOnload) && $popupOnload == 1) {
            ?>
            <img src="<?php echo get_template_directory_uri() ?>/images/logo.png" alt="logo de particulier emploi"/>
            <p class="title">
            Bienvenue sur Particulier emploi, le site de l'emploi à domicile entre particuliers
            </p>
            <p>Nous vous proposons des services en rapport avec votre localisation (actualités, recherche d'emploi, de salariés etc ...)</p>
            <p>Pour pouvoir bénéficier de ce service, nous vous invitons à renseigner votre code postal dans le champ ci-après : </p>
            <?php
        } else {
            ?>
            <div class="sticky" id="sticky">Saisir votre code postal</div>
            <p>
                Pour accéder à toutes les informations de la région de votre choix, nous vous invitons à renseigner le code postal dans le champ ci-après :
            </p>
            <p class="notice">Vous pouvez à tout moment modifier manuellement votre région</p>
            <?php
        }
        ?>
        
        <div id="cp-form">
            <form method="POST" id="form-user-cp">
                <?php wp_nonce_field('choix-cp', 'cp-verif'); ?>
                <div>
                    <label for="code-postal">Saisir votre code postal <span>(ex: 92100)</span></label>
                    <input type="text" name="code_postal" id="code-postal" class="input-style"
                           value="<?php echo (isset($depCode) && !empty($depCode)) ? $depCode : ""; ?>"/>
                    
                    <input type="submit" name="cp-user-choice" value="Valider" class="plugin-cp-submit"/>
                    <div class="msg-error-valid"></div>
                </div>
            </form>
            <?php
            if (isset($popupOnload) && $popupOnload == 1) {
                ?>
                <div>
                    <button type="button" id="cp-button-close">Je ne souhaite pas bénéficier de ce service</button>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

