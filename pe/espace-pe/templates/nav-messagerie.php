<?php

/**
 * Navigation de la messagerie interne
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

?>


<div class="messagerie-title">
    Ma messagerie
</div>
<ul class="nav-messagerie">
    <li id="link-msg-accueil" class="<?php echo $subPageActive=="reception"?"nav-active":"";?>">
        <a href="/pe/espace-pe/messagerie/accueil.php" title="messagerie réception">
            Boite de réception
        </a>
    </li>
    <li id="link-msg-env" class="<?php echo $subPageActive=="envoye"?"nav-active":"";?>">
        <a href="/pe/espace-pe/messagerie/accueil.php?type_message=<?php echo STATE_BDD_ENV; ?>" title="messagerie, messages envoyés">
            Messages envoyés
        </a>
    </li>
        <ul class="<?php echo $subPageActive=="envoye"?"sub-nav-active":"sub-nav-inactive";?>">
            <li>
                <a href="/pe/espace-pe/messagerie/accueil.php?type_message=<?php echo STATE_BDD_ENV; ?>&sous_type_msg=<?php echo STATE_BDD_ARCH; ?>" title="messagerie, messages envoyés archivés">
                    Messages archivés
                </a>
            </li>
            <li>
                <a href="/pe/espace-pe/messagerie/accueil.php?type_message=<?php echo STATE_BDD_ENV; ?>&sous_type_msg=<?php echo STATE_BDD_SUPPR; ?>" title="messagerie, messages envoyés supprimés">
                    Messages supprimés
                </a>
            </li>
        </ul>
    <li id="link-msg-arch" class="<?php echo $subPageActive=="archive"?"nav-active":"";?>">
        <a href="/pe/espace-pe/messagerie/accueil.php?type_message=<?php echo STATE_BDD_ARCH; ?>" title="messagerie, messages archivés">
            Messages archivés</a>
    </li>
    <li id="link-msg-suppr" class="<?php echo $subPageActive=="supprime"?"nav-active":"";?>">
        <a href="/pe/espace-pe/messagerie/accueil.php?type_message=<?php echo STATE_BDD_SUPPR; ?>" title="messagerie, messages supprimés">
            Messages supprimés
        </a>
    </li>
    <li id="link-msg-spam" class="<?php echo $subPageActive=="spam"?"nav-active":"";?>">
        <a href="/pe/espace-pe/messagerie/accueil.php?type_message=<?php echo STATE_BDD_SPAM; ?>" title="messagerie, messages mis en spam">
            Messages indésirables</a>
    </li>
    <li id="link-user-blocked" class="<?php echo $subPageActive=="user-blocked"?"nav-active":"";?>">
        <a href="/pe/espace-pe/messagerie/accueil.php?type_message=<?php echo STATE_USER_BLOQUE; ?>"
           title="messagerie, utilisateurs bloqués">
            Expéditeurs bloqués</a>
    </li>
    <li id="link-msg-fonc" class="<?php echo $subPageActive=="fmessagerie"?"nav-active":"";?>">
        <a href="/pe/espace-pe/messagerie/fonctionnement-messagerie.php"
           title="messagerie, fonctionnement">
            Fonctionnement messagerie</a>
    </li>
        <ul class="<?php echo $subPageActive=="fmessagerie"?"sub-nav-active":"sub-nav-inactive";?>">
            <li>
                <a href="/pe/espace-pe/messagerie/fonctionnement-messagerie.php?page=2"
                   title="messagerie, conseils sur l'utilisation de la messagerie">
                    Conseils utilisation messagerie
                </a>
            </li>
        </ul>
    
</ul>
