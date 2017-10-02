<?php

/**
 * Affichage module de la messagerie
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

        //echo "<pre>";print_r($queryRecupMsg); echo "</pre>";
        //echo $nombreDePages;
        //echo "<pre>";print_r($tabMsg); echo "</pre>";
        
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
                    if( $messageEnv==1 ) {
                        ?>
                        <p class="message">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/pictos/picto-msg-envoye-confirmation.png" />Message envoyé
                        </p>
                        <?php
                    }
                    
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
                <div class="messagerie-content">
                    <form action ="/pe/espace-pe/messagerie/traitement_statut.php" method="post">
                        <input type="hidden" name="type_message" value="<?php echo !empty($params['type_message'])?$params['type_message']:""; ?>" />
                        <input type="hidden" name="sous_type_msg" value="<?php echo !empty($params['sous_type_msg'])?$params['sous_type_msg']:""; ?>" />
                        <div class="toolbar">
                            <div class="buttons">
                                <?php
                                //boutons dépendent du type de messages
                                // le nom des boutons sert à déterminer l'action 
                                // qui sera exécutée après soumission du formulaire
                                if($params['type_message']==STATE_BDD_ENV ) {
                                    if(empty($params['sous_type_msg'])) {
                                        ?>
                                        <input type="submit" value="Archiver" name="archiver">
                                        <input type="submit" value="Supprimer" name="supprimer">
                                        <?php 
                                    } elseif($params['sous_type_msg']==STATE_BDD_ARCH) {
                                        ?>
                                        <input type="submit" value="Supprimer" name="supprimer">
                                        <?php
                                    } elseif($params['sous_type_msg']==STATE_BDD_SUPPR) {
                                        ?>
                                        <input type="submit" value="Supprimer définitivement" name="suppr-def">
                                        <?php
                                    }
                                } elseif ($params['type_message']==STATE_BDD_RECU || empty($params['type_message'])) {
                                    ?>
                                    <input type="submit" value="Archiver" name="archiver">
                                    <input type="submit" value="Supprimer" name="supprimer">
                                   <?php 
                                } elseif ($params['type_message']==STATE_BDD_ARCH) {
                                    ?>
                                    <input type="submit" value="Supprimer" name="supprimer">  
                                    <?php
                                } elseif ($params['type_message']==STATE_BDD_SUPPR) {
                                    ?>
                                    <input type="submit" value="Supprimer définitivement" name="suppr-def">
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="pagination">
                                <?php
                                if(!empty($params['type_message'])) {
                                    $paramsPagination = "&type_message=".$params['type_message'];
                                }
                                if(!empty($params['sous_type_msg'])) {
                                    $paramsPagination .="&sous_type_msg=".$params['sous_type_msg'];
                                }
                                if ($page > 1) {
                                    ?>
                                    <a href="?page=<?php echo ($page - 1).$paramsPagination; ?>">< Messsages précédents</a>
                                    <?php
                                }
                                if ($page < $nombreDePages) {
                                    ?>
                                    <a href="?page=<?php echo ($page + 1).$paramsPagination; ?>">Messages suivants ></a>
                                    <?php
                                }
                                ?>   
                            </div>
                        </div>
                   
                        <?php
                        //affichage des messages
                        foreach ($tabMsg as $msg) {
                            if(isset($msg['etat']) && $msg['etat']==MSG_STATE_NONLU) {
                                $class="text-bold";
                            } else {
                                $class="";
                            }
                            ?>
                            <a href="/pe/espace-pe/messagerie/lire.php?idmsg=<?php echo $msg['id']; ?>&type_message=<?php echo $params['type_message'];?>&sous_type_msg=<?php echo $params['sous_type_msg'];?>" class="bloc-msg <?php echo $class; ?>">
                                <p class="msg-name">
                                    <input id='msg<?php echo $msg['id'];?>' name='listmsg[]' type='checkbox' value="<?php echo $msg['id']; ?>"/>   
                                    <label for='msg<?php echo $msg['id'];?>'>
                                        <?php 
                                        if(!empty($msg['prenom_exp'])) {
                                            echo "".ucfirst(strtolower($msg['prenom_exp']))." ".ucfirst(strtolower($msg['nom_exp'])); 
                                        } elseif (!empty($msg['prenom_dest'])) {
                                             echo "&#8594; ".ucfirst(strtolower($msg['prenom_dest']))." ".ucfirst(strtolower($msg['nom_dest'])); 
                                        }
                                        ?>
                                    </label>
                                </p>
                                <span class="msg-date"><?php echo ucfirst(recup_date_msg($msg['date_envoi'])); ?></span>
                                <p><?php echo $msg['objet']; ?></p>
                                <p class="msg-corps"><?php echo substr($msg['contenu'],0,50); ?></p>
                            </a>
                            <?php
                        }
                        ?>
                         
                         <div class="toolbar">
                            <div class="buttons">
                                <?php
                                //boutons dépendent du type de messages
                                // le nom des boutons sert à déterminer l'action 
                                // qui sera exécutée après soumission du formulaire
                                if($params['type_message']==STATE_BDD_ENV ) {
                                    if(empty($params['sous_type_msg'])) {
                                        ?>
                                        <input type="submit" value="Archiver" name="archiver">
                                        <input type="submit" value="Supprimer" name="supprimer">
                                        <?php 
                                    } elseif($params['sous_type_msg']==STATE_BDD_ARCH) {
                                        ?>
                                        <input type="submit" value="Supprimer" name="supprimer">
                                        <?php
                                    } elseif($params['sous_type_msg']==STATE_BDD_SUPPR) {
                                        ?>
                                        <input type="submit" value="Supprimer définitivement" name="supprdef">
                                        <?php
                                    }
                                } elseif ($params['type_message']==STATE_BDD_RECU || empty($params['type_message'])) {
                                    ?>
                                    <input type="submit" value="Archiver" name="archiver">
                                    <input type="submit" value="Supprimer" name="supprimer">
                                   <?php 
                                } elseif ($params['type_message']==STATE_BDD_ARCH) {
                                    ?>
                                    <input type="submit" value="Supprimer" name="supprimer">  
                                    <?php
                                } elseif ($params['type_message']==STATE_BDD_SUPPR) {
                                    ?>
                                    <input type="submit" value="Supprimer définitivement" name="supprdef">
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="pagination">
                                <?php
                                if ($page > 1) {
                                    ?>
                                    <a href="?page=<?php echo $page - 1; ?>">< Messsages précédents</a>
                                    <?php
                                }
                                if ($page < $nombreDePages) {
                                    ?>
                                    <a href="?page=<?php echo $page + 1; ?>">Messages suivants ></a>
                                    <?php
                                }
                                ?>   
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

