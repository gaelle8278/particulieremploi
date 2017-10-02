<?php

/**
 * Barre latérale de l'inscription pe
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

//ce widget ne s'affiche pas si on est dans l'espace perso
if(!isset($_SESSION['utilisateur_id'])) {
    
    ?>
    <div class="sidebar-widget-article">
        <div>
            <div class='sidebar-title'>Les avantages de s'inscrire au service Particulier emploi</div>
            <div class='title-separator'></div>
            <?php
            if($type_compte=="SAL") {
                ?>
                <ul>
                    <li><span class="text-bold">Un service de mise en relation avec des employeurs 100% gratuit</li>
                    <li>L'accès a des offres d'emploi au plus près de chez vous</li>
                    <li>Un espace de gestion de vos annonces pour un suivi avancé</li>
                </ul>
                <?php
            } else {
                ?>
                <ul>
                    <li><span class="text-bold">Un service de mise en relation avec des salariés 100% gratuit</li>
                    <li>L'accès a des profils de salariés au plus près de chez vous</li>
                    <li>Un espace de gestion de vos offres pour un suivi avancé</li>
                </ul>
                <?php
            }
            ?>
        </div>

    </div>
<?php
}
?>
<div class="sidebar-widget-article">
    <div>
        <div class='sidebar-title'>La nouvelle classification de l'emploi des salariés du particulier employeur</div>
        <div class='title-separator'></div>
        <p><span class="text-bold">Une nouvelle classification en vigueur depuis le 1er mai 2015.</span><br />
        Vous êtes déjà employeur ou allez le devenir, la branche des salariés du
        particulier employeur vous invite à classer l'emploi du salarié en 3 étapes :
        </p>
        <ol>
            <li>sélectionner le domaine d'activités</li>
            <li>identifier l'emploi repère</li>
            <li>informer le salarié</li>
        </ol>
        <p>Pour classer l'emploi par vous-même, lancez une 
            <a href="http://simulateur-emploisalarieduparticulieremployeur.fr" alt="" target="_blank" class="text-bold">simulation</a> 
            sur le site de la branche professionnelle des salariés du particulier employeur.
        </p>
        <p>
            Si vous souhaitez <span class="text-bold">être accompagné</span> dans cette démarche par des juristes
            experts, nous vous invitons à souscrire à une <a href="" alt="" target="_blank" class="text-bold">consultation juridique de la FEPEM.</a>
        </p>
    </div>
    
</div>