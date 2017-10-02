<?php

/**
 * Page d'accueil de l'espace perso employeur
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
?>
<section class="compte-hp <?php echo $type_compte=="SAL" ? "compte-sal":"compte-emp"; ?>">
    <div class="content-central-column">
        <div class="bloc-row-espacepe">
            <div class="bloc-cell-espacepe first-bloc-cell">
                <p class="bloc-title">Messagerie</p>
                <?php
                $queryNbMails= "select count(*) from "
                        . TBL_MSG_DEST." "
                        . "where dest_mess_id_membre=".$idUtilisateur." "
                        . "and dest_mess_etat_lecture='".MSG_STATE_NONLU."' "
                        . "and dest_mess_etat_gestion='".STATE_BDD_RECU."'";
                //echo "<pre>";print_r($queryNbMails);echo "</pre>";
                $nb_mails = $wpdb->get_var($queryNbMails);
                ?>
                <p class="text-bold">
                    <?php 
                    if ($nb_mails==0) {
                        echo "Aucun nouveau message dans votre boîte de réception.";
                    } else {
                        echo $nb_mails." message(s) non lu(s) dans votre boîte de récepetion";; 
                    }
                    ?> 
                </p>
                <p></p>
                <div class="bloc-cell-buttons">
                    <a href="/pe/espace-pe/messagerie/accueil.php">Accès à ma messagerie</a>
                </div>
            </div><!-- @whitespace
            --><div class="bloc-cell-espacepe">
                <p class="bloc-title">
                    <?php
                    if($_SESSION['utilisateur_groupe']=="SAL") {
                        echo "Mes candidatures";
                    } else {
                        echo "Mes offres d'emploi";
                    }
                    ?>
                </p>
                <?php
                $nb_annonces = $wpdb->get_var( "SELECT COUNT(*) "
                                                . " FROM ".TBL_ANNONCES." "
                                                . " WHERE annonce_idauteur  = '".$idUtilisateur."' "
                                                . " AND annonce_etat = 'ACTIF'"
                                            );
                ?>
                <p class="text-bold">
                    <?php  
                    if(empty($nb_annonces)) {
                        if($_SESSION['utilisateur_groupe']=="SAL") {
                            echo "Aucune candidature déposée";
                        } else {
                            echo "Aucune offre d'emploi déposée";
                        }
                    } else {
                        if($_SESSION['utilisateur_groupe']=="SAL") {
                            echo $nb_annonces." candidature(s)";
                        } else {
                            echo $nb_annonces." offre(s) d'emploi";
                        }
                    }
                ?>
                </p>
                <p>
                    <?php
                        if($type_compte == "SAL") {
                            echo "Retrouvez vos candidatures ou déposer de nouvelles candidatures pour
                            multiplier vos chances de trouver un emploi";
                        } else {
                                echo "Retrouvez vos offres d'emploi ou déposer de nouvelles offres pour
                            multiplier vos chances de trouver un salarié";
                          
                        }
                        ?>
                    </p>
                <div class="bloc-cell-buttons">
                    <a href="/pe/inscription/emploi.php">
                        <?php
                        if($type_compte == "SAL") {
                            echo "Déposer une candidature";
                        } else {
                            echo "Déposer une offre";
                        }
                        ?>
                    </a>
                    <a href="/pe/espace-pe/annonces.php">
                        <?php
                        if($type_compte == "SAL") {
                            echo "Voir mes candidatures";
                        } else {
                           echo "Voir mes offres";
                        }
                        ?>
                    </a>
                </div>
            </div>
        </div>
        <div class="bloc-row-espacepe">
            <div class="bloc-cell-espacepe first-bloc-cell">
                <p class="bloc-title">
                    <?php
                    if($type_compte == "SAL") {
                        echo "Mes offres d'emploi sélectionnées";
                    } else {
                        echo "Mes candidatures sélectionnées";
                    }
                    ?>
                </p>
                <?php
                $nb_favoris = $wpdb->get_var( "SELECT COUNT(*) "
                                                . " FROM ".TBL_FAVORIS." "
                                                . " WHERE maselection_utilisateurid = '".$idUtilisateur."' "
                                            );
                ?>
                <p class="text-bold">
                    <?php 
                    if(empty($nb_favoris) || $nb_favoris===0) {
                        if($type_compte == "SAL") {
                            echo "Aucune offre d'emploi sélectionnée";
                        } else {
                            echo "Aucune candidature sélectionnée";
                        }
                    } else {
                        if($type_compte == "SAL") {
                            echo $nb_favoris. " offre(s) d'emploi sélectionnée(s)";
                        } else {
                            echo $nb_favoris. " candidature(s) sélectionnée(s)";
                        }
                    }
                    ?> 
                </p>
                <p>
                    <?php
                    if($type_compte == "EMP") {
                        echo "Consultez les candidatures que vous avez 
                            sélectionnées pour un suivi facilité";
                    } else {
                        echo "Consultez les offres que vous avez "
                         . "sélectionnées pour un suivi facilité";
                    }
                    ?>
                </p>
                <div class="bloc-cell-buttons">
                    <a href="/pe/espace-pe/favoris.php">Voir ma sélection</a>
                </div>
            </div><!-- @whitespace
            --><div class="bloc-cell-espacepe">
                <p class="bloc-title">Mon profil</p>
                <?php
                $infos_user = $wpdb->get_row("select "
                        . "utilisateur_nom, "
                        . "utilisateur_prenom, "
                        . "utilisateur_civilite, "
                        . "utilisateur_codepostal, "
                        . "utilisateur_ville, "
                        . "utilisateur_adresse "
                        . "from ".TBL_UTILISATEURS." "
                        . "where utilisateur_id=".$idUtilisateur);
                ?>
                <p>
                    <?php 
                    echo get_civilite($infos_user->utilisateur_civilite)."  ".ucfirst($infos_user->utilisateur_prenom)." ".ucfirst($infos_user->utilisateur_nom);
                    ?><br/>
                    <span class="text-bold">Adresse : </span><?php echo $infos_user->utilisateur_adresse; ?><br />
                    <span class="text-bold">Code postal : </span><?php echo $infos_user->utilisateur_codepostal; ?><br />
                    <span class="text-bold">Ville : </span><?php echo $infos_user->utilisateur_ville; ?>
                </p>
                <div class="bloc-cell-buttons">
                    <a href="/pe/espace-pe/profil.php">Voir/Modifier mon profil</a>
                </div>
            </div>
        </div>
    </div>
          
</section>