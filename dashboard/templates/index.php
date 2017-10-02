<?php
/* 
 * Template page d'accueil BO
 */

?>
<div class="content-central-column">
    <section class="home">
        <div class="block-content-bo">
            <h2>Recherche</h2>
            <div class="half-column">
                <?php
                if(!empty($tabDisplayError)) {
                    foreach ($tabDisplayError as $errorMsg) {
                        echo "<p>".$errorMsg."</p>";
                    }
                }
                ?>
                <form action="/dashboard/index.php" method="POST">
                    <div class="bloc-field-form">
                        <label class="field-label" for="uid">Identifiant</label>
                        <div class="field-value">
                            <input type="text" name="uid" id="uid"
                                   value="<?php echo isset($params['uid'])?$params['uid']:''; ?>"
                                   class="input-style"/>
                        </div>
                    </div>
                    <div class="bloc-field-form">
                        <label class="field-label" for="ufname">Prénom</label>
                        <div class="field-value">
                            <input type="text" name="ufname" id="ufname"
                                   value="<?php echo isset($params['ufname'])?$params['ufname']:''; ?>"
                                   class="input-style"/>
                        </div>
                    </div>
                    <div class="bloc-field-form">
                        <label class="field-label" for="ulname">Nom</label>
                        <div class="field-value">
                            <input type="text" name="ulname" id="ulname"
                                   value="<?php echo isset($params['ulname'])?$params['ulname']:''; ?>"
                                   class="input-style"/>
                        </div>
                    </div>
                    <div class="bloc-field-form">
                        <label class="field-label" for="uemail">Email</label>
                        <div class="field-value">
                            <input type="text" name="uemail" id="uemail"
                                   value="<?php echo isset($params['uemail'])?$params['uemail']:''; ?>"
                                   class="input-style"/>
                        </div>
                    </div>
                    <p class="text-italic">Les critères de recherche sont cumulatifs</p>
                    <div class="bloc-button">
                        <input type="submit" value="Rechercher" name="usearch"/>
                    </div>
                </form>
               
            </div>
            <div class="half-column">
                <p>
                    <?php
                    if(isset($nbUsers)) {
                        ?>
                        <h3>Résultats de la recherche</h3>
                        <p>Nombre de résultats : <?php echo $nbUsers; ?></p>
                        <div>
                            <?php
                            foreach ($exeSearchUser as $user) {
                                ?>
                                <p>
                                    <a class="content-link" href="/dashboard/fiche.php?id=<?php echo $user['utilisateur_id']; ?>" >
                                    <?php
                                    echo $user['utilisateur_id']." - ".$user['utilisateur_prenom']." ".$user['utilisateur_nom']." "
                                        . "(".$user['utilisateur_mail'].")"; ?>
                                    </a>
                                </p>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </p>
            </div>
            <div class="wrap-clear"></div>
        </div>
        
        <div class="block-content-bo">
            <h2>Utilisateurs bloqués</h2>
            <?php
            if(empty($tabUsersBlocked)) {
                ?>
                <p>Aucun utilisateurs bloqués par d'autres utilisateurs</p>
                <?php
            } else {
                ?>
                <p>Liste des 30 derniers utilisateurs bloqués</p>
                <div class="table-results">
                    <div class="table-header">
                        <div class="t-cell-large">Utilisateur bloqué</div>
                        <div class="t-cell-medium">Bloqué par</div>
                        <div class="t-cell-large">Raison blocage</div>
                        <div class="t-cell-large">Date blocage</div>
                    </div>
                    <?php
                    foreach($tabUsersBlocked as $infos) {
                    ?>
                        <div class="table-record">
                            <div class="table-row">
                                <div class="t-cell-large">
                                    <a class="content-link" href="/dashboard/fiche.php?id=<?php echo $infos['id_user_bloque']; ?>" >
                                    <?php echo $infos['nom_user_bloque']." ".$infos['prenom_user_bloque']; ?>
                                    </a>
                                </div>
                                <div class="t-cell-medium">
                                    <a class="content-link" href="/dashboard/fiche.php?id=<?php echo $infos['id_user_bloquant']; ?>" >
                                    <?php echo $infos['nom_user_bloquant']." ".$infos['prenom_user_bloquant']; ?>
                                    </a>
                                </div>
                                <div class="t-cell-large"><?php echo $infos['raison_blocage']; ?></div>
                                <div class="t-cell-large"><?php echo $infos['date_blocage']; ?></div>
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
        <div class="block-content-bo">
            <h2>Messages indésirables</h2>
            <?php
            if(empty($exeRecupMsgSpam)) {
                ?>
                <p>Aucun messages indésirables signalés par les utilisateurs</p>
                <?php
            } else {
                ?>
                <p>Liste des 30 derniers messages signalés comme indésirables</p>
                <div class="table-results">
                    <div class="table-header">
                        <div class="t-cell-xlarge">Message</div>
                        <div class="t-cell-large">Expéditeur</div>
                        <div class="t-cell-large">Signalé par</div>
                    </div>
                    <?php
                    foreach($tabMsgSpam  as $msg) {
                    ?>
                        <div class="table-record">
                            <div class="table-row">
                                <div class="t-cell-xlarge ">
                                    <?php echo $msg['message_objet']."<br/>".
                                            $msg['message_contenu']; ?>
                                </div>
                                <div class="t-cell-large">
                                    <a class="content-link" href="/dashboard/fiche.php?id=<?php echo $msg['exp_id']; ?>" >
                                    <?php echo $msg['exp_prenom']." ".$msg['exp_nom']; ?>
                                    </a>
                                </div>
                                <div class="t-cell-large">
                                    <a class="content-link" href="/dashboard/fiche.php?id=<?php echo $msg['dest_id']; ?>" >
                                    <?php echo $msg['dest_prenom']." ".$msg['dest_nom']; ?>
                                    </a>
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
        <div class="block-content-bo">
            <h2>Employeurs actifs envoyant plus de 10 messages par jour</h2>
            <?php
            if(empty($recupExpUserOverLimit)) {
                ?>
                <p>Aucun employeurs actifs envoyant plus de 10 messages par jour</p>
                <?php
            } else {
                ?>
                <p>Les 30 utilisateurs envoyant le plus de messages par jour</p>
                <div class="table-results">
                    <div class="table-header">
                        <div class="t-cell-large">Expéditeur</div>
                        <div class="t-cell-large">Nombre de messages</div>
                        <div class="t-cell-large">Date</div>
                    </div>
                    <?php
                    foreach($recupExpUserOverLimit  as $infosExp) {
                    ?>
                        <div class="table-record">
                            <div class="table-row">
                                <div class="t-cell-large">
                                    <a class="content-link" href="/dashboard/fiche.php?id=<?php echo $infosExp['message_exp']; ?>" >
                                    <?php echo $infosExp['utilisateur_prenom']." ".$infosExp['utilisateur_nom']; ?>
                                    </a>
                                </div>
                                <div class="t-cell-large">
                                    <?php echo $infosExp['nb']; ?>
                                </div>
                                <div class="t-cell-large">
                                    <?php echo convert_date($infosExp['message_date'],"/"); ?>
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
        
        <!-- form -->
        <div class="block-content-bo">
            <h2>Recherche</h2>
            <p class="text-bold">La recherche se fait sur les utilisateurs actifs</p>
            <form action="/dashboard/index.php" method="POST">
                <div class="bloc-field-form">
                    <label class="field-label-inline">Messages envoyés depuis : </label>
                    <div class="field-value-inline">
                        <input type="radio" name="mess_env" value="7" id="mess_env_7"
                            <?php
                            if(isset($params['mess_env']) && $params['mess_env']=="7") {
                                echo "checked='checked'";
                            }
                            ?>
                        >
                        <label for="mess_env_7">les 7 derniers jours</label>
                        <input type="radio" name="mess_env" value="30" id="mess_env_30"
                            <?php
                            if(isset($params['mess_env']) && $params['mess_env']=="30") {
                                echo "checked='checked'";
                            }
                            ?> 
                        >
                        <label for="mess_env_30">les 30 derniers jours</label>
                    </div>
                </div>
                <div class="bloc-field-form">
                    <label class="field-label-inline">Filtrer les messages créés depuis : </label>
                    <div class="field-value-inline">
                        <input type="radio" name="mess_filtre" value="7" id="mess_filtre_7"
                            <?php
                            if(isset($params['mess_filtre']) && $params['mess_filtre']=="7") {
                                echo "checked='checked'";
                            }
                            ?>
                        >
                        <label for="mess_filtre_7">les 7 derniers jours</label>
                        <input type="radio" name="mess_filtre" value="30" id="mess_filtre_30"
                            <?php
                            if(isset($params['mess_filtre']) && $params['mess_filtre']=="30") {
                                echo "checked='checked'";
                            }
                            ?> 
                        >
                        <label for="mess_filtre_30">les 30 derniers jours</label>
                    </div>
                </div>
                <div class="bloc-field-form">
                    <span class='text-bold'>NB : </span>Les critères sont exclusifs, les recherches sont indépendantes
                </div>
                <div class="bloc-button">
                    <input type="submit" value="Rechercher" name="usearchmess"/>
                </div>
            </form>
            <!-- results -->
            <div id="search-alerts">
                <ul>
                    <li><a href="#search-alert_messenv"><span>Messages envoyés</span></a></li>
                    <li><a href="#search-alert_messfiltre"><span>Messages avec mots-clefs suspects</span></a></li>
                </ul>
                <div id="search-alert_messenv">
                    <?php
                    if(isset($exeRecupCntMsgEnv)) {
                        if(empty($exeRecupCntMsgEnv)) {
                            ?>
                            <p>Aucun messages envoyés les <?php echo $params['mess_env']; ?> derniers jours.</p>
                            <?php
                        } else {
                            ?>
                            <p>Liste des 30 utilisateurs actifs envoyant le plus de messages par jour depuis les
                                <?php echo $params['mess_env']; ?> derniers jours.</p>
                            <?php
                            foreach($exeRecupCntMsgEnv as $cntEnvMsg) {
                                ?>
                                <p>
                                    <a class="content-link" href="/dashboard/fiche.php?id=<?php echo $cntEnvMsg['message_exp']; ?>" >
                                        <?php echo $cntEnvMsg['utilisateur_prenom']." ".$cntEnvMsg['utilisateur_nom'].
                                                " (".$cntEnvMsg['message_exp'].")"; ?>
                                    </a>
                                    a envoyé <?php echo $cntEnvMsg['nb']." messages le ".convert_date($cntEnvMsg['message_date'], "/"); ?>
                                </p>
                                <?php
                            }
                        }
                    }
                    ?>
                </div>
                <div id="search-alert_messfiltre">
                    <?php
                    if(isset($tabMsgFiltre)) {
                        if(empty($tabMsgFiltre)) {
                            ?>
                            <p>Aucun messages avec des mots-clefs suspects envoyés 
                                les <?php echo $params['mess_filtre']; ?> derniers jours.</p>
                            <?php
                        } else {
                            ?>
                            <p>Liste des messages contenant des mots suspects et envoyés par des utilisateurs actifs depuis les
                                <?php echo $params['mess_filtre']; ?> derniers jours.</p>
                            <div class="table-results">
                                <div class="table-header">
                                    <div class="t-cell-medium">Expéditeur</div>
                                    <div class="t-cell-medium">Destinataire</div>
                                    <div class="t-cell-xlarge">Objet</div>
                                    <div class="t-cell-xlarge">Date</div>
                                </div>
                                <?php
                                foreach($tabMsgFiltre  as $msgFiltre) {
                                ?>
                                    <div class="table-record">
                                        <div class="table-row">
                                            <div class="t-cell-medium">
                                                <a class="content-link" href="/dashboard/fiche.php?id=<?php echo $msgFiltre['message_exp']; ?>" >
                                                <?php echo $msgFiltre['exp_prenom']." ".$msgFiltre['exp_nom']; ?>
                                                </a>
                                            </div>
                                            <div class="t-cell-medium">
                                                <a class="content-link" href="/dashboard/fiche.php?id=<?php echo $msgFiltre['message_dest']; ?>" >
                                                <?php echo $msgFiltre['dest_prenom']." ".$msgFiltre['dest_nom']; ?>
                                                </a>
                                            </div>
                                            <div class="t-cell-xlarge">
                                                <?php echo $msgFiltre['message_objet']; ?>
                                            </div>
                                            <div class="t-cell-xlarge">
                                                <?php echo convert_datetime($msgFiltre['message_datecrea']); ?>
                                            </div>
                                        </div>
                                        <div class="table-row">
                                            <div>
                                                Contenu : <br />
                                                <?php echo $msgFiltre['message_contenu']; ?>
                                            </div>
                                        </div>

                                    </div>
                                <?php 
                                }
                                ?>
                            </div>
                        <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <aside>
        <div class="wrap-content">
            <p class="text-bold text-underlined">Comptes</p>
            <p class="text-underlined">Employeur</p>
            <p class="text-italic">Aujourd'hui</p>
            <p><?php echo "Nombre de compte employeurs actifs créés aujourd'hui : ";
                        echo isset($tabStatsAccount['EMP']['actif'])?$tabStatsAccount['EMP']['actif']:"0"; ?><br/>
            <?php echo "Nombre de compte employeurs non validés créés aujourd'hui : ";
                        echo isset($tabStatsAccount['EMP']['non validé'])?$tabStatsAccount['EMP']['non validé']:"0"; ?></p>
            <p class="text-italic">Les 3 derniers mois</p>
            <p><?php echo "Nombre de compte employeurs actifs créés les 3 derniers mois : ";
                        echo isset($tabStatsAccountM3['EMP']['actif'])?$tabStatsAccountM3['EMP']['actif']:"0"; ?><br/>
            <?php echo "Nombre de compte employeurs non validés créés les 3 derniers mois : ";
                        echo isset($tabStatsAccountM3['EMP']['non validé'])?$tabStatsAccountM3['EMP']['non validé']:"0"; ?></p>
            <p class="text-underlined">Salarié</p>
            <p class="text-italic">Aujourd'hui</p>
            <p><?php echo "Nombre de compte salariés actifs créés aujourd'hui : ";
                        echo isset($tabStatsAccount['SAL']['actif'])?$tabStatsAccount['SAL']['actif']:"0"; ?><br />
            <?php echo "Nombre de compte salariés non validés créés aujourd'hui : ";
                        echo isset($tabStatsAccount['SAL']['non validé'])?$tabStatsAccount['SAL']['non validé']:"0"; ?></p>
            <p class="text-italic">Les 3 derniers mois</p>
            <p><?php echo "Nombre de compte salariés actifs créés les 3 derniers mois : ";
                        echo isset($tabStatsAccountM3['SAL']['actif'])?$tabStatsAccountM3['SAL']['actif']:"0"; ?><br />
            <?php echo "Nombre de compte salariés non validés créés les 3 derniers mois : ";
                        echo isset($tabStatsAccountM3['SAL']['non validé'])?$tabStatsAccountM3['SAL']['non validé']:"0"; ?></p>
            
            <p class="text-bold text-underlined">Annonces</p>
            <p class="text-underlined">Employeur</p>
            <p class="text-italic">Aujourd'hui</p>
            <p><?php echo "Nombre d'annonces employeurs actives crééés aujourd'hui : ";
                        echo isset($tabStatsAnnonces['EMP']['active'])?$tabStatsAnnonces['EMP']['active']:"0"; ?><br />
            <?php echo "Nombre d'annonces employeurs non validées créées aujourd'hui : ";
                        echo isset($tabStatsAnnonces['EMP']['non validée'])?$tabStatsAnnonces['EMP']['non validée']:"0"; ?></p>
            <p class="text-italic">Les 3 derniers mois</p>
            <p><?php echo "Nombre d'annonces employeurs actives crééés les 3 derniers mois : ";
                        echo isset($tabStatsAnnoncesM3['EMP']['active'])?$tabStatsAnnoncesM3['EMP']['active']:"0"; ?><br />
            <?php echo "Nombre d'annonces employeurs non validées créées les 3 derniers mois : ";
                        echo isset($tabStatsAnnoncesM3['EMP']['non validée'])?$tabStatsAnnoncesM3['EMP']['non validée']:"0"; ?></p>
            <p class="text-underlined">Salarié</p>
            <p class="text-italic">Aujourd'hui</p>
            <p><?php echo "Nombre d'annonces salariés actives créées aujourd'hui : ";
                        echo isset($tabStatsAnnonces['SAL']['active'])?$tabStatsAnnonces['SAL']['active']:"0"; ?><br />
            <?php echo "Nombre d'annonces salariés non validées créées aujourd'hui : ";
                        echo isset($tabStatsAnnonces['SAL']['non validée'])?$tabStatsAnnonces['SAL']['non validée']:"0"; ?></p>
            <p class="text-italic">Les 3 derniers mois</p>
            <p><?php echo "Nombre d'annonces salariés actives créées les 3 derniers mois : ";
                        echo isset($tabStatsAnnoncesM3['SAL']['active'])?$tabStatsAnnoncesM3['SAL']['active']:"0"; ?><br />
            <?php echo "Nombre d'annonces salariés non validées créées les 3 derniers mois : ";
                        echo isset($tabStatsAnnoncesM3['SAL']['non validée'])?$tabStatsAnnoncesM3['SAL']['non validée']:"0"; ?></p>
        </div>
    </aside>
    <div class="wrap-clear"></div>
    <script>
        jQuery(document).ready( function($) {
            $( "#search-alerts" ).tabs();
        });
    </script>
</div>

