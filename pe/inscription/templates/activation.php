<?php
/* 
 * Affichage du message après activation du compte via le lien envoyé par email
 */
?>
<div class="content-central-column">
    <section>
        <div class="bloc-content">
            <h1>Activation de vote compte</h1>
            </div>
        <div class='bloc-content-effect'></div>

        <div class="bloc-content">
            <?php
            if(!empty($tabDisplayError)) {
                foreach($tabDisplayError as $key => $msg) {
                    ?>
                    <p><?php echo $msg; ?></p>
                    <?php
                }
            } else {
                ?>
                <p>Votre compte est désormais actif.<br>
                    Pour vous connecter à votre espace de mise en relation, veuillez renseigner ci-après l'adresse e-mail
                    et mot de passe renseignés lors de votre inscription.
                </p>
                <?php
                include_once(dirname(dirname(dirname(__FILE__))).'/espace-pe/templates/form-connexion.php');
            }
            ?>
        </div>
    </section><!--@whitespace
    --><aside>
        <?php
         include_once('sidebar-inscription.php');
        ?>
    </aside>
</div>

