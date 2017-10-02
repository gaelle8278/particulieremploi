<?php
/**
 * Affichage des résultats de la recherche d'annonces
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

 //echo "<pre>";print_r($_POST);echo "</pre>";
 //echo "<pre>";print_r($params);echo "</pre>";
$message="";
if(empty($params['codep']) || $params['codep']===false) {
    $message = "<br>- le code postal est invalide";
}
if(empty($params['metier'])) {
    $message = "<br>- le métier n'a pas été sélectionné";
}

//si les paramètres de recherche sont présents 
if(empty($message)) {
    //recherche du nom du métier
    $queryLibMetier= "SELECT referentiel_libelle "
            . "from ".TBL_REF_METIERS." "
            . "where referentiel_visibilite = '1' "
            . "and referentiel_id=".$params['metier'];
    //echo "<pre>";print_r($queryLibMetier); echo "</pre>";
    $resLibMetier = $wpdb->get_row($queryLibMetier);
    $libelleMetier=$resLibMetier->referentiel_libelle;
    
    //recherche du domaine d'activités lié au métier
    $refLibDomaine = '';
    $queryLibDomaine = "select "
                        . "domaine_classif_libelle, domaine_classif_id "
                        . "from " . TBL_DOMAINE_CLASSIF . " tdc, "
                        . TBL_METIERS . " tref "
                        . "where tref.referentiel_id=" . $params['metier'] . ""
                        . " and tref.referentiel_domaine_classif=tdc.domaine_classif_id";
    $resLibdomaine = $wpdb->get_row($queryLibDomaine);
    $refLibDomaine = $resLibdomaine->domaine_classif_libelle;
    $idDomaine = $resLibdomaine->domaine_classif_id;

    //construction de la clause where
    $whereclause="";
    if(!empty($params['datepf'])) {
        list($day, $month ,$year)=explode('/',$params['datepf']);
        $limiteDate = $year."-".$month."-".$day;
        $whereclause .= " AND annonce_dateprisefonction >= '".$limiteDate."'";
    } else {
        //limitation aux annonces les plus récentes : inférieure à 3 mois
        $limiteDate = date ("Y-m-d", mktime(0,0,0,date("m"),date("d")-90,date("Y")));
        $whereclause .=  " AND annonce_datecrea >= '".$limiteDate."'";
    }
    if(!empty($params['dureehebdomin'])) {
        $whereclause .= " AND annonce_dureehebdomadaire >= ".$params['dureehebdomin'];
    }
    if(!empty($params['dureehebdomax'])) {
        $whereclause .= " AND annonce_dureehebdomadaire <= ".$params['dureehebdomax'];
    }
    if(!empty($params['tauxh'])) {
        $whereclause .= " AND annonce_tauxhoraire >= ".$params['tauxh'];
    }
    
    if(!empty($params['distance'])) {

        $PI=M_PI;

        //1 recherche latitude et longitude de la commune : infos présentes en bdd
        $queryFetchCoord = "SELECT communes_latitude, communes_longitude from ".TBL_VILLES." "
                . "where communes_cpo = '".$params['codep']."' ";
        $resultFetchCoord = $wpdb->get_row($queryFetchCoord, ARRAY_A);
        $latitude1=$resultFetchCoord['communes_latitude'];
        $longitude1=$resultFetchCoord['communes_longitude'];
        

        $reqRecupAnnonces = "SELECT *, 
         ((((acos((sin(($PI * $latitude1/180)) * sin(($PI * annonce_latitude/180)) + cos(($PI * $latitude1/180)) * cos(($PI * annonce_latitude/180)) * cos(($PI * ($longitude1-annonce_longitude)/180))))) * 180/$PI) * 60 * 1.1515) * 1.609344)
            AS distance
          FROM ".TBL_ANNONCES."
          WHERE annonce_idmetier = '".$params['metier']."' 
          AND annonce_type = '".strtoupper($params['type_annonce'])."'
          AND annonce_etat = 'ACTIF'
          ".$whereclause."
          HAVING  distance <= (".$params['distance'].")
          ORDER by distance 
          LIMIT 32
            ";  
    }
    else {
       $reqRecupAnnonces = "SELECT * 
           from ".TBL_ANNONCES."
         WHERE annonce_idmetier = '".$params['metier']."'
         AND annonce_codepostal = '".$params['codep']."'
         AND annonce_type = '".strtoupper($params['type_annonce'])."'
         AND annonce_etat = 'ACTIF'
         ".$whereclause."
         ORDER BY annonce_dateprisefonction DESC 
         LIMIT 32
           ";
    }
    $exeRecupAnnonces=$wpdb->get_results($reqRecupAnnonces, ARRAY_A);
    $nbAnnonces= $wpdb->num_rows;
    
    //si on est dans l'espace perso on cherche les annonces en favori de l'utilisateur
    if(isset($_SESSION['utilisateur_id'])) {
        $userFavAnnonces=[];
        $queryFavAnnonce="select maselection_annonceid from "
                . " ".TBL_FAVORIS." "
                . " WHERE maselection_utilisateurid =".$_SESSION['utilisateur_id'];
        $resFavAnnonce=$wpdb->get_results($queryFavAnnonce);
        foreach($resFavAnnonce as $favAnnonce) {
            $userFavAnnonces[]=$favAnnonce->maselection_annonceid;
        }
    }
    
}
?>
<div class="content-central-column">
    <section class="search_results">
        <?php
        //affichage du fil d'ariane si on n'est pas dans l'espace perso
        if(!isset($_SESSION['utilisateur_id'])) {
            ?>
            <div class="breadcrumb">
                <a href="<?php echo get_bloginfo('wpurl'); ?>">
                    <img src="<?php echo get_template_directory_uri() ?>/images/pictos/home.png" />
                </a> > 
                <span class="text-bold">
                    <?php
                    if($params['type_annonce']=='sal') {
                        echo "Je cherche un salarié";
                    } else {
                        echo "Je cherche une offre";
                    }
                    ?>
                </span> > Resultats de la recherche
            </div>
            <?php
        }
        ?>
        <div class="bloc-res-search">
            <h1>Résultats de ma recherche</h1>
            <?php
            if(!empty($message)) {
                echo "<p>La recherche ne peut pas aboutir car : <br>".$message."</p>";
            } else {
                ?>
                <p class="results-intro">
                    <?php
                    if(!empty($nbAnnonces)){
                        $intro=  "<span class='text-bold'>".$nbAnnonces;
                        if($params['type_annonce']=="sal") {
                            $intro .= " profil(s) de salarié";
                        } else {
                            $intro .= " offre(s)";
                        }
                        $intro.= "</span> disponible(s) pour le métier <span class='text-bold'>".$libelleMetier."</span>";
                        $intro.= " à <span class='text-bold'>".$params['codep']."</span>";
                        $intro .= !empty($params['distance']) ? " dans un rayon de <span class='text-bold'>".$params['distance']." kms</span>":"";
                    }
                    else {
                        if($params['type_annonce']=="sal") {
                            $intro =  "Aucun profil de salarié";
                        } else {
                            $intro = "Aucune offre";
                        }
                        $intro .= " disponible pour ".$libelleMetier." à ".$params['codep'];
                        
                        $intro .= !empty($params['distance']) ? " dans un rayon de ".$params['distance']." kms":"";
                    }
                    echo $intro;
                    ?>
                </p>
                <?php
                if($params['type_annonce']=="sal") {
                    $type="emp";
                } else {
                    $type="sal";
                }
                if (!empty($nbAnnonces)) {
                    ?>
                    <div id='results-data'>
                        <table id='resultsTable'>
                            <thead>
                                <tr>
                                <th>Référence</th>
                                <th>Localisation</th>
                                <th>Classification</th>
                                <th>&nbsp</th>
                                </tr>
                            </thead>
                            <?php
                            //lien de contact => dépend si recherche authentifiée ou pas
                            if(isset($_SESSION['utilisateur_id'])) {
                                $contact_link = '/pe/espace-pe/messagerie/envoyer.php?type_annonce='.$params['type_annonce'];
                            } else {
                                $contact_link = '/pe/inscription/compte.php?type='.$type;
                            }
                            ?>
                            <tbody>
                                <?php
                                foreach ($exeRecupAnnonces as $annonce){
                                    $annonce['annonce_dateprisefonction'] = convert_date($annonce['annonce_dateprisefonction'],'/');
                                    $annonce['annonce_ville'] = stripslashes($annonce['annonce_ville']);
                                    $annonce['annonce_ville'] = ucfirst(strtolower($annonce['annonce_ville']));

                                    //récupération des emplois-repère liés à l'annonce 
                                    $queryRecupER = "select er.emploi_repere_libelle "
                                                    . "from " 
                                                    . TBL_EMPLOI_REPERE . " er, " 
                                                    . TBL_ASSOC_ER_ANNONCE . " erannonce "
                                                    . "where erannonce.annonce_id=" . $annonce['annonce_id'] . " "
                                                    . "and erannonce.emploi_repere_id=er.emploi_repere_id";
                                    $resEr = $wpdb->get_results($queryRecupER);
                                    $tabErAnnonce=array();
                                    foreach ($resEr as $dataEr) {
                                        $tabErAnnonce[] = $dataEr->emploi_repere_libelle;
                                    }
                                    if (isset($tabErAnnonce) && !empty($tabErAnnonce)) {
                                        $annonce['emploi-repere'] = implode(',', $tabErAnnonce);
                                    } else {
                                        $annonce['emploi-repere']="";
                                    }

                                    //lien de contact => dépend si recherche authentifiéé ou pas

                                    if(isset($_SESSION['utilisateur_id'])) {
                                        $contact_annonce = $contact_link.'&id_dest_msg='.$annonce['annonce_idauteur'];
                                    } else {
                                        $contact_annonce = $contact_link.'&idAnnonce='.$annonce['annonce_id'];
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <img src='<?php echo get_template_directory_uri() ?>/images/charte/img_domaine_<?php echo $idDomaine; ?>.png' />
                                            <p><span class="text-bold">Ref : <?php echo $annonce['annonce_id']; ?></span><br>
                                                disponible à partir du <?php echo $annonce['annonce_dateprisefonction']; ?></p>
                                        </td>
                                        <td>
                                            <?php echo $annonce['annonce_codepostal']."<br>".$annonce['annonce_ville'];?>
                                        </td>   
                                        <td>
                                            <?php echo $annonce['emploi-repere'] ?>
                                        </td>
                                        <td class="cell-contact cell-contact-<?php echo $params['type_annonce'] ?>"> 
                                            <a href='<?php echo $contact_annonce; ?>'> 
                                                <?php
                                                if($params['type_annonce']=="sal") {
                                                    echo "Contacter le salarié";
                                                } else {
                                                    echo "Contacter l'employeur";
                                                }
                                                ?>
                                            </a>
                                            <?php
                                            //on est dans l'espace perso => gestion de l'ajout en favori
                                            if(isset($_SESSION['utilisateur_id'])) {
                                                if(in_array($annonce['annonce_id'], $userFavAnnonces)) {
                                                    ?>
                                                    <p>
                                                        <?php
                                                        if ($annonce['annonce_type'] == 'EMP') {
                                                             echo "Offre dans vos favoris";
                                                        } else {
                                                            echo "Annonce dans vos favoris";
                                                        }
                                                        ?>
                                                    </p>
                                                    <?php
                                                } else {
                                                    ?>
                                                     
                                                    <a href="/pe/espace-pe/favoris.php" class="button_details">Voir le détail</a>
                                                    <input type="button" class="res_button_details" value="Voir le détail" />
                                                    <div class="custom-popup">
                                                        <?php
                                                        $label_taux="";
                                                        if ($annonce['annonce_type'] == 'EMP') {
                                                            $label_taux= "Taux brut proposé";
                                                        } else if ($annonce['annonce_type'] == 'SAL') {
                                                            $label_taux= "Taux brut souhaité";
                                                        }
                                                        ?>
                                                        <div class="popup-title">
                                                            <?php
                                                            if ($annonce['annonce_type'] == 'EMP') {
                                                                echo "Détail de l'offre";
                                                            } else if ($annonce['annonce_type'] == 'SAL') {
                                                                echo "Détail de l'annonce";
                                                            }
                                                            ?>
                                                        </div>
                                                        <p><span class="text-bold">Référence annonce : </span><?php echo $annonce['annonce_id']; ?> </p>
                                                        <p><span class="text-bold">Métier : </span><?php echo $libelleMetier; ?> </p>
                                                        <p><span class="text-bold">Expérience souhaitée dans ce métier : </span><?php echo get_experience($annonce['annonce_experience']); ?> </p>
                                                        <p><span class="text-bold">Particularités sur l'exercice du métier : </span><?php echo stripslashes($annonce['annonce_description']); ?> </p>
                                                        <p><span class="text-bold"><?php echo $label_taux; ?> (hors Cesu, hors ancienneté) : </span><?php echo $annonce['annonce_tauxhoraire']; ?> </p>
                                                        <p><span class="text-bold">Date de prise de fonction : </span><?php echo $annonce['annonce_dateprisefonction']; ?> </p>
                                                        <p><span class="text-bold">Code postal : </span><?php echo $annonce['annonce_codepostal']; ?> </p>
                                                        <p><span class="text-bold">Ville : </span><?php echo $annonce['annonce_ville']; ?> </p>
                                                        <p><span class="text-bold">Horaires de travail souhaités : </span><?php echo $annonce['annonce_dureehebdomadaire']; ?> h/semaine</p>
                                                        <div class="popup-buttons">
                                                            <input type="button" value="Ok" class="ok_button">
                                                            <?php
                                                            if ($_SESSION['utilisateur_groupe'] == 'EMP') {
                                                                $titleFavoris="Ajouter l'annonce en favori";
                                                            } else if ($_SESSION['utilisateur_groupe'] == 'SAL') {
                                                                $titleFavoris="Ajouter l'offre en favori";
                                                            }
                                                            ?>
                                                            <a href="/pe/espace-pe/favoris.php?part=ajout&annonceid=<?php echo $annonce['annonce_id']; ?>" title="<?php echo $titleFavoris; ?>"><?php echo $titleFavoris; ?></a>
                                                        </div>
                                                        <div class="close_button"></div>
                                                    </div>
                                                    <div class="res-custom-popup">
                                                        <p><span class="text-bold">Référence annonce : </span><?php echo $annonce['annonce_id']; ?> </p>
                                                        <p><span class="text-bold">Métier : </span><?php echo $libelleMetier; ?> </p>
                                                        <p><span class="text-bold">Expérience souhaitée dans ce métier : </span><?php echo get_experience($annonce['annonce_experience']); ?> </p>
                                                        <p><span class="text-bold">Particularités sur l'exercice du métier : </span><?php echo stripslashes($annonce['annonce_description']); ?> </p>
                                                        <p><span class="text-bold"><?php echo $label_taux; ?> (hors Cesu, hors ancienneté) : </span><?php echo $annonce['annonce_tauxhoraire']; ?> </p>
                                                        <p><span class="text-bold">Date de prise de fonction : </span><?php echo $annonce['annonce_dateprisefonction']; ?> </p>
                                                        <p><span class="text-bold">Code postal : </span><?php echo $annonce['annonce_codepostal']; ?> </p>
                                                        <p><span class="text-bold">Ville : </span><?php echo $annonce['annonce_ville']; ?> </p>
                                                        <p><span class="text-bold">Horaires de travail souhaités : </span><?php echo $annonce['annonce_dureehebdomadaire']; ?> h/semaine</p>
                                                        <div class="popup-buttons">
                                                            <?php
                                                            if ($_SESSION['utilisateur_groupe'] == 'EMP') {
                                                                $titleFavoris="Ajouter l'annonce en favori";
                                                            } else if ($_SESSION['utilisateur_groupe'] == 'SAL') {
                                                                $titleFavoris="Ajouter l'offre en favori";
                                                            }
                                                            ?>
                                                            <a href="/pe/espace-pe/favoris.php?part=ajout&annonceid=<?php echo $annonce['annonce_id']; ?>" title="<?php echo $titleFavoris; ?>"><?php echo $titleFavoris; ?></a>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>	
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        
                    </div>
                    <!-- div pour afficher la carte le cas échéant -->
                    <div style="position:relative; width:100%;">
                        <div style="width: 95%; height: 350px; display: none; margin:auto;" id="map"></div>
                    </div>
                <?php
                } // condition si résultats
            }// condition si pas d'erreur de soummission
            ?>  
            <div class='bloc_no_result bloc-no-annonce-<?php echo $params['type_annonce'] ?>'>
                <div class='bloc_no_annonce'>
                    <p class="text-bold text-intro">
                        <?php
                        if($params['type_annonce']=="sal") {
                            $text= "Aucun profil ne correspond à votre recherche ?";
                        } else {
                            $text= "Aucun offre ne correspond à votre recherche ?";
                        }
                        echo $text;
                        ?>
                        </p>
                    <p>
                        <?php
                        if($params['type_annonce']=="sal") {
                            $text= "Diffusez une offre d'emploi pour maximiser vos chances de trouver 
                            le salarié qui répond à vos attentes";
                        } else {
                            $text= "Diffusez une annonce pour maximiser vos chances de trouver 
                            un emploi qui répond à vos attentes";
                        }
                        echo $text;
                        ?>
                    </p>
                </div>
                <div class='bloc_no_annonce bloc-contact bloc-contact-<?php echo $params['type_annonce'] ?>'>
                    <?php
                    if(isset($_SESSION['utilisateur_id'])) {
                        $link_depot="/pe/espace-pe/compte.php?type=".$type;
                    } else {
                        $link_depot="/pe/inscription/compte.php?type=".$type;
                    }
                    ?>
                    <a href='<?php echo $link_depot; ?>'>
                        <?php
                        if ($type == "emp") {
                            echo "Déposer une offre";
                        } else {
                            echo "Déposer une annonce";
                        }
                        ?>
                    </a>
                </div> 
            </div>
        </div>
        <?php
        //si pas d'erreur
        if (empty($message)) {
            // si on n'est pas dans l'espace perso
            if(!isset($_SESSION['utilisateur_id'])) {
                    //encart Nouvelle classification
                    //si le métier est lié à un domaine d'activités
                    if (!empty($refLibDomaine)) {
                        //récupération des emplois-repères liés au métier objet de la recherche
                        $queryRefER = "select emploi_repere_libelle, "
                                . "emploi_repere_desc "
                                . "from " 
                                . TBL_EMPLOI_REPERE . " ter, "
                                . TBL_METIER_ER . " trefer "
                                . "where trefer.referentiel_id=" . $params['metier'] . " "
                                . "and trefer.emploi_repere_id=ter.emploi_repere_id";
                        $resRefER = $wpdb->get_results($queryRefER, ARRAY_A);
                        foreach ($resRefER as $dataRefER) {
                            $tabRefER[$dataRefER['emploi_repere_libelle']] = $dataRefER['emploi_repere_desc'];
                        }
                        // si il y a des ER
                        if (isset($tabRefER) && !empty($tabRefER)) {
                             ?>
                            <div class="bloc-res-search">
                            <?php
                                $nbRefER = count($tabRefER);
                                ?>
                                <div class='encart-classif'>
                                    <h2>Nouvelle Classification</h2>
                                    <div class="encart-classif-intro">
                                        <img src='<?php echo get_template_directory_uri() ?>/images/charte/img_domaine_<?php echo $idDomaine; ?>.png' />
                                        <p>
                                            Parmi les 21 emplois-repères de la nouvelle classification, 
                                            <?php 
                                                echo $nbRefER; 
                                                if($nbRefER > 1) {
                                                    echo " d'entre eux sont relatifs";
                                                } else {
                                                    echo " d'entre eux est relatif";
                                                }

                                            ?> 
                                            au domaine d’activité <span class="color-domaine-<?php echo $idDomaine; ?>"> &laquo; <?php echo $refLibDomaine; ?> &raquo; </span>
                                            <?php
                                            if($nbRefER > 1) {
                                                echo "et correspondent chacun à un niveau d’activités.";
                                            }
                                            ?>
                                        </p>
                                    </div>
                                    <div class="encart-classif-sep bg-domaine-<?php echo $idDomaine; ?>"></div>
                                    <div>
                                        <?php
                                        foreach ($tabRefER as $libER => $descER) {
                                            ?>
                                            <p class='text-bold color-domaine-<?php echo $idDomaine; ?>'><?php echo $libER; ?></p>
                                            <p><?php echo $descER; ?></p>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="encart-domaine-classif-links">
                                        <div class="link">
                                          <!--  <a  href="#" title="lien vers plus d'informations sur la nouvelle classification" target="_blank">
                                                > En savoir plus sur la nouvelle classification
                                            </a>-->
                                        </div><!-- @whitespace
                                        --><div class="link-button">
                                            <a  href='http://www.simulateur-emploisalarieduparticulieremployeur.fr' title="lien vers le simulateur de l'emploi des salariés du particulier employeur" target="_blank">
                                                lancez une simulation de l'emploi
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                
            <?php
            }
        }
        ?>
    </section> 
</div>   
<?php $key = getKey();?>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $key ?>" type="text/javascript"></script>
<script>
    function affichecarte(){
        //a faire
    }
    function loading(){
        if(jQuery("#carte").attr("checked") == "checked"){
            jQuery("#map").show();
            affichecarte();
            jQuery("#results-data").hide();

        } else {
            jQuery("#map").hide();
            jQuery("#results-data").show();
        }
}
    window.onload=function() {
        loading();
    }
</script>

