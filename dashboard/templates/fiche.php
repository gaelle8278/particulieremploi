<?php
/**
 * Template de la page fiche du BO
 */
;
?>
<div class="content-central-column">
    <section>
        <?php
        if(!empty($error)) {
            ?>
            <div class="block-content-bo">
                <p><?php echo $error; ?></p>
            </div>
            <?php
        } else {
            ?>
            <div class="block-content-bo">
                <h1>
                    Fiche de <?php echo $exeInfoUser['utilisateur_civilite']." ".$exeInfoUser['utilisateur_prenom']." "
                        .$exeInfoUser['utilisateur_nom']; ?>
                </h1>
                <!-- fiche -->
                <div class="third-column light-column">
                    <div class="wrap-content">
                        <p><span class="label-fiche">Identifiant : </span><?php echo $exeInfoUser['utilisateur_id']; ?></p>
                        <p><span class="label-fiche">Civilité : </span><?php echo $exeInfoUser['utilisateur_civilite']; ?></p>
                        <p><span class="label-fiche">Nom : </span><?php echo $exeInfoUser['utilisateur_nom']; ?></p>
                        <p><span class="label-fiche">Prénom : </span><?php echo $exeInfoUser['utilisateur_prenom']; ?></p>
                        <p><span class="label-fiche">Mail : </span> <?php echo $exeInfoUser['utilisateur_mail']; ?></p>
                        <p><span class="label-fiche">Groupe : </span><?php echo $exeInfoUser['utilisateur_groupe']; ?></p>
                        <p><span class="label-fiche">Adresse : </span><?php echo $exeInfoUser['utilisateur_adresse']; ?></p>
                        <p><span class="label-fiche">Code postal : </span><?php echo $exeInfoUser['utilisateur_codepostal']; ?></p>
                        <p><span class="label-fiche">Ville : </span><?php echo $exeInfoUser['utilisateur_ville']; ?></p>
                        <p><span class="label-fiche">Téléphone : </span>
                            <?php echo empty($exeInfoUser['utilisateur_telephone'])?"NC":$exeInfoUser['utilisateur_telephone']; ?>
                        </p>
                        <p><span class="label-fiche">Date création du compte : </span><br />
                            <?php echo convert_datetime($exeInfoUser['utilisateur_datecrea']); ?></p>
                        <p><span class="label-fiche">Date de dernière connexion : </span><br />
                            <?php echo convert_datetime($exeInfoUser['utilisateur_lastconnexion']); ?></p>
                        <p><span class="label-fiche">Etat du compte : </span><?php echo $exeInfoUser['utilisateur_etat']; ?></p>
                        <div class="bloc-button">
                            <?php
                            if($exeInfoUser['utilisateur_etat'] == "Banni") {
                                $text="Activer le compte";
                                $action="activer";
                            } else {
                                $text="Bannir le compte";
                                $action="bannir";
                            }
                            ?>
                            <a href="?id=<?php echo $params['id']; ?>&action=<?php echo $action; ?>" ><?php echo $text; ?></a>
                            <a href="mailto:<?php echo $exeInfoUser['utilisateur_mail']; ?>" >Envoyer un mail</a>
                        </div>
                    </div>
                </div>
                <!-- annonces/offres -->
                <div class="col">
                    <div class="wrap-content">
                        <div class="part-title">Les annonces</div>
                        <div>
                            <?php
                            if (empty($exeInfoAnnonces)) {
                                ?>
                                <p>Aucune annonce/offre déposée</p>
                                <?php
                            } else {
                                ?>
                                <div class="table-results">
                                    <div class="table-header">
                                        <div class="t-cell-small">ID</div>
                                        <div class="t-cell-small">Etat</div>
                                        <div class="t-cell-medium">Date création</div>
                                        <div class="t-cell-xmedium">Métier</div>
                                        <div class="t-cell-xlarge">Description</div>
                                    </div>
                                    <?php
                                    foreach($exeInfoAnnonces as $infosAnnonces) {
                                        ?>
                                        <div class="table-record">
                                            <div class="table-row">
                                                <div class="t-cell-small"><?php echo $infosAnnonces['annonce_id']; ?></div>
                                                <div class="t-cell-small"><?php echo $infosAnnonces['annonce_etat']; ?></div>
                                                <div class="t-cell-medium"><?php echo convert_date($infosAnnonces['annonce_datecrea'],"/"); ?></div>
                                                <div class="t-cell-xmedium"><?php echo $infosAnnonces['annonce_titremetier']; ?></div>
                                                <div class="t-cell-xlarge">
                                                <?php
                                                echo !empty($infosAnnonces['annonce_description'])?$infosAnnonces['annonce_description']:"N.C";
                                                ?>
                                                </div>
                                            </div>
                                            <div class="table-row">
                                                <div class="text-right t-cell-full"><span class="link-more">Plus d'informations</span></div>
                                                <div class="cell-more">
                                                    <?php
                                                    echo "Adresse : ".$infosAnnonces['annonce_adresse']."<br />";
                                                    echo "Ville : ".$infosAnnonces['annonce_ville']."<br />";
                                                    echo "CP : ".$infosAnnonces['annonce_codepostal']."<br />";
                                                    echo "Taux €/h : ".$infosAnnonces['annonce_tauxhoraire']."<br />";
                                                    echo "Expérience : ".$infosAnnonces['annonce_expérience']."<br />";
                                                    echo "Date prise de fonction : "
                                                            .convert_date($infosAnnonces['annonce_dateprisefonction'], "/")."<br />";
                                                    echo "Heures/semaine :".$infosAnnonces['annonce_dureehebdomadaire']."<br />";
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                ?>
                                </div>
                            <?php
                            } 
                            ?>
                        </div>
                    </div>
                </div>
                <div class="wrap-clear"></div>
                
                <!-- infos messages -->
                <div>
                    <div class="wrap-content">
                        <div class="part-title">Les messages envoyés ce jour <?php echo date('d/m/Y'); ?></div>
                        <div>
                            <?php
                            if(empty($exeInfoMsg)) {
                                ?>
                                <p>Aucun message envoyé</p>
                                <?php
                            } else {
                                ?>
                                <div class="table-results">
                                    <div class="table-header">
                                        <div class="t-cell-large">Date d'envoi</div>
                                        <div class="t-cell-large">Objet</div>
                                        <div class="t-cell-xxlarge">Message</div>
                                        <div class="t-cell-large">Destinataire</div>
                                    </div>
                                    <?php
                                    foreach($exeInfoMsg as $infosMsg) {
                                        ?>
                                        <div class="table-record">
                                            <div class="table-row">
                                                <div class="t-cell-large"><?php echo convert_datetime($infosMsg['message_datecrea']); ?></div>
                                                <div class="t-cell-large"><?php echo $infosMsg['message_objet']; ?></div>
                                                <div class="t-cell-xxlarge"><?php echo $infosMsg['message_contenu']; ?></div>
                                                <div class="t-cell-large">
                                                    <?php
                                                        echo $infosMsg['message_dest']." - <br />".$infosMsg['utilisateur_prenom']." "
                                                            .$infosMsg['utilisateur_nom']
                                                    ?>
                                                </div>
                                            </div>

                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        
                        <!-- formulaire -->
                        <div class="part-title">Formulaire de recherche des messages envoyés</div>
                        <form action="/dashboard/fiche.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $params['id']; ?>" />
                            <div class="bloc-field-form">
                                <label class="field-label" for="mdate">Messages envoyés le </label>
                                <div class="field-value">
                                    <input type="text" name="mdate" id="mdate"
                                               value="<?php echo isset($params['mdate'])?$params['mdate']:''; ?>"
                                               class="input-style"/>
                                    <p class="text-italic">Format requis jj/mm/aaaa</p>
                                </div>
                            </div>
                            <div class="bloc-field-form">
                                <label class="field-label" for="mdestid">Messages envoyés à </label>
                                <div class="field-value">
                                    <input type="text" name="mdestid" id="mdestid"
                                               value="<?php echo isset($params['mdestid'])?$params['mdestid']:''; ?>"
                                               class="input-style"/>
                                    <p class="text-italic">
                                        Un identifiant est requis (se servir du formulaire de recherche sur la page d'accueil
                                        pour le retrouver si besoin)
                                    </p>
                                </div>
                            </div>
                            <div class="bloc-field-form">
                                <label class="field-label" for="mdatenb">Obtenir le nombre de messages envoyés par jour depuis le </label>
                                <div class="field-value">
                                    <input type="text" name="mdatenb" id="mdatenb"
                                               value="<?php echo isset($params['mdatenb'])?$params['mdatenb']:''; ?>"
                                               class="input-style"/>
                                    <p class="text-italic">Format requis jj/mm/aaaa</p>
                                </div>
                            </div>
                            <p><span class='text-bold'>NB : </span>Les critères sont exclusifs, les recherches sont indépendantes</p>
                            <div class="bloc-button">
                                <input type="submit" value="Rechercher" name="usearch"/>
                            </div>
                        </form>
                        <!-- résultats recherche -->
                        <?php 
                            //envoyés le
                        if(isset($exeInfoRechMsg)) {
                            ?>
                            <div>
                                <?php
                                if(empty($exeInfoRechMsg)) {
                                    ?>
                                    <p>Aucun message envoyé le <?php echo $params['mdate']; ?></p>
                                    <?php
                                } else {
                                    ?>
                                    <p>Messages envoyés le <?php echo $params['mdate']; ?></p>
                                    <div class="table-results">
                                        <div class="table-header">
                                            <div class="t-cell-large">Date d'envoi</div>
                                            <div class="t-cell-large">Objet</div>
                                            <div class="t-cell-xxlarge">Message</div>
                                            <div class="t-cell-large">Destinataire</div>
                                        </div>
                                        <?php
                                        foreach($exeInfoRechMsg as $infosMsg) {
                                            ?>
                                            <div class="table-record">
                                                <div class="table-row">
                                                    <div class="t-cell-large">
                                                        <?php echo convert_datetime($infosMsg['message_datecrea']); ?>
                                                    </div>
                                                    <div class="t-cell-large"><?php echo $infosMsg['message_objet']; ?></div>
                                                    <div class="t-cell-xxlarge"><?php echo $infosMsg['message_contenu']; ?></div>
                                                    <div class="t-cell-large">
                                                        <?php
                                                            echo $infosMsg['message_dest']." - <br />"
                                                                    .$infosMsg['utilisateur_prenom']." "
                                                                    .$infosMsg['utilisateur_nom']
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                            //envoyés à
                        if(isset($exeInfoRechDestMsg)) {
                            ?>
                            <div>
                                <?php
                                if(empty($exeInfoRechDestMsg)) {
                                    ?>
                                     <p>Aucun message envoyé à l'utilisateur d'identifiant <?php echo $params['mdestid']; ?></p>
                                    <?php
                                } else {
                                    ?>
                                    <p>Messages envoyés à l'utilisateur d'identifiant <?php echo $params['mdestid']; ?></p>
                                    <div class="table-results">
                                        <div class="table-header">
                                            <div class="t-cell-large">Date d'envoi</div>
                                            <div class="t-cell-large">Objet</div>
                                            <div class="t-cell-xxlarge">Message</div>
                                            <div class="t-cell-large">Destinataire</div>
                                        </div>
                                        <?php
                                        foreach($exeInfoRechDestMsg as $infosMsg) {
                                            ?>
                                            <div class="table-record">
                                                <div class="table-row">
                                                    <div class="t-cell-large">
                                                        <?php echo convert_datetime($infosMsg['message_datecrea']); ?>
                                                    </div>
                                                    <div class="t-cell-large"><?php echo $infosMsg['message_objet']; ?></div>
                                                    <div class="t-cell-xxlarge"><?php echo $infosMsg['message_contenu']; ?></div>
                                                    <div class="t-cell-large">
                                                        <?php
                                                            echo $infosMsg['message_dest']." - <br />"
                                                                    .$infosMsg['utilisateur_prenom']." "
                                                                    .$infosMsg['utilisateur_nom']
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                            //nb msg/jour
                        if(isset($exeRecupNbMsg)) {
                            ?>
                            <div>
                                <?php
                                if(empty($exeRecupNbMsg)) {
                                    ?>
                                     <p>Aucun message envoyé</p>
                                    <?php
                                } else {
                                    ?>
                                    <p>Messages envoyés par jour depuis le <?php echo$params['mdatenb']; ?></p>
                                    <div class="table-results">
                                        <div class="table-header">
                                            <div class="t-cell-xxlarge">Date d'envoi</div>
                                            <div class="t-cell-xlarge">Nombre de messages</div>
                                        </div>
                                        <?php
                                        foreach($exeRecupNbMsg as $infosNbMsg) {
                                            ?>
                                            <div class="table-record">
                                                <div class="table-row">
                                                    <div class="t-cell-xxlarge">
                                                        <?php echo convert_date($infosNbMsg['message_date'], "/"); ?>
                                                    </div>
                                                    <div class="t-cell-xlarge"><?php echo $infosNbMsg['nb']; ?></div>
                                                    
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                            
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <script>
            jQuery(document).ready( function() {
                jQuery('.cell-more').hide();
                jQuery('.link-more').click(function() {
                    jQuery(this).parents('.t-cell-full').next('.cell-more').toggle();

                });
            });
        </script>
    </section>
</div>
