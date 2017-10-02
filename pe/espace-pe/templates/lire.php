<?php

/**
 * Affichage de la page de lecture d'un message
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
                        <p class="alert-msg"> Vous avez envoyé <?php echo $nbMsg; ?> messages aujourd'hui. Le quota maximum de 10 messages a été dépassé. </p>
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
                <div class="bloc-msg">
                    <p class="msg-name">
                        <?php
                        if (!empty($msg['prenom_exp'])) {
                            echo "" . ucfirst(strtolower($msg['prenom_exp'])) . " " . ucfirst(strtolower($msg['nom_exp']));
                        } elseif (!empty($msg['prenom_dest'])) {
                            echo "&#8594; " . ucfirst(strtolower($msg['prenom_dest'])) . " " . ucfirst(strtolower($msg['nom_dest']));
                        }
                        ?>
                    </p>
                    <span class="msg-date"><?php echo ucfirst(recup_date_msg($msg['date_envoi'])); ?></span>
                    <p><?php echo $msg['objet']; ?></p>
                    <p class="msg-corps"><?php echo $msg['contenu']; ?></p>
                </div>
                
                <div class="bloc-msg-button">
                     <a href="/pe/espace-pe/messagerie/accueil.php?type_message=<?php echo $params['type_message']; ?>&sous_type_msg=<?php echo $params['sous_type_msg'];?>" title="retour">Retour</a>
                    <?php
                    //si ce n'est pas un message envoyé possibilité de répondre et que le quota n'est pas dépassé
                    if($params['type_message'] != STATE_BDD_ENV && $nbMsg <= 10 ) {
                        ?>
                        <input type="button" value="repondre" id="resp-button" />
                        <?php
                    }
                    ?>
                </div>
                
                <?php
                //si ce n'est pas un message envoyé formulaire de réponse et que le quota n'est pas dépassé
                if($params['type_message'] != STATE_BDD_ENV && $nbMsg <= 10) {
                    ?>
                    <form id="envoyermsg" class="hidden-form" action="/pe/espace-pe/messagerie/envoyer.php" method="post" >
                        <input type="hidden" value="<?php echo $msg['id_exp']; ?>" name="id_dest_msg"  id="id_dest_msg" />
                        <div class="bloc-field-form">
                            <label class="field-label-inline" for="objetmessage">Objet :</label>
                            <div class="field-req field-value-inline">
                                <input type="text" name="objetmessage" id="objetmessage" class="input-style"  value="Re : <?php echo $msg['objet']; ?>"/>
                                <div class="msg-error-valid"></div> 
                            </div>
                        </div>
                        <div class="bloc-field-form">
                            <label class="field-label-inline" for="contenumsg">Message : </label>
                            <div class="field-req field-value-inline">
                                <textarea name="contenumsg" id="contenumsg" rows="15" cols=""><?php $msg['contenu']; ?></textarea> 
                                <div class="msg-error-valid"></div>
                            </div>
                            
                        </div>
                        <div class="bloc-submit-form">
                            <a href="/pe/espace-pe/messagerie/accueil.php?type_message=<?php echo $params['type_message']; ?>&sous_type_msg=<?php echo $params['sous_type_msg'];?>" title="retour">Retour</a>
                                <input type="submit" name="envoyer" value="Envoyer" id="button-send-msg"/>
                         </div>
                    </form>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>
        