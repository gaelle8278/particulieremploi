<?php

/**
 * Affichage de la 2ème étape du parcours d'inscription : choix du métier
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
?>

<div class="content-central-column">
    <?php
    if(!isset($_SESSION['utilisateur_id'])) {
        $step_active="emploi";
        include_once('parcours-navigation.php');
    }
    ?>
    <section>
        <div class="bloc-content">
            <h1>Choisir un métier</h1>
            <p>Nous vous remercions de choisir le métier dans lequel vous souhaitez 
                déposer votre offre d'emploi parmi les domaines d'activités proposés ci-après.</p>
                <?php
                    if(!empty($tabDisplayError)) {
                        ?>
                        <p class="error-valid">
                            <?php
                            foreach ($tabDisplayError as $field => $error) {
                                echo $error."<br>";
                            }
                            ?>
                        </p>
                        <?php
                    }
                ?>
        </div>
        <div class='bloc-content-effect'></div>
        
        <div>
            <?php
            if(isset($message)) {
                echo "<p>".$message."</p>"; 
            }
            //if($params['domaine_activite'] == 0 ) {
                $queryRecupMetiers="SELECT * 
                         from ".TBL_METIERS." ref, 
                         ".TBL_CATEGORIES." cat 
                         where ref.referentiel_parent='' 
                         and ref.referentiel_categorie=cat.categorie_id 
                         and ref.referentiel_inscription=1 
                         order by cat.categorie_id asc, referentiel_libelle asc";
            //}
            //02/2016 nouvelle classif : ajout d'un filtre par rapport au domaine d'activités
            /*else {
                $queryRecupMetiers="SELECT * from 
                        ".TBL_METIERS." ref, 
                        ".TBL_CATEGORIES." cat 
                        where  ref.referentiel_parent='' 
                        and ref.referentiel_domaine_classif=".$params['domaine_activite']." 
                        and ref.referentiel_inscription=1 
                        and ref.referentiel_categorie=cat.categorie_id  
                        order by cat.categorie_id asc, referentiel_libelle asc";
            }*/
            //echo "<pre>";print_r($queryRecupMetiers);echo "</pre>";
            $resultat= $wpdb->get_results($queryRecupMetiers, ARRAY_A);
            
            $arrFirstNiv = array();
            $i=0;
            $affichageMetiers=array();
            foreach ($resultat as $data) {
                 //metiers parents
                $id1=$data['referentiel_id'];
                $libelle=$data['referentiel_libelle'];
                $categorie=$data['categorie_nom'];
                $categorieComplement=$data['categorie_plus_infos'];
                $domaineOfRef=$data['referentiel_domaine_classif'];

                //récupération du nom du domaine d'activités auquel appartient le métier
                $queryLibDomaine="select domaine_classif_libelle 
                        from ".TBL_DOMAINE_CLASSIF."
                        where domaine_classif_id=".$domaineOfRef;
                $resLibdomaine=$wpdb->get_row($queryLibDomaine);
                //$rowLibDomaine=$resLibdomaine->domaine_classif_libelle;
                $refLibDomaine[$id1]=$resLibdomaine->domaine_classif_libelle;


                //récupération des emploi-repères liés au métier
                $queryRecupER="select 
                            refer.emploi_repere_id ,  
                            er.emploi_repere_libelle, 
                            er.emploi_repere_desc 
                        from ".TBL_METIER_ER." refer , 
                        ".TBL_EMPLOI_REPERE." er 
                        where refer.referentiel_id=".$id1." 
                        and refer.emploi_repere_id=er.emploi_repere_id 
                        order by er.emploi_repere_id" ;
                //echo "<pre>";print_r($queryRecupER);echo "</pre>";
                $resRecupER = $wpdb->get_results($queryRecupER);
                foreach ($resRecupER as $recupER) {
                     $metierER[$id1][]=array($recupER->emploi_repere_id, $recupER->emploi_repere_libelle, $recupER->emploi_repere_desc);

                }
    
                //On stocke le premier niveau dans un tableau pour gérer ensuite l'arbre des métiers
                $arrFirstNiv[$i][0] = $data['referentiel_id'];
                $arrFirstNiv[$i][1] = $data['referentiel_libelle'];
    
                //on stocke les métiers par catégorie pour gérer ensuite l'affichage des métiers parents
                //id de la catégorie sert à créer une class pour appliquer des couleurs spécifiques
                $affichageMetiers[$categorie]['id']=$data['categorie_id'];
                $affichageMetiers[$categorie]['plusInfos']=$categorieComplement;
                $affichageMetiers[$categorie]['listeMetiers'][]=array($id1,$libelle);
    
                $i++;
            }
            ?>
            <form id="form-inscription" action="/pe/inscription/emploi.php" method="POST" >
               
                <!--<input type="hidden" name="id" value="<?php echo  $params['id']; ?>"/>-->
                <!--<input type="hidden" name="domaine_activite" value="<?php echo  $params['domaine_activite']; ?>"/>-->
            
                <div id='accordion'>
                    <?php
                    foreach($affichageMetiers as $categorie=>$categorieInfos) {
                        //entête de la catégorie = entête de l'accordéon
                        echo "<h3 id='cat_".$categorieInfos['id']."'>
                                <img src='".get_template_directory_uri()."/images/charte/img_cat_".$categorieInfos['id'].".png' />".ucfirst($categorie);
                            if(!empty($categorieInfos['plusInfos'])) {
                                echo "<p class='sousTitreEntete'>".$categorieInfos['plusInfos']."</p>";
                            }  
                        echo "</h3>";
                        //affichage contenu de la catégorie= panneau de contenu de l'accordéon
                        echo "<div>";
                        foreach ($categorieInfos['listeMetiers'] as $metier) {
                            $idMetier=$metier[0];
                            $libelleMetier=$metier[1];
                            echo "<div class='blocMetier'>";
                                echo "<p class='optionMetier'>";
                                echo "  <input type='radio' name='jobSelect' id='job_".$idMetier."'  value='".$idMetier."' class='choixMetier' />";
                                echo "  <label for='job_".$idMetier."''>".ucfirst($libelleMetier)."</label>";
                                echo "</p>";
                                if(!empty($metierER[$idMetier])) {
                                    $nbRefER=count($metierER[$idMetier]);
                                    $metierDomaine=$refLibDomaine[$idMetier];
                                    $listeER=$metierER[$idMetier];
                                    echo "<div class='optionER'>";
                                        //texte description avant affichage des emplois-repère
                                        echo "<p>";
                                        echo "Parmi les 21 emplois-repères de la nouvelle classification, ".$nbRefER." d'entre eux sont relatifs au domaine d’activité &laquo; ".$metierDomaine." &raquo; et correspondent "
                                                . "chacun à  d’entre à un niveau d’activités. Nous vous invitons à sélectionner le niveau d’activité correspondant  pour qualifier l’emploi du salarié :";
                                        echo "</p>";
                                        //affichage des emplois-repères
                                        foreach($listeER as $propER) {
                                            echo "<div class='blocER'>";
                                            echo "<input type='checkbox' name='erSelect[]' id='".$idMetier."_er_".$propER[0]."' value='".$propER[0]."' class='choixER' />";
                                            echo "<label for='".$idMetier."_er_".$propER[0]."' >".ucfirst($propER[1])."</label>";
                                            echo "<div class='descER'>".$propER[2]."</div>";
                                            echo "</div>";
                                            //echo $propER[1];
                                        }
                                    echo "</div>";
                                
                            
                                }
                            echo "</div>";

                        }
                        echo "</div>";
    
                    }
                    
                    ?>
                </div>
                <div class="bloc-submit-form bloc-submit-inscription">
                    <?php
                    //si on dépose depuis l'espace pe
                    if(isset($_SESSION['utilisateur_id'])) {
                        $lienRetour = "/pe/espace-pe/compte.php";
                    } else {
                        //on est dans le parcours d'inscription
                        $lienRetour = "/pe/inscription/compte.php";
                        /*$lienRetour = "/pe/inscription/compte.php?type=".$type_compte."&id=".$params['id'];
                        if(isset($params['idAnnonce'])) {
                            $paramsLienRetour .="&idAnnonce=".$params['idAnnonce'];
                        }*/
                    }
                    ?>
                    <a href='<?php echo $lienRetour; ?>' alt=''>Retour</a>
                    <input type="submit" name="emploi" value="Valider" >
                     
                </div>
            </form>
        </div>
    </section><!--@whitespace
    --><aside>
        <?php
         include_once('sidebar-inscription.php');
        ?>
    </aside>
</div>