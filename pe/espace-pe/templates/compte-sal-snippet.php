<?php

/**
 * Page d'accueil de l'espace perso salarié
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
?>
<section class="compte-hp compte-sal">
    <div class="content-central-column">
        <div class="bloc-row-espacepe">
            <div class="bloc-cell-espacepe first-bloc-cell">
               <p class="bloc-title">Ma messagerie</p>
               <?php
                //TODO requete de récupération des messages non lus de l'utilisateur
                $queryNbMails= "select count(*) from "
                        .TBL_MSG_DEST." "
                        . "where dest_mess_id_membre=".$utilisateurId." "
                        . "and dest_mess_etat_lecture=". MSG_STATE_NONLU;
               $nb_mails = $wpdb->get_var($queryNbMails);
               ?>
                <p class="text-bold"><?php echo nb_mails; ?> messages non lus dans votre boîte de récepetion</p>
                <p></p>
                <div class="bloc-cell-buttons">
                    <a href="/pe/espace-pe/messagerie/accueil.php">Boîte de réception</a>
                </div>
            </div><!-- @whitespace
            --><div class="bloc-cell-espacepe">
                <p class="bloc-title">Mes candidatures</p>
                <?php
  
                $nb_annonces = $wpdb->get_var( "SELECT COUNT(*) "
                                                . " FROM ".TBL_ANNONCES." "
                                                . " WHERE annonce_idauteur  = '".$idUtilisateur."' "
                                                . " AND annonce_etat = 'ACTIF'"
                                            );
                ?>
                <p class="text-bold">
                    <?php  
                    if(empty($nb_annonces) || $nb_annonces===0) {
                        echo "Aucune candidature déposée";
                    } else {
                        echo $nb_annonces." candidature(s)";
                    }
                ?>
                </p>
                <p>Retrouvez vos candidatures ou déposer de nouvelles candidatures pour
                    multiplier vos chances de trouver un emploi</p>
                <div class="bloc-cell-buttons">
                    <a href="/pe/inscription/emploi.php">Déposer une candidature</a>
                    <a href="/pe/espace-pe/annonces.php">Voir mes candidatures</a>
                </div>
            </div>
        </div>
        <div class="bloc-row-espacepe">
            <div class="bloc-cell-espacepe first-bloc-cell">
                <p class="bloc-title">Mes offres sélectionnées</p>
                <?php
                $nb_favoris = $wpdb->get_var( "SELECT COUNT(*) "
                                                . " FROM ".TBL_FAVORIS." "
                                                . " WHERE maselection_utilisateurid = '".$idUtilisateur."' "
                                            );
                ?>
                <p class="text-bold">
                    <?php 
                    if(empty($nb_favoris) || $nb_favoris===0) {
                        echo "Aucune offre sélectionnée";
                    } else {
                        echo $nb_favoris. " offres sélectionnées";
                    }
                    ?> 
                </p>
                <p>Consultez les offres que vous avez sélectionnées pour un suivi facilité</p>
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
            <!--<div class="bloc-cell-espacepe bloc-cell-search">
                <p class="bloc-title">Je recherche un emploi à domicile</p>
                 <form action="/pe/espacepe/recherche.php" method="post" enctype="multipart/form-data">
                    <div class="bloc-field-form">
                        <label class="field-label" for="metierSal">Métiers</label>
                        <div class="field-value">
                            <div class="select-style">
                                <select name="metier" id="metierSal" >
                                    <option value="0">S&eacute;lectionner </option>
                                    <?php
                                    //TODO récupérer les métiers
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bloc-field-form bloc-field-inline">
                        <label class="field-label" for="codepSal">Localisation</label>
                        <div class="field-value">
                            <input type="text" class="input-style" id="codepSal" name="codep" class=""  placeholder="Code Postal" >
                        </div>
                    </div>
                    <div class="bloc-field-form bloc-field-inline">
                        <label class="field-label" for="distanceSal">Etendre ma recherche</label>
                        <div class="field-value">
                            <div class="select-style">
                                <select name="distance" id="distanceSal" >
                                   <?php
                                   //TODO récupérer les distances
                                   ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bloc-field-inline bloc-submit-inline">
                        <input type="submit" value="Rechercher"  class="" id="form-search-emp" />
                    </div>
                 </form>
            </div>-->
        </div>
    </div>
</section>