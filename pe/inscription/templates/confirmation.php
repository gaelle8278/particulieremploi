<?php
/**
 * Affichage du message de prise en compte de l'inscription
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
            <h1>Confirmation de votre inscription</h1>
            </div>
        <div class='bloc-content-effect'></div>

        <div class="bloc-content">
            <p>Nous avons bien enregistré votre demande d'inscription. <br>
                Un e-mail de validation vous a été envoyé à l’adresse e-mail que vous avez renseignée. <br>
                Pour confirmer votre inscription, vous devez cliquer sur le lien contenu dans cet e-mail.
            </p>
        </div>
    </section><!--@whitespace
    --><aside>
        <?php
         include_once('sidebar-inscription.php');
        ?>
    </aside>
</div>

