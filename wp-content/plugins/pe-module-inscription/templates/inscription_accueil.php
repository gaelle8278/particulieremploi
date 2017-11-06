<?php
/* 
 * Template de la page d'accueil du module d'inscription
 */
?>
<main id="inscription-homepage">
        <div class="content-central-column">
            <div class="bloc-content">
                <?php
                if($registration == "ok") {
                    ?>
                    <p class="module-message">L'inscription est enregistrée</p>
                    <?php
                } elseif($registration == "record-nok") {
                    ?>
                    <p class="module-message">Erreur lors de l'enregistrement. Veuillez réessayer ultérieurement</p>
                    <?php
                } elseif($registration == "email-nok") {
                    ?>
                    <p class="module-message">
                        L'e-mail d'activation de compte n'a pas été envoyé.<br>
                        Veuillez cliquer sur le lien ci-dessous afin d'envoyer un autre lien d'activation à l'adresse <?php echo $registration_email; ?><br>
                        <a href='/pe/inscription/validation.php?login=<?php $registration_email; ?>&demande=1' >Envoyez un nouvel e-mail d'activation de compte</a>
                    </p>
                    <?php
                }
                ?>
                <div class="bloc-column">
                    <p class="txt-bold">Pour le salarié</p>
                    <a href="<?php echo esc_url( add_query_arg( 'type', "sal", site_url( '/inscription-module-inscription/' ) ) )?>" class="inscription-button-sal">
                        Je propose mes compétences
                    </a>
                </div><!--@whitespace
                --><div class="bloc-column">
                    <p class="txt-bold">Pour l'employeur</p>
                    <a href="<?php echo esc_url( add_query_arg( 'type', "emp", site_url( '/inscription-module-inscription/' ) ) )?>" class="inscription-button-emp">
                        Dépôt d'une offre d'emploi
                    </a>
                </div>
            </div>
        </div>
</main>

