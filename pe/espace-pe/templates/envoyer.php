<?php

/**
 * Affichage de la page de rédaction d'un message
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
                <?php
                if($nbMsg > 10) {
                    ?>
                    <div class="messagerie-title">
                        <p class="alert-msg"> Vous avez envoyé <?php echo $nbMsg; ?> messages aujourd'hui. Le quota maximum de 10 messages a été dépassé. </p>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="messagerie-title">  
                        <p class="title-redac">Nouveau message</p>
                    </div>
                    <div class="messagerie-content">
                        <form id="envoyermsg" action="/pe/espace-pe/messagerie/envoyer.php" method="post" >
                            <div class="bloc-field-form">
                                 <label for="id_dest_msg" class="field-label-inline" >A :</label>
                            <?php
                            if(!empty($params['id_dest_msg'])) {
                                ?>
                                <div class="field-req field-value-inline">
                                    <input type="hidden" value="<?php echo $params['id_dest_msg']; ?>" name="id_dest_msg"  id="id_dest_msg" />
                                    <?php echo $params['name_dest_msg']; ?>
                                    <div class="msg-error-valid"></div> 
                                </div>
                            <?php
                            } else {
                                ?>
                                <!--<div class="field-req field-value-inline">
                                    <div class="select-style">
                                        <select name="id_dest_msg" id="id_dest_msg_select"> </select>
                                    </div>
                                    <div class="msg-error-valid"></div> 
                                </div>-->
                                <?php 
                                if ($_SESSION['utilisateur_groupe']=="EMP") {
                                    $title="Rechercher des profils de salariés";
                                } else {
                                    $title="Rechercher des offres"; 
                                }
                                ?>
                                <a class="btn-search" href="/pe/espace-pe/recherche.php" title="<?php echo $title; ?>">
                                    <?php echo $title; ?>
                                </a>
                                <?php
                            }
                            ?>
                            </div>
                            <div class="bloc-field-form">
                                <label class="field-label-inline" for="objetmessage">Objet :</label>
                                <div class="field-req field-value-inline">
                                    <input type="text" name="objetmessage" id="objetmessage" class="input-style"  />
                                    <div class="msg-error-valid"></div> 
                                </div>

                            </div>
                            <div class="bloc-field-form">
                                <label class="field-label-inline" for="contenumsg">Message : </label>
                                <div class="field-req field-value-inline">
                                    <textarea name="contenumsg" id="contenumsg" rows="15" cols=""></textarea> 
                                    <div class="msg-error-valid"></div>
                                </div>

                            </div>
                             <div class="bloc-submit-form">
                                 <a href="/pe/espace-pe/messagerie/accueil.php" title="retour accueil messagerie">Retour</a>
                                 <input type="submit" name="envoyer" value="Envoyer" id="button-send-msg"/>
                             </div>

                        </form>

                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>