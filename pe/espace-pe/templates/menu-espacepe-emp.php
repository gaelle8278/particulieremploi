<?php

/**
 *Menu espace perso employeur
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

?>
<nav class="menu-espacepe menu-emp">
    <div class="content-central-column">
        <ul>
            <li class='menu-res-title'></li>
            <li class="menu-item large-item <?php if($pageActive=="compte") { echo "active-item"; } ?>"><a href="/pe/espace-pe/compte.php">Mon tableau de bord</a></li>
            <li class="menu-item small-item <?php if($pageActive=="messagerie") { echo "active-item"; } ?>"><a href="/pe/espace-pe/messagerie/accueil.php">Ma messagerie</a></li>
            <li class="menu-item large-item <?php if($pageActive=="annonces") { echo "active-item"; } ?>"><a href="/pe/espace-pe/annonces.php">Mes offres d'emploi</a></li>
            <li class="menu-item x-large-item <?php if($pageActive=="favoris") { echo "active-item"; } ?>"><a href="/pe/espace-pe/favoris.php">Candidatures séléctionnées</a></li>
            <li class="menu-item large-item <?php if($pageActive=="recherche") { echo "active-item"; } ?>"><a href="/pe/espace-pe/recherche.php">Recherche de salarié</a></li>
            <li class="menu-item small-item <?php if($pageActive=="profil") { echo "active-item"; } ?>"><a href="/pe/espace-pe/profil.php">Mon profil</a></li>
            <li class="menu-res-icon">
                <span id="menu-res"></span>
            </li>
        </ul>
    </div>
</nav>