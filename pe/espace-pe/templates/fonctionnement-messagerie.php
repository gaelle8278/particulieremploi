<?php

/**
 * Affichage de la page de fonctionnement de la messagerie
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
?>

<section class="messagerie <?php echo $_SESSION['utilisateur_groupe'] == 'SAL'?"messagerie-sal":"messagerie-emp"; ?>">
    <div class="content-central-column">
        <div class="bloc-content">
            <div class="bloc-nav">
                <?php
                include_once('nav-messagerie.php');
                ?>
            </div><!-- @whitespace
            --><div class="bloc-messagerie">
                <div class="messagerie-title">
                    <?php
                    if($nbMsg > 10) {
                        ?>
                        <p class="alert-msg">
                            Vous avez envoyé <?php echo $nbMsg; ?> messages aujourd'hui. Le quota maximum de 10 messages a été dépassé.
                        </p>
                        <?php
                    } else {
                        ?>
                        <a href="/pe/espace-pe/messagerie/envoyer.php" title="écrire un message">
                            Nouveau message
                        </a>
                        <?php
                    }
                    ?>
                </div>
                <div class="messagerie-content">
                    <?php
                    if($page==2) {
                        if($_SESSION['utilisateur_groupe'] == 'SAL') {
                            include_once(dirname(__FILE__).'/messagerie-conseils-salaries.php');
                        } else {
                            include_once(dirname(__FILE__).'/messagerie-conseils-employeurs.php');
                        }
                        ?>
                        <a class="page-link page-link-prev" href='/pe/espace-pe/messagerie/fonctionnement-messagerie.php' >
                            < Fonctionnement messagerie
                        </a>
                        <?php
                    } else {
                        ?>
                        <p class="text-bold">Texte d'aide sur les boutons d'action</p>
                        <p>Archiver=</P>
                        <p>Supprimer=</p>
                        <p>Bloquer = Vous ne recevrez plus de messages de cet expéditeur lequel est ajouté à la boite Expéditeurs bloqués.
                            Le message reçu est supprimé.</p>
                        <p>Indésirable =  Le message de l'expéditeur est envoyé à l'administrateur pour modération
                            et placé dans Messages indésirables. Les futurs messages de cet expéditeur seront automatiquement mis en spam
                        </p>
                        <a class="page-link page-link-next" href='/pe/espace-pe/messagerie/fonctionnement-messagerie.php?page=2' >
                            Conseils sur l'utilisation de la messagerie >
                        </a>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
