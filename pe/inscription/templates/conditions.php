<?php

/**
 * Affichage de la 3ème étape du parcours d'inscription : qualification de l'annonce
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

//si modif depuis espace perso récupération des infos de l'annonce déjà enregistrée
if (isset($_SESSION['utilisateur_id']) && $modifAnnonce==1) {
    //récupération des infos de l'annonce en cours de modification
    $queryInfosAnnonce = "SELECT * "
            . "FROM " . TBL_ANNONCES . " "
            . "WHERE annonce_idmetier='" . $_SESSION['emploi']['metierid'] . "' "
            . "AND annonce_idauteur=" . $_SESSION['utilisateur_id'] . " "
            . "AND annonce_etat='ACTIF'";
    //echo "<pre>";print_r($queryInfosAnnonce);echo "</pre>";
    $filledInfosAnnonce = $wpdb->get_row($queryInfosAnnonce, ARRAY_A);
    foreach ($filledInfosAnnonce as $key=>$val) {
        $_SESSION['annonce'][$key] = $val;
    }

    //récupération des emplois-repère liés à l'annonce en cours de dépot
    $queryRecupER = "select er.emploi_repere_id "
            . "from " . TBL_EMPLOI_REPERE . " er, " . TBL_ASSOC_ER_ANNONCE . " erannonce "
            . "where erannonce.annonce_id=" . $_SESSION['annonce']['annonce_id'] . " "
            . "and erannonce.emploi_repere_id=er.emploi_repere_id";
    $resEr = $wpdb->get_results($queryRecupER);
    foreach ($resEr as $dataEr) {
        $tabErAnnonce[] = $dataEr->emploi_repere_id;
    }
    $_SESSION['emploi']['erSelect']="";
    if (isset($tabErAnnonce) && !empty($tabErAnnonce)) {
        $_SESSION['emploi']['erSelect'] = implode(',', $tabErAnnonce);
    }
}
//@TODO si retour arrière depuis inscription => utilisation des valeurs qui ont été stockées en session

//récupération du libéllé du métier choisi 
$queryLibelle = "SELECT referentiel_libelle, referentiel_categorie
	              FROM ".TBL_METIERS." 
                WHERE referentiel_id=".$_SESSION['emploi']['metierid'];
$resLibelle=$wpdb->get_row($queryLibelle);    
$libelleMetier=$resLibelle->referentiel_libelle;
$metierCatId=$resLibelle->referentiel_categorie;
 
//02/2016 nouvelle classif : récupération des libellés des emplois-repère choisis 
if(!empty($_SESSION['emploi']['erSelect'])) {
    $queryErLibelle= "select emploi_repere_libelle "
                . "from ".TBL_EMPLOI_REPERE.""
                . " where emploi_repere_id in (".$_SESSION['emploi']['erSelect'].")";
    $resErlibelle=  $wpdb->get_results($queryErLibelle, ARRAY_A);
    $nbResERLib=$wpdb->num_rows;
    $cntLib=1;
    foreach ($resErlibelle as $dataErLib) {
        if ($cntLib == $nbResERLib) {
            $libelleER.=$dataErLib['emploi_repere_libelle'];
        } else {
            $libelleER.=$dataErLib['emploi_repere_libelle'] . ", ";
        }
        $cntLib++;
    }
        
}
//récupération des métiers de 1er niveau
$queryMetierI="SELECT referentiel_libelle, referentiel_id
	              FROM ".TBL_METIERS."
                WHERE referentiel_parent=''";
$resultat = $wpdb->get_results($queryMetierI, ARRAY_A);
$i=0;
foreach ($resultat as $data){
    //Premier niveau
    $arrFirstNiv[$i][0] = $data['referentiel_id'];
    $arrFirstNiv[$i][1] = $data['referentiel_libelle'];
    //echo $arrFirstNiv[$i][0].'<br>';
    $i++;
}

//si dépot d'une nouvelle annonce récupération infos utilisateur pour les associer à l'annonce en cours de dépot
    //si dépot depuis l'espace perso => récupération des infos du compte utilisateur existant
if(isset($_SESSION['utilisateur_id']) && $modifAnnonce!=1)  { 
    $queryInfoAuteur = "SELECT 
                                utilisateur_ville, 
                                utilisateur_codepostal, 
                                utilisateur_adresse, 
                                utilisateur_localisation
                            FROM " . TBL_UTILISATEURS . " 
                            WHERE utilisateur_id = " . $_SESSION['utilisateur_id'];
    $resultat = $wpdb->get_row($queryInfoAuteur, ARRAY_A);
    $_SESSION['annonce']['annonce_adresse'] = $resultat['utilisateur_adresse'];
    $_SESSION['annonce']['annonce_codepostal'] = $resultat['utilisateur_codepostal'];
    $_SESSION['annonce']['annonce_ville'] = $resultat['utilisateur_ville'];
    $_SESSION['annonce']['annonce_localisation'] = $resultat['utilisateur_localisation'];
}
    //si inscription en cours utilisation des valeurs en session
else if(!isset($_SESSION['utilisateur_id'])) {
    $_SESSION['annonce']['annonce_adresse'] = $_SESSION['inscription']['adresse'];
    $_SESSION['annonce']['annonce_codepostal'] = $_SESSION['inscription']['cpo'];
    $_SESSION['annonce']['annonce_ville'] = $_SESSION['inscription']['ville'];
    $_SESSION['annonce']['annonce_localisation'] = "";
}
?>
<div class="content-central-column">
    <?php
    if(!isset($_SESSION['utilisateur_id'])) {
        $step_active="conditions";
        include_once('parcours-navigation.php');
    }
    ?>
    <section id="qualification">
        <div class="bloc-content">
            <h1>Rédiger votre annonce</h1>
            <p>Plus votre offre est complète, plus vous aurez de chance de trouver
            <?php
            if($type_compte=="SAL") {
                 echo "un salarié intéressé"; 
            } else { 
                echo "un emploi"; 
            }
            ?>
            </p>
            <p class="field-required text-right">* Saisie obligatoire</p>
        </div>
        <div class='bloc-content-effect'></div>
        
        <div class="bloc-content">
            <?php
            //echo "<pre>";print_r($params);echo "</pre>";
            ?>
            <form id="conditions" action="/pe/inscription/conditions.php" method="post" onsubmit="return verifform()">
                
                <div class="qualif-intro">
                    <img src="<?php echo get_template_directory_uri() ?>/images/charte/img_cat_<?php echo $metierCatId;?>.png" />
                    <div>
                        <input type="hidden" name="metier" id="metier"
                               value="<?php echo $_SESSION['emploi']['metierid'].'|'.$libelleMetier; ?>"  />
                        <p>
                            <span class="text-bold">Métier choisi : </span>
                            <span class='text-upper text-bold color_cat_<?php echo $metierCatId; ?>'>
                                <?php echo $libelleMetier; ?>
                            </span></p>
                        <p>
                            <span class="text-bold">Emploi(s)-repère(s) : </span><span class='color_cat_<?php echo $metierCatId; ?>'>
                            <?php 
                            if(isset($libelleER)) {
                                echo  $libelleER;

                            } else {
                            ?>
                                Non indiqué
                                <?php
                            }
                            ?>
                            </span>
                        </p>
                    </div>
                </div>
                <div class='qualif-separator'></div>
                <div class="bloc-field-form" id="numagrement">
                    <label class="field-label" for="txtInputId01">Numéro d'agrément
                        <span class="tipHelp" title="L'obtention de l'agrément est validée par un document officiel.
                              Vous devez absolument fournir ce document aux parents employeurs lors de votre entretien.">
                            <img class="tipHelp" src="<?php echo get_template_directory_uri() ?>/images/pictos/tooltip.png"
                                 alt="tooltip" tilte="" />
                        </span>
                    </label>
                    <div class="field-value">
                        <input class="input-style" id="txtInputId01" name="agrement"
                               value="<?php
                               if (isset($_SESSION['submitted-values']['agrement'])) {
                                   echo $_SESSION['submitted-values']['agrement'];
                               } else if (isset($_SESSION['annonce']['annonce_agrement'])) {
                                   echo $_SESSION['annonce']['annonce_agrement'];
                               }
                               ?>" />

                    </div>
                    <?php
                    if (isset($tabDisplayError['agrement'])) {
                        ?>
                        <div class="error-valid">
                            <?php
                            echo $tabDisplayError['agrement'];
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="bloc-field-form" id="partedateagre">
                    <?php
                    if (isset($_SESSION['submitted-values']['dateagrement'])) {
                        $dateagrement = $_SESSION['submitted-values']['dateagrement'];
                    } else if (isset($_SESSION['annonce']['annonce_dateagrement'])) {
                        $dateagrement = convert_date($_SESSION['annonce']['annonce_dateagrement'], "/");
                    } else {
                        $dateagrement = '00/00/0000';
                    }
                    if ($dateagrement == '00/00/0000') {
                        $dateagrement = '';
                    }
                    ?>
                    <label class="field-label" for="dateagrement">Date d’obtention</label>
                    <div class="field-value">
                        <input class="input-style datepicker-full" id="dateagrement"  name="dateagrement"
                               value="<?php echo $dateagrement ?>" />
                    </div>
                    <?php
                    if (isset($tabDisplayError['dateagrement'])) {
                        ?>
                        <div class="error-valid">
                            <?php
                            echo $tabDisplayError['dateagrement'];
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <!-- garde partagée -->
                
                <?php
                if ($type_compte == "EMP") {
                    ?>
                    <div id="tr_nounou">
                        <div class="bloc-field-form">
                                <label class="field-label-inline">
                                    J'ai déja une garde d'enfant : <span class="field-required">*</span></label>
                                <div class="field-value-inline">
                                    <input type="radio" name="dejanounou" id="bt_dejanounou1" value="1" 
                                        <?php if((isset($_SESSION['annonce']['annonce_dejanounou'])
                                            && $_SESSION['annonce']['annonce_dejanounou']==1) ||
                                            (isset($_SESSION['submitted-values']['dejanounou']) &&
                                                $_SESSION['submitted-values']['dejanounou']==1)
                                            ) {
                                            echo "checked='checked'";
                                            
                                        } ?>
                                    />
                                    <label for="bt_dejanounou1" >oui</label>
                                    <input type="radio" name="dejanounou" id="bt_dejanounou2" value="0" 
                                        <?php if((isset($_SESSION['annonce']['annonce_dejanounou'])
                                            && $_SESSION['annonce']['annonce_dejanounou']==0) ||
                                            (isset($_SESSION['submitted-values']['dejanounou']) &&
                                                $_SESSION['submitted-values']['dejanounou']==0) ){
                                            echo "checked='checked'";

                                        } ?> />
                                    <label for="bt_dejanounou2" >non</label>
                                </div>
                                <?php
                                if (isset($tabDisplayError['dejanounou'])) {
                                    ?>
                                    <div class="error-valid">
                                        <?php
                                        echo $tabDisplayError['dejanounou'];
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div id="tr_famille">
                    <div class="bloc-field-form">
                            <label class="field-label-inline">J'ai déja une famille : <span class="field-required">*</span></label>
                            <div class="field-value-inline">
                                <input type="radio" name="dejafamille" id="bt_dejafamille1" value="1" 
                                    <?php if((isset($_SESSION['annonce']['annonce_dejafamille'])
                                        && $_SESSION['annonce']['annonce_dejafamille']==1) ||
                                        (isset($_SESSION['submitted-values']['dejafamille']) &&
                                                $_SESSION['submitted-values']['dejafamille']==1) ){
                                        echo "checked='checked'";
                                        
                                    } ?>
                                />
                                <label for="bt_dejafamille1" >oui</label>
                                <input type="radio" name="dejafamille" id="bt_dejafamille2" value="0" 
                                    <?php if((isset($_SESSION['annonce']['annonce_dejafamille'])
                                        && $_SESSION['annonce']['annonce_dejafamille']==0) ||
                                        (isset($_SESSION['submitted-values']['dejafamille']) &&
                                                $_SESSION['submitted-values']['dejafamille']==0) ){
                                        echo "checked='checked'"; } ?>
                                />
                                <label for="bt_dejafamille2" >non</label>
                            </div>
                            <?php
                            if (isset($tabDisplayError['dejafamille'])) {
                                ?>
                                <div class="error-valid">
                                    <?php
                                    echo $tabDisplayError['dejafamille'];
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                    </div>
                </div>
                <div id="cadregp" class="<?php echo $class;?>">
                    <div id="postalCodeBlock" class="postalCodeBlock">
                        <p>Validez le code postal et la ville de la famille</p>
                        <div class="bloc-field-form">
                            <div class="bloc-field-inline">
                                <label class="field-label" for="gp_codepostal">
                                    Code postal <span class="field-required">*</span></label>
                                <div class="field-value">
                                    <input type="text" class="input-style" name="gp_codepostal" id="gp_codepostal" 
                                           value="<?php 
                                            if(isset($_SESSION['submitted-values']['gp_codepostal'])) {
                                                echo $_SESSION['submitted-values']['gp_codepostal'];
                                            } else if(isset($_SESSION['annonce']['annonce_gp_codepostal']) ) {
                                                echo $_SESSION['annonce']['annonce_gp_codepostal'];
                                            }
                                            ?>" />
                                </div>
                                <?php
                                if(isset($tabDisplayError['gp_codepostal'])) {
                                    ?>
                                    <div class="error-valid">
                                        <?php
                                        echo $tabDisplayError['gp_codepostal'];
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            
                            <div class="bloc-field-inline">
                                <label class="field-label" for="gp_ville">Ville<span class="field-required">*</span></label>
                                <div class="field-value">
                                    <input type="text" class="input-style" name="gp_ville" id="gp_ville" 
                                           value="<?php 
                                           if(isset($_SESSION['submitted-values']['gp_ville'])) {
                                                echo $_SESSION['submitted-values']['gp_ville'];
                                            } else if (isset($_SESSION['annonce']['annonce_gp_ville'])) {
                                                echo $_SESSION['annonce']['annonce_gp_ville'];
                                            }
                                            ?>" />
                                </div>
                                <?php
                                if (isset($tabDisplayError['gp_ville'])) {
                                    ?>
                                    <div class="error-valid">
                                        <?php
                                        echo $tabDisplayError['gp_ville'];
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        
                        <div class="bloc-field-form">
                            <label class="field-label-inline">Localisation</label>
                            <div class="field-value-inline">
                                <div class="select-style">
                                    <select name="gp_localisation" id="gp_localisation">
                                        <?php
                                        if ((isset($_SESSION['annonce']['annonce_gp_localisation']) &&
                                            $_SESSION['annonce']['annonce_gp_localisation']== 'FRANCE') ||
                                            (isset($_SESSION['submitted-values']['gp_localisation']) &&  
                                            $_SESSION['submitted-values']['gp_localisation']== 'FRANCE')) {
                                            $checked = 'selected="selected"';
                                        } else {
                                            $checked = "";
                                        }
                                        echo '<option value="FRANCE" ' . $checked . '>France m&eacute;tropolitaine</option>';
                                        if ((isset($_SESSION['annonce']['annonce_gp_localisation']) &&
                                            $_SESSION['annonce']['annonce_gp_localisation'] == 'GUF') ||
                                            (isset($_SESSION['submitted-values']['gp_localisation']) &&
                                            $_SESSION['submitted-values']['gp_localisation']== 'GUF')) {
                                            $checked = 'selected="selected"';
                                        } else {
                                            $checked = "";
                                        }
                                        echo '<option value="GUF" ' . $checked . '>Guyane</option>';
                                        if ((isset($_SESSION['annonce']['annonce_gp_localisation']) &&
                                            $_SESSION['annonce']['annonce_gp_localisation'] == 'GLP') ||
                                            (isset($_SESSION['submitted-values']['gp_localisation']) &&
                                            $_SESSION['submitted-values']['gp_localisation']== 'GLP')) {
                                            $checked = 'selected="selected"';
                                        } else {
                                            $checked = "";
                                        }
                                        echo '<option value="GLP" ' . $checked . '>Guadeloupe</option>';
                                        if ((isset($_SESSION['annonce']['annonce_gp_localisation']) && 
                                            $_SESSION['annonce']['annonce_gp_localisation'] == 'MTQ') ||
                                            (isset($_SESSION['submitted-values']['gp_localisation']) &&
                                            $_SESSION['submitted-values']['gp_localisation']== 'MTQ')) {
                                            $checked = 'selected="selected"';
                                        } else {
                                            $checked = "";
                                        }
                                        echo '<option value="MTQ" ' . $checked . '>Martinique</option>';
                                        if ((isset($_SESSION['annonce']['annonce_gp_localisation']) &&
                                            $_SESSION['annonce']['annonce_gp_localisation'] == 'REU') ||
                                            (isset($_SESSION['submitted-values']['gp_localisation']) &&
                                            $_SESSION['submitted-values']['gp_localisation']== 'REU')) {
                                            $checked = 'selected="selected"';
                                        } else {
                                            $checked = "";
                                        }
                                        echo '<option value="REU" ' . $checked . '>R&eacute;union</option>';
                                        if ((isset($_SESSION['annonce']['annonce_gp_localisation']) &&
                                            $_SESSION['annonce']['annonce_gp_localisation'] == 'PYF') ||
                                            (isset($_SESSION['submitted-values']['gp_localisation']) &&
                                            $_SESSION['submitted-values']['gp_localisation']== 'REU')) {
                                            $checked = 'selected="selected"';
                                        } else {
                                            $checked = "";
                                        }
                                        echo '<option value="PYF" ' . $checked . '>Polyn&eacute;sie Fran&ccedil;aise</option>';
                                        ?>                                            
                                    </select>
                                </div>
                            </div>
                            <?php
                            if (isset($tabDisplayError['gp_localisation'])) {
                                ?>
                                <div class="error-valid">
                                    <?php
                                    echo $tabDisplayError['gp_localisation'];
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <input type="button" value="Valider l'adresse" onClick="showAddress2(); return false;" />
                        <div class="bloc-field-form">
                            <div id="message2" class="field-req field-value">
                            </div>
                            <div class="msg-error-valid"></div>
                        </div>
                    </div><!-- postal block -->
                    <div id="nbenfantsBloc">
                        <div class="bloc-field-form">
                            <label for="listNumOfChildren" class="field-label-inline">Nombre d'enfants gardés
                                <span class="field-required">*</span></label>
                            <div class="field-req field-value-inline">
                                <div class="select-style">
                                    <select name="annonce_nbenfgardes" id="listNumOfChildren" >
                                        <option value="0">Sélectionnez</option>
                                        <?php
                                        if ((isset($_SESSION['annonce']['annonce_nbenfgardes'])
                                            &&  $_SESSION['annonce']['annonce_nbenfgardes']== '1') ||
                                            (isset($_SESSION['submitted-values']['nbenfgardes']) &&
                                            $_SESSION['submitted-values']['nbenfgardes']== '1')) {
                                            $selected = ' selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        echo '<option value="1"' . $selected . '>1</option>';
                                        if ((isset($_SESSION['annonce']['annonce_nbenfgardes'])
                                            && $_SESSION['annonce']['annonce_nbenfgardes'] == '2') ||
                                            (isset($_SESSION['submitted-values']['nbenfgardes']) &&
                                            $_SESSION['submitted-values']['nbenfgardes']== '2')) {
                                            $selected = ' selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        echo '<option value="2"' . $selected . '>2</option>';
                                        if ((isset($_SESSION['annonce']['annonce_nbenfgardes'])
                                            && $_SESSION['annonce']['annonce_nbenfgardes'] == '3') ||
                                            (isset($_SESSION['submitted-values']['nbenfgardes']) &&
                                            $_SESSION['submitted-values']['nbenfgardes']== '3')) {
                                            $selected = ' selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        echo '<option value="3"' . $selected . '>3</option>';
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="msg-error-valid"></div>
                            <?php
                            if (isset($tabDisplayError['nbenfgardes'])) {
                                ?>
                                <div class="error-valid">
                                    <?php
                                    echo $tabDisplayError['nbenfgardes'];
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div><!-- nombre d'enfants -->
                  								

                    <div id="ageBlock" class="ageBlock">
                        <div class="bloc-field-form">
                            <label class="field-label-inline">Age des enfants gardés</label>
                            <div class="field-value-inline ageList">
                                <div>
                                    <input type="checkbox" name="agenfants1" id="agenfants1" value="012" 
                                        <?php if((isset($_SESSION['annonce']['annonce_agenfants1'])
                                            && $_SESSION['annonce']['annonce_agenfants1'] == '012') ||
                                            (isset($_SESSION['submitted-values']['agenfants1']) &&
                                            $_SESSION['submitted-values']['agenfants1']== '012')) {
                                            echo 'checked="checked"';
                                            
                                        } ?>
                                    />
                                    <label for="agenfants1">De 0 à 12 mois</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="agenfants2" id="agenfants2" value="1218" 
                                        <?php if((isset($_SESSION['annonce']['annonce_agenfants2'])
                                            && $_SESSION['annonce']['annonce_agenfants2'] == '1218') ||
                                            (isset($_SESSION['submitted-values']['agenfants2']) &&
                                            $_SESSION['submitted-values']['agenfants2']== '1218')) {
                                            echo 'checked="checked"';
                                            
                                        } ?>
                                    />
                                    <label for="agenfants2" >De 12 à 18 mois</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="agenfants3" id="agenfants3" value="1836"
                                        <?php if((isset($_SESSION['annonce']['annonce_agenfants3'])
                                            && $_SESSION['annonce']['annonce_agenfants3'] == '1836') ||
                                            (isset($_SESSION['submitted-values']['agenfants31']) &&
                                            $_SESSION['submitted-values']['agenfants3']== '1836')){
                                                echo 'checked="checked"';
                                                
                                            } ?>
                                    />
                                    <label for="agenfants3" >De 18 à 36 mois</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="agenfants4" id="agenfants4" value="36" 
                                        <?php if((isset($_SESSION['annonce']['annonce_agenfants41'])
                                            && $_SESSION['annonce']['annonce_agenfants4'] == '36') ||
                                            (isset($_SESSION['submitted-values']['agenfants4']) &&
                                            $_SESSION['submitted-values']['agenfants4']== '36')) {
                                            echo 'checked="checked"'; }
                                            ?>
                                    />
                                    <label for="agenfants4" >De 3 à 6 ans</label> 
                                </div>
                                <div>
                                    <input type="checkbox" name="agenfants5" id="agenfants5" value="68" 
                                        <?php if((isset($_SESSION['annonce']['annonce_agenfants5'])
                                            && $_SESSION['annonce']['annonce_agenfants5'] == '68') ||
                                            (isset($_SESSION['submitted-values']['agenfants5']) &&
                                            $_SESSION['submitted-values']['agenfants5']== '68')){
                                            echo 'checked="checked"';
                                            
                                        } ?>
                                    />
                                    <label for="agenfants5" >De 6 à 8 ans</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="agenfants6" id="agenfants6" value="8" 
                                        <?php if((isset($_SESSION['annonce']['annonce_agenfants6'])
                                            && $_SESSION['annonce']['annonce_agenfants6'] == '8') ||
                                            (isset($_SESSION['submitted-values']['agenfants6']) &&
                                            $_SESSION['submitted-values']['agenfants6']== '8')) {
                                            echo 'checked="checked"'; }
                                            ?>
                                    />
                                    <label for="agenfants6" >Plus de 8 ans</label>
                                </div>
                            </div>
                        </div>
                    </div><!-- age des enfants  -->
                    
                </div><!-- cadre gp -->
                <!-- fin garde partagée -->

                <div class="bloc-field-form">
                    <label class="field-label" for="experience">
                        <?php
                        if ($type_compte == 'SAL') {
                            echo "Expérience professionnelle";
                        } else {
                            echo "Expérience demandée";
                        }
                        ?>
                        <span class="field-required">*</span></label>
                    <div class="field-req field-value">
                        <div class="select-style">
                            <select id="experience" name="experience" >
                                <option value="0">Sélectionnez un niveau d'expérience</option>
                                <?php
                                if ((isset($_SESSION['annonce']['annonce_experience']) &&
                                    $_SESSION['annonce']['annonce_experience'] == 'M5') ||
                                    (isset($_SESSION['submitted-values']['experience']) &&
                                    $_SESSION['submitted-values']['experience']== 'M5')) {
                                    $selected = ' selected';
                                } else {
                                    $selected = '';
                                }
                                echo '<option value="M5"' . $selected . '>moins de 2 ans</option>';
                                if ((isset($_SESSION['annonce']['annonce_experience']) &&
                                    $_SESSION['annonce']['annonce_experience'] == 'E510')  ||
                                    (isset($_SESSION['submitted-values']['experience']) &&
                                     $_SESSION['submitted-values']['experience']== 'E510')) {
                                    $selected = ' selected';
                                } else {
                                    $selected = '';
                                }
                                echo '<option value="E510"' . $selected . '>2 &agrave; 5 ans</option>';
                                if ((isset($_SESSION['annonce']['annonce_experience']) &&
                                    $_SESSION['annonce']['annonce_experience'] == 'P10') ||
                                    (isset($_SESSION['submitted-values']['experience']) &&
                                     $_SESSION['submitted-values']['experience']== 'P10')) {
                                    $selected = ' selected';
                                } else {
                                    $selected = '';
                                }
                                echo '<option value="P10"' . $selected . '>plus de 5 ans</option>';
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="msg-error-valid"></div>
                    <?php
                    if (isset($tabDisplayError['experience'])) {
                        ?>
                        <div class="error-valid">
                            <?php
                            echo $tabDisplayError['experience'];
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class='qualif-separator'></div>
                <div class="bloc-field-form bloc_desc_annonce">
                    <p class="text-bold">
                        <img src="<?php echo get_template_directory_uri() ?>/images/pictos/picto_redac.png" alt="" />Votre annonce
                    </p>
                    <p>Rédigez votre annonce en précisant toutes les 
                        informations que vous jugez utiles (horaires souhaitées, 
                        diplômes, formations etc..) – saisie limitée à 255 caractères
                    </p>
                    <div class="field-value">
                        <textarea name="particularites" id="particularites" rows="5" cols="40" maxlength="255"><?php
                            if(isset($params['particularites'])) {
                                echo $params['particularites'];
                            } else if(isset($_SESSION['annonce']['annonce_description'])) {
                                echo $_SESSION['annonce']['annonce_description'];
                            }
                        ?></textarea> 
                    </div>
                    <?php
                    if (isset($tabDisplayError['particularites'])) {
                        ?>
                        <div class="error-valid">
                            <?php
                            echo $tabDisplayError['particularites'];
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class='qualif-separator'></div>
                <div class="bloc-field-form">
                    <label class="field-label" for="tauxhoraire">
                        <?php
                        if ($type_compte == 'SAL') {
                            echo "Taux horaires brut souhaité ";
                        } else {
                            echo "Taux brut proposé <br>(hors Cesu, hors ancienneté) ";
                        }
                        ?>
                        <span class="field-required">*</span> €/heure
                        <span class="tipHelp"
                              title="A compter du 1er janvier 2017, le SMIC est porté à 9,76 € bruts par heure pour
                              le salarié du particulier employeur hors Cesu, hors ancienneté">
                            <img class="tipHelp" src="<?php echo get_template_directory_uri() ?>/images/pictos/tooltip.png"
                                 alt="tooltip" tilte="" />
                        </span>
                    </label>
                    <div class="field-req field-value field-check">
                        <input type="text" name="tauxhoraire" id="tauxhoraire" class="input-style input-mini"
                               value="<?php 
                                if(isset($_SESSION['submitted-values']['tauxhoraire'])) {
                                    echo $_SESSION['submitted-values']['tauxhoraire'];
                                }
                                else if(isset($_SESSION['annonce']['annonce_tauxhoraire'])) {
                                   echo $_SESSION['annonce']['annonce_tauxhoraire'];
                                }
                               ?>"
                        />
                    </div>
                    <div class="msg-error-valid"></div>
                    <?php
                    if (isset($tabDisplayError['tauxhoraire'])) {
                        ?>
                        <div class="error-valid">
                            <?php
                            echo $tabDisplayError['tauxhoraire'];
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                
                <div class="bloc-field-form">
                    <div class="bloc-field-inline">
                        <label class="field-label" for="dateprisefonction">
                            <?php
                            if ($type_compte == 'SAL') {
                                echo "Date de disponibilité";
                            } else {
                                echo "Date de prise de poste souhaitée";
                            }
                            ?>
                            <span class="field-required">*</span>
                        </label>
                        <div class="field-req field-value">
                            <?php
                            if(isset($_SESSION['submitted-values']['dateprisefonction'])) {
                               $dateprisefonction = $_SESSION['submitted-values']['dateprisefonction'];
                            } else if (isset($_SESSION['annonce']['annonce_dateprisefonction'])) {
                                $dateprisefonction = convert_date($_SESSION['annonce']['annonce_dateprisefonction'], '/');
                            } else { 
                                $dateprisefonction = date("d/m/Y");
                            }
                            ?>
                            <input id="dateprisefonction" name="dateprisefonction" type="text"
                                   class="input-style input-mini datepicker-full" value="<?php echo $dateprisefonction;?>" >
                        </div>
                        <div class="msg-error-valid"></div>
                        <?php
                        if (isset($tabDisplayError['dateprisefonction'])) {
                            ?>
                            <div class="error-valid">
                                <?php
                                echo $tabDisplayError['dateprisefonction'];
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                
                    <div class="bloc-field-inline">
                        <label class="field-label" for="durehebdojs">Durée hebdomadaire (h/semaine)</label>
                        <div class="field-check field-value">
                            <input type="text" name="durehebdojs" id="durehebdojs" class="input-style input-mini"
                                   value="<?php 
                                   if(isset($_SESSION['submitted-values']['durehebdojs'])) {
                                        echo $_SESSION['submitted-values']['durehebdojs'];
                                   } else if (isset($_SESSION['annonce']['annonce_dureehebdomadaire'])) {
                                        echo $_SESSION['annonce']['annonce_dureehebdomadaire'];
                                   }
                                   ?>"/>
                            heure/semaine
                        </div>
                        <div class="msg-error-valid"></div>
                        <?php
                        if (isset($tabDisplayError['durehebdojs'])) {
                            ?>
                            <div class="error-valid">
                                <?php
                                echo $tabDisplayError['durehebdojs'];
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div id="enfants">
                    <div class='qualif-separator'></div>
                    <p class="text-bold">Accueil de l'enfant</p>
                    <div class="childcareSelect bloc-field-form">
                        <div>
                            <label class="field-label-inline" for="lstLessThanTwoYears">Moins de 2 ans (Crèche)</label>
                            <div class="field-value-inline">
                                <div class="select-style">
                                    <select name="nbenfants1" id="lstLessThanTwoYears" >
                                        <?php
                                        if ((isset( $_SESSION['annonce']['annonce_nbenfants1']) &&
                                            $_SESSION['annonce']['annonce_nbenfants1'] == '0') ||
                                            (isset($_SESSION['submitted-values']['nbenfants1']) &&
                                            $_SESSION['submitted-values']['nbenfants1']== '0'))  {
                                            $selected = ' selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        echo '<option value="0" ' . $selected . '>0</option>';
                                        if ((isset($_SESSION['annonce']['annonce_nbenfants1']) && 
                                            $_SESSION['annonce']['annonce_nbenfants1'] == '1') ||
                                            (isset($_SESSION['submitted-values']['nbenfants1']) &&
                                            $_SESSION['submitted-values']['nbenfants1']== '1')) {
                                            $selected = ' selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        echo '<option value="1" ' . $selected . '>1</option>';
                                        if ((isset($_SESSION['annonce']['annonce_nbenfants1']) &&
                                            $_SESSION['annonce']['annonce_nbenfants1'] == '2') ||
                                            (isset($_SESSION['submitted-values']['nbenfants1']) &&
                                            $_SESSION['submitted-values']['nbenfants1']== '2'))  {
                                            $selected = ' selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        echo ' <option value="2" ' . $selected . '>2</option>';
                                        if ((isset($_SESSION['annonce']['annonce_nbenfants1']) &&
                                            $_SESSION['annonce']['annonce_nbenfants1'] == '3') ||
                                            (isset($_SESSION['submitted-values']['nbenfants1']) &&
                                            $_SESSION['submitted-values']['nbenfants1']== '3')) {
                                            $selected = ' selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        echo ' <option value="3" ' . $selected . '>3</option>';
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php
                            if (isset($tabDisplayError['nbenfants1'])) {
                                ?>
                                <div class="error-valid">
                                    <?php
                                    echo $tabDisplayError['nbenfants1'];
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div> 
                        <div>
                            <label for="listTwoToFive" class="field-label-inline">De 2 à 5 ans (Maternel)</label>
                            <div class="field-value-inline">
                                <div class="select-style">
                                    <select name="nbenfants2" id="listTwoToFive" >
                                        <?php
                                        if ((isset($_SESSION['annonce']['annonce_nbenfants2']) && 
                                            $_SESSION['annonce']['annonce_nbenfants2'] == '0') ||
                                            (isset($_SESSION['submitted-values']['nbenfants2']) &&
                                            $_SESSION['submitted-values']['nbenfants2']== '0')) {
                                            $selected = ' selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        echo '<option value="0" ' . $selected . '>0</option>';
                                        if ((isset($_SESSION['annonce']['annonce_nbenfants2']) && 
                                            $_SESSION['annonce']['annonce_nbenfants2'] == '1') ||
                                            (isset($_SESSION['submitted-values']['nbenfants2']) &&
                                            $_SESSION['submitted-values']['nbenfants2']== '1')) {
                                            $selected = ' selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        echo '<option value="1" ' . $selected . '>1</option>';
                                        if ((isset($_SESSION['annonce']['annonce_nbenfants2']) && 
                                            $_SESSION['annonce']['annonce_nbenfants2'] == '2') ||
                                            (isset($_SESSION['submitted-values']['nbenfants2']) &&
                                            $_SESSION['submitted-values']['nbenfants2']== '2')) {
                                            $selected = ' selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        echo ' <option value="2" ' . $selected . '>2</option>';
                                        if ((isset($_SESSION['annonce']['annonce_nbenfants2']) && 
                                            $_SESSION['annonce']['annonce_nbenfants2'] == '3') ||
                                            (isset($_SESSION['submitted-values']['nbenfants2']) &&
                                            $_SESSION['submitted-values']['nbenfants2']== '3')) {
                                            $selected = ' selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        echo ' <option value="3" ' . $selected . '>3</option>';
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php
                            if (isset($tabDisplayError['nbenfants2'])) {
                                ?>
                                <div class="error-valid">
                                    <?php
                                    echo $tabDisplayError['nbenfants2'];
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div>
                            <label for="lstSixToEight" class="field-label-inline">De 6 à 8 ans (Primaire)</label>
                            <div class="field-value-inline">
                                <div class="select-style">
                                <select name="nbenfants3" id="lstSixToEight" >
                                    <?php
                                    if ((isset($_SESSION['annonce']['annonce_nbenfants3']) &&
                                        $_SESSION['annonce']['annonce_nbenfants3'] == '0') ||
                                            (isset($_SESSION['submitted-values']['nbenfants3']) &&
                                            $_SESSION['submitted-values']['nbenfants3']== '0')) {
                                        $selected = ' selected="selected"';
                                    } else {
                                        $selected = '';
                                    }
                                    echo '<option value="0" ' . $selected . '>0</option>';
                                    if ((isset($_SESSION['annonce']['annonce_nbenfants3']) &&
                                        $_SESSION['annonce']['annonce_nbenfants3'] == '1') ||
                                            (isset($_SESSION['submitted-values']['nbenfants3']) &&
                                            $_SESSION['submitted-values']['nbenfants3']== '1')) {
                                        $selected = ' selected="selected"';
                                    } else {
                                        $selected = '';
                                    }
                                    echo '<option value="1" ' . $selected . '>1</option>';
                                    if ((isset($_SESSION['annonce']['annonce_nbenfants3']) &&
                                        $_SESSION['annonce']['annonce_nbenfants3'] == '2') ||
                                            (isset($_SESSION['submitted-values']['nbenfants3']) &&
                                            $_SESSION['submitted-values']['nbenfants3']== '2')) {
                                        $selected = ' selected="selected"';
                                    } else {
                                        $selected = '';
                                    }
                                    echo ' <option value="2" ' . $selected . '>2</option>';
                                    if ((isset($_SESSION['annonce']['annonce_nbenfants3']) &&
                                        $_SESSION['annonce']['annonce_nbenfants3'] == '3') ||
                                            (isset($_SESSION['submitted-values']['nbenfants3']) &&
                                            $_SESSION['submitted-values']['nbenfants3']== '3')) {
                                        $selected = ' selected="selected"';
                                    } else {
                                        $selected = '';
                                    }
                                    echo ' <option value="3" ' . $selected . '>3</option>';
                                    ?>
                                </select>
                                </div>
                            </div>
                            <?php
                            if (isset($tabDisplayError['nbenfants3'])) {
                                ?>
                                <div class="error-valid">
                                    <?php
                                    echo $tabDisplayError['nbenfants3'];
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div>
                            <label for="lstBeyondEightYears" class="field-label-inline">Au delà de 8 ans</label>
                            <div class="field-value-inline">
                                <div class="select-style">
                                    <select name="nbenfants4" id="lstBeyondEightYears" class="simpleSelect simpleSelect07  unit">
                                        <?php
                                        if ((isset($_SESSION['annonce']['annonce_nbenfants4']) &&
                                            $_SESSION['annonce']['annonce_nbenfants4'] == '0') ||
                                            (isset($_SESSION['submitted-values']['nbenfants4']) &&
                                            $_SESSION['submitted-values']['nbenfants4']== '0')) {
                                            $selected = ' selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        echo '<option value="0" ' . $selected . '>0</option>';
                                        if ((isset($_SESSION['annonce']['annonce_nbenfants4']) &&
                                            $_SESSION['annonce']['annonce_nbenfants4'] == '1') ||
                                            (isset($_SESSION['submitted-values']['nbenfants4']) &&
                                            $_SESSION['submitted-values']['nbenfants4']== '1')) {
                                            $selected = ' selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        echo '<option value="1" ' . $selected . '>1</option>';
                                        if ((isset($_SESSION['annonce']['annonce_nbenfants4']) && 
                                            $_SESSION['annonce']['annonce_nbenfants4'] == '2') ||
                                            (isset($_SESSION['submitted-values']['nbenfants4']) &&
                                            $_SESSION['submitted-values']['nbenfants4']== '2')) {
                                            $selected = ' selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        echo ' <option value="2" ' . $selected . '>2</option>';
                                        if ((isset($_SESSION['annonce']['annonce_nbenfants4']) &&
                                            $_SESSION['annonce']['annonce_nbenfants4'] == '3') ||
                                            (isset($_SESSION['submitted-values']['nbenfants4']) &&
                                            $_SESSION['submitted-values']['nbenfants4']== '3')) {
                                            $selected = ' selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        echo ' <option value="3" ' . $selected . '>3</option>';
                                        ?>
                                    </select>
                                </div>

                            </div>
                            <?php
                            if (isset($tabDisplayError['nbenfants4'])) {
                                ?>
                                <div class="error-valid">
                                    <?php
                                    echo $tabDisplayError['nbenfants4'];
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div><!-- bloc accueil enfant -->
                <div class='qualif-separator'></div>
                <div class="addContact">
                    <p class="text-bold">Adresse du lieu de travail <span class="field-required">*</span></p> 
                    <p>
                        L’adresse du lieu de travail renseignée ci-après par défaut est celle de votre lieu de résidence.
                        Si l’adresse du lieu de travail est différente de votre lieu de résidence, nous vous remercions de la modifier.
                    </p>
                    <div class="bloc-field-form">
                        <label for="adresse" class="field-label">Adresse</label>
                        <div class="field-value">
                            <input type="text" name="adresse" id="adresse" class="input-style" 
                                   value="<?php 
                                    if(isset($_SESSION['submitted-values']['adresse'])) {
                                       echo $_SESSION['submitted-values']['adresse'];
                                    } else if (isset($_SESSION['annonce']['annonce_adresse'])) {
                                        echo $_SESSION['annonce']['annonce_adresse'];
                                    }?>"
                            />
                        </div>
                        <?php
                            if (isset($tabDisplayError['adresse'])) {
                                ?>
                                <div class="error-valid">
                                    <?php
                                    echo $tabDisplayError['adresse'];
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                    </div>

                    <div class="bloc-field-form">
                        <div class="bloc-field-inline">
                            <label for="codepostal" class="field-label">Code postal <span class="field-required">*</span></label>
                            <div class="field-req field-value">
                                <input type="text" name="codepostal" id="codepostal" class="input-style" 
                                       value="<?php 
                                        if(isset($_SESSION['submitted-values']['codepostal'])) {
                                            echo $_SESSION['submitted-values']['codepostal'];
                                        } else if (isset($_SESSION['annonce']['annonce_codepostal'])) {
                                            echo $_SESSION['annonce']['annonce_codepostal'];
                                        }?>"
                                />
                            </div>
                            <div class="msg-error-valid"></div>
                            <?php
                            if (isset($tabDisplayError['codepostal'])) {
                                ?>
                                <div class="error-valid">
                                    <?php
                                    echo $tabDisplayError['codepostal'];
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="bloc-field-inline">
                            <label for="ville" class="field-label">Ville</label>
                            <div class="field-value">
                                <input type="text" name="ville" id="ville" class="input-style" 
                                       value="<?php 
                                        if(isset($_SESSION['submitted-values']['ville'])) {
                                            echo $_SESSION['submitted-values']['ville'];
                                        } else if (isset($_SESSION['annonce']['annonce_ville'])) {
                                            echo $_SESSION['annonce']['annonce_ville'];
                                        }?>"
                                />
                            </div>
                            <?php
                            if (isset($tabDisplayError['ville'])) {
                                ?>
                                <div class="error-valid">
                                    <?php
                                    echo $tabDisplayError['ville'];
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    
                    <p>
                        La validation de l’adresse du lieu de travail est obligatoire.
                        Une fois que vous l’aurez validé,  vous devez sélectionner l’adresse affichée 
                        pour pouvoir finaliser le dépôt de votre annonce
                    </p>
                    <input type="button" value="Valider l'adresse du lieu de travail" onClick="showAddress(); return false;" />
                    <?php      
                    if($type_compte=='EMP'){ 
                        ?>
                        <p id="infoassmat" >Lors de l'embauche, I'assistante maternelle doit vous procurer
                            le document officiel validant son agrément</p>
                    <?php
                    }
                    ?>
                    <div class="bloc-field-form">
                        <div id="message" class="field-req field-value">
                        </div>
                        <div class="msg-error-valid"></div>
                    </div>
                </div>
                
                <div class="bloc-submit-form bloc-submit-inscription">
                    <?php
                    //on est dans la modification d'annonce via l'espace perso
                    if(isset($_SESSION['utilisateur_id']) && $modifAnnonce==1) {
                       $lienRetour = "/pe/espace-pe/annonces.php";
                    } else {
                        // on est dans le parcours d'inscription
                        // ou dans l'ajout d'annonce via l'espace perso
                        $lienRetour = "/pe/inscription/emploi.php";
                    }
                    ?>
                    <a href='<?php echo $lienRetour; ?>' title=''>Retour</a>
                    <p id="valider">Merci de bien sélectionner votre adresse pour continuer</p>
                    <input type="submit" name="emploi" value="Valider" id="conditions-submit" />
                     
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

<?php $key = getKey();?>

<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=<?php echo $key;?>" type="text/javascript"></script>

<script>
    //pour la vérification du taux horaire
    function veriftaux(valeur) {
        var valMetier=jQuery('#metier').val();
        var selectedmetier= valMetier.split('|');
        if (selectedmetier[0]=='4') {
            if (valeur < 2.53){
                alert("Veuillez saisir un taux horaire brut minimum de 2.53 €");
               
            } else if (valeur > 50) {
                alert("Merci de ne pas saisir de taux horaire brut dépassant 50 €");
                
            }
        }  else  {
            if (valeur < 9.76){
                alert("Veuillez saisir un taux horaire brut minimum de 9.76 €");
               
            } else if (valeur > 50) {
                alert("Merci de ne pas saisir de taux horaire brut dépassant 50 €");
                
            }
        }
    }
    
    //pour la validation de l'adresse
    function selectAdresse() {
        jQuery("#conditions-submit").show();
        jQuery("#valider").hide();
    }
    
    //<![CDATA[
    if (GBrowserIsCompatible()) {
        // ====== Create a Client Geocoder ======
        var geo = new GClientGeocoder();
        // ====== Array for decoding the failure codes ======
        var reasons=[];
        reasons[G_GEO_SUCCESS]            = "Success";
        reasons[G_GEO_MISSING_ADDRESS]    = "L'adresse est manquante.";
        reasons[G_GEO_UNKNOWN_ADDRESS]    = "Adresse inconnu:  Aucune correspondance géographique n'a été trouvée. Merci de n'indiquer que le nom de votre rue.";
        reasons[G_GEO_UNAVAILABLE_ADDRESS]= "Unavailable Address:  The geocode for the given address cannot be returned due to legal or contractual reasons.";
        reasons[G_GEO_BAD_KEY]            = "Une problème de clé a été détécté. Contactez un administrateur";
        reasons[G_GEO_TOO_MANY_QUERIES]   = "Trop de demande de vérification d'adresse ont été faites aujourd'hui.";
        reasons[G_GEO_SERVER_ERROR]       = "Problème lié au serveur, veuillez réassayer dans quelques secondes.";

        // ====== Geocoding ======
        function showAddress() {
            var codepostal = document.getElementById("codepostal").value;
            if(codepostal=='') {
                codepostal ='00';
            }
            var ville = document.getElementById("ville").value;
            var adresse = document.getElementById("adresse").value;
            var search = ''+adresse+', '+codepostal+' '+ville+'';
            // ====== Perform the Geocoding ======
            geo.getLocations(search, function (result) {
                // If that was successful
                if (result.Status.code == G_GEO_SUCCESS) {
                    var divMessageContent = '';
                    // Loop through the results, placing markers
                    var resultats= "";
                    for (var i=0; i<result.Placemark.length; i++) {
                        var p = result.Placemark[i].Point.coordinates;
                        var marker = new GMarker(new GLatLng(p[1],p[0]));
                        if(i==0){
                            resultats += '<input id="geoadresse_'+ i +'" type="radio" name="geoadresse" value="'+marker.getPoint().lat()+"/"+marker.getPoint().lng()+'" onClick="selectAdresse()"><label for="geoadresse_'+ i +'" ><span>'+ result.Placemark[i].address +'</span></label>';
                        } else {
                            resultats += '<input id="geoadresse_'+ i +'" type="radio" name="geoadresse" value="'+marker.getPoint().lat()+"/"+marker.getPoint().lng()+'" onClick="selectAdresse()"><label for="geoadresse_'+ i +'"><span>'+ result.Placemark[i].address +'</span></label>';
                        }
                    }
                    divMessageContent += resultats+'<p class="text-italic">Si votre adresse ne s\'affiche pas, s&eacute;lectionnez le code postal.</p>';
                    divMessage = jQuery('#message');
                    divMessage.html (divMessageContent);


                }
                // ====== Decode the error status ======
                else {
                    var reason="Code "+result.Status.code;
                    if (reasons[result.Status.code]) {
                      reason = reasons[result.Status.code]
                    }
                    alert('Impossible de trouver "'+search+ '" ' + reason);
                }
            });
        }

        function showAddress2() {
            var gp_codepostal = document.getElementById("gp_codepostal").value;
            if(gp_codepostal=='') {
                gp_codepostal ='00';
            }
            var gp_ville = document.getElementById("gp_ville").value;
            var gp_localisation = document.getElementById("gp_localisation").value;
            switch(gp_localisation){
                case 'FRANCE':
                    gp_localisation='France';
                break;
                case 'GLP':
                    gp_localisation='Guadeloupe';
                break;
                case 'GUF':
                    gp_localisation='Guyane';
                break;
                case 'MTQ':
                    gp_localisation='Martinique';
                break;
                case 'PYF':
                    gp_localisation='Polynésie Française';
                break;
                case 'REU':
                    gp_localisation='Réunion';
                break;
            }
            var search = ''+gp_codepostal+' '+gp_ville+', '+gp_localisation+'';
            // ====== Perform the Geocoding ======
            geo.getLocations(search, function (result) {
                // If that was successful
                if (result.Status.code == G_GEO_SUCCESS) {
                    var resultats= "";
                    resultats +='';
                    // Loop through the results, placing markers
                    for (var i=0; i<result.Placemark.length; i++) {
                        var p = result.Placemark[i].Point.coordinates;
                        var marker = new GMarker(new GLatLng(p[1],p[0]));
                        if(i==0){
                            resultats += '<input id="geoadresse2_'+ i +'" type="radio" name="geoadresse2"  value="'+marker.getPoint().lat()+'/'+marker.getPoint().lng()+'" /><label for="geoadresse2_'+ i +'" ><span>'+result.Placemark[i].address +'</span></label>';
                        } else {
                            resultats += '<input id="geoadresse2_'+ i +'" type="radio" name="geoadresse2"  value="'+marker.getPoint().lat()+'/'+marker.getPoint().lng()+'" /><label for="geoadresse2_'+ i +'" ><span>'+result.Placemark[i].address +'</span></label>';
                        }
                    }
                    resultats += '<p class="text-italic">Si votre adresse ne s\'affiche pas, sélectionnez le code postal.</p>';
                    document.getElementById("message2").innerHTML = resultats;
                }
                // ====== Decode the error status ======
                else {
                    var reason="Code "+result.Status.code;
                    if (reasons[result.Status.code]) {
                        reason = reasons[result.Status.code]
                    }
                    alert('Impossible de trouver "'+search+ '" ' + reason);
                }
            });
        }
    }
    // display a warning if the browser was not compatible
    else {
        alert("Désolé, google map n'est pas compatible avec votre naviguateur");
    }
    //]]>
    
    /*function resetCadreGP() {
        
        //les options sélectionnées sont vidés
        jQuery("#cadregp input[type=checkbox]").each(
            function () {
                jQuery(this).prop("checked", false);
            }
        );
        jQuery('#gp_localisation option[value="FRANCE"]').prop('selected', true);
        jQuery('#listNumOfChildren option[value="0"]').prop('selected', true);
        jQuery("#cadregp input[type=text]").each(
            function () {
                jQuery(this).val('');
            }
        );
    }*/
    function showcadregpemp() {
        if(jQuery("#bt_dejanounou1")) {
            if (jQuery("#bt_dejafamille1").is(':checked') && jQuery("#bt_dejanounou1").is(':checked')){
                alert("Veuillez vérifier votre saisie, car vous ne pouvez pas avoir besoin de nos services si vous avez déjà une garde d’enfant et une famille.");
            }
        }
        //remise à zéro
        //resetCadreGP();
        
        //affichage des blocs concernés
        jQuery("#nbenfantsBloc").show();
        jQuery("#ageBlock").show();

    }
    
    function showcadregp(baliseId) {
        if(jQuery("#bt_dejanounou1")) {
            if (jQuery("#bt_dejafamille1").is(':checked') && jQuery("#bt_dejanounou1").is(':checked')){
                alert("Veuillez vérifier votre saisie, car vous ne pouvez pas avoir besoin de nos services si vous avez déjà une garde d’enfant et une famille.");
            }
        }
        //remise à zéro
        //resetCadreGP();

        //affichage des blocs en fonction du choix fait
        if (baliseId==0){
            <?php
            if ($type_compte=="EMP"){
                echo '
                jQuery("#postalCodeBlock").hide()';
            }
            else if ($type_compte=="SAL"){
                echo ' jQuery("#ageBlock").show();'
                . 'jQuery("#nbenfantsBloc").hide();'
                        . 'jQuery("#postalCodeBlock").hide();';
            }
            ?>
        
        } else if (baliseId==1){
            <?php
            if($type_compte=="EMP"){
              echo '
                jQuery("#postalCodeBlock").show()';
            } else if($type_compte=="SAL"){
               echo 'jQuery("#postalCodeBlock").show();'
                        . 'jQuery("#nbenfantsBloc").show();'
                        . 'jQuery("#ageBlock").show();';
            }
            ?>
        
        }
    }
    
    jQuery('#tr_famille input[name=dejafamille]:radio').click(function() {
	var val = jQuery(this).val();
	showcadregp(val);
    });

    jQuery('#tr_nounou input[name=dejanounou]:radio').click(function() {
	//var val = jQuery(this).val();
	showcadregpemp();
    });
    
    
    
    
    
    
    function checkAssMat() {
        <?php
        if ($type_compte == "SAL") {
            echo "
                jQuery('#numagrement').show();
                jQuery('#partedateagre').show();
                ";
        } else if ($type_compte == "EMP") {
            echo '
                jQuery("#infoassmat").show();
                ';
        }
        ?>
        //bloc accueil des enfants
        jQuery("#enfants").show(); 
    }
    
    function checkGP() {
        <?php
        //affichage question deja famille ? et deja nounou ?
        if($type_compte == "EMP"){
            echo '
                jQuery("#tr_nounou").show();
              ';
        }
        ?>
        jQuery("#tr_famille").show();
        //affichage du cadre permettant de renseigner des infos sur la GP
        jQuery("#cadregp").show();
        
        //dans cecadre affichage conditionnel de certains blocs
        <?php
        if($type_compte=="SAL"){
            if (isset($_SESSION['annonce']['annonce_dejafamille'])){
                if ($_SESSION['annonce']['annonce_dejafamille']==0) {
                  echo 'jQuery("#ageBlock").show();';
                } else if ($_SESSION['annonce']['annonce_dejafamille']==1){
                  echo 'jQuery("#postalCodeBlock").show();'
                    . 'jQuery("#nbenfantsBloc").show();'
                    . 'jQuery("#ageBlock").show();';
                }
            }
        } else if ($type_compte=="EMP") {
            if (isset($_SESSION['annonce']['annonce_dejafamille'])){
                if ($_SESSION['annonce']['annonce_dejafamille']==1){
                    echo 'jQuery("#postalCodeBlock").show();';
                }
            }
            if (isset($_SESSION['annonce']['annonce_dejanounou'])) {
                if ($_SESSION['annonce']['annonce_dejanounou']==0 ||
                      $_SESSION['annonce']['annonce_dejanounou']==1) {
                    echo '
                    jQuery("#nbenfantsBloc").show();
                    jQuery("#ageBlock").show();';
                }
            }
        }
        ?>
    }
    
    window.onload=function() {
        //le bouton de soumission est caché tant que l'adresse n'est pas validée
        jQuery('#conditions-submit').hide();
        
        //caché par défaut, affiché si asssitant maternel et annonce salarié
        jQuery("#numagrement").hide();
        jQuery("#partedateagre").hide();
        //caché par défaut, affiché si asssitant maternel
        jQuery("#enfants").hide();
        //caché par défaut affiché si assitant maternel et annonce employeur
        jQuery("#infoassmat").hide();
        //=> voir fonction checkAssMat
        
        //caché par défaut affiché si garde partagée
        jQuery("#tr_famille").hide();
        jQuery("#tr_nounou").hide();
        //caché par défaut, affiché si garde partagé
        jQuery("#cadregp").hide();
        jQuery("#postalCodeBlock").hide();
        jQuery("#nbenfantsBloc").hide();
        jQuery("#ageBlock").hide();
        //=> voir fonction checkGP
        var selectedmetier = document.getElementById("metier").value;
        selectedmetier= selectedmetier.split('|');
        //pour afficher les bons blocs si Assistant maternel
        if(selectedmetier[0]=='4') {
            checkAssMat();
        }
        // pour afficher les bons blocs si Garde partagée
        else if(selectedmetier[0]=='1408') {
            checkGP();
        }
        
        
    }
    
    function verifform(){
        valid=true;
        
        //vérification s'il y a des champs requis non rempli
        jQuery(".field-req input[type='text']").each(function () {
            //alert(jQuery(this).val());
            if(jQuery(this).val() == '') {
                jQuery(this).parents(".field-req").next(".msg-error-valid").fadeIn().text("Veuillez remplir ce champ");
                valid= false;
            } else {
                jQuery(this).parents(".field-req").next(".msg-error-valid").hide().text("");
            }
        });
        //experience 
        if(jQuery("#experience option[value='0']").is(":checked")) {
            jQuery("#experience").parents(".field-req").next(".msg-error-valid").fadeIn().text("Veuillez sélectionner une valeur");
            valid= false;
        } else {
            jQuery("#experience").parents(".field-req").next(".msg-error-valid").hide().text("");
        }
       
        //validation de l'adresse
        if (jQuery("#message").html()==""){
            jQuery("#message").next(".msg-error-valid").fadeIn().text("Veuillez valider l'adresse");
            valid=false;
        } else if (jQuery("#message").html()!=""){
            if(jQuery("input[type=radio][name=geoadresse]:checked").length!=1) {
                jQuery("input[type=radio][name=geoadresse]").parents(".field-req").next(".msg-error-valid").fadeIn().text("Veuillez valider l'adresse");
                valid=false;
            } else {
                jQuery("input[type=radio][name=geoadresse]").parents(".field-req").next(".msg-error-valid").hide().text("");
            }
        } 
        
        //validation du format de la durée hebdomadaire 
        if (jQuery("#durehebdojs").val() != '' && !jQuery("#durehebdojs").val().match(/^[0-9.]*$/i)) {
            jQuery("#durehebdojs").parents(".field-check").next(".msg-error-valid").fadeIn().text("Le format n'est pas bon. Veuillez saisir un nombre");
            valid=false;
        } else {
            jQuery("#durehebdojs").parents(".field-check").next(".msg-error-valid").hide().text("");
        }

        if (jQuery("#tauxhoraire").val() != '' && !jQuery("#tauxhoraire").val().match(/^[0-9.]*$/i)) {
            jQuery("#tauxhoraire").parents(".field-check").next(".msg-error-valid").fadeIn().text("Le format n'est pas bon. Veuillez saisir un nombre");
            valid=false;
        } else {
            jQuery("#tauxhoraire").parents(".field-check").next(".msg-error-valid").hide().text("");
        }
        
        var selectedmetier = document.getElementById("metier").value;
        selectedmetier= selectedmetier.split('|');
        if (selectedmetier[0]=='1408'){
            <?php
            if($type_compte=="EMP"){
                echo '
                if(jQuery("input[type=radio][name=dejanounou]:checked").length !=1) {
                    alert("Avez vous une garde d\'enfants ?");
                    valid=false;
                }';
            }
            ?>

            if(jQuery("input[type=radio][name=dejafamille]:checked").length !=1) {
                alert("Avez vous une famille ?");
                valid=false;
            }
            <?php
            if($type_compte=="SAL"){
                echo '
                    
                var collectionsal = document.getElementById("ageBlock").getElementsByTagName(\'INPUT\');
                veriage1=0;
                for (var x=0; x<collectionsal.length; x++) {
                    if (collectionsal[x].checked==true){
                        veriage1=1;
                        break;
                    }
                }
                if (veriage1!=1){
                    alert("Merci de selectionner l\'age des enfants.");
                    valid=false;
                }
                
                var nbenfant = document.getElementById("nbenfantsBloc");
                if (nbenfant.style.display=="block"){
                    if(jQuery("#listNumOfChildren option[value=\'0\']").is(":checked")) {
                        jQuery("#listNumOfChildren").parents(".field-req").next(".msg-error-valid").fadeIn().text("Veuillez sélectionner une valeur");
                        valid= false;
                    } else {
                        jQuery("#listNumOfChildren").parents(".field-req").next(".msg-error-valid").hide().text("");
                    }
                }
                
                var cadrefamille = document.getElementById("postalCodeBlock");
                if (cadrefamille.style.display=="block"){
                    var chp_ville = document.getElementById("gp_ville").value;
                    if (chp_ville==""){
                        alert("Merci de saisir la ville de votre famille");
                        valid=false;
                    }
                    var chp_cpo = document.getElementById("gp_codepostal").value;
                    if (chp_cpo==""){
                        alert("Merci de saisir le code postal de votre famille");
                        valid=false;
                    }
                    if (document.getElementById("message2").innerHTML==""){
                        alert("Merci de valider l\'adresse de votre famille.");
                        valid=false;
                    } else if (document.getElementById("message2").innerHTML!=""){
                        if(jQuery("input[type=radio][name=geoadresse2]:checked").length!=1) {
                            alert("Merci de valider l\'adresse de votre famille.");
                            valid=false;
                        }
                    }
                }';
            } else if($type_compte=="EMP"){
                echo '
                    var collectionsal = document.getElementById("ageBlock").getElementsByTagName(\'INPUT\');
                    veriage1=0;
                    for (var x=0; x<collectionsal.length; x++) {
                        if (collectionsal[x].checked==true){
                            veriage1=1;
                            break;
                        }
                    }
                    if (veriage1!=1){
                        alert("Merci de selectionner l\'age des enfants.");
                        valid=false;
                    }
                   
                    
                    if(jQuery("#listNumOfChildren option[value=\'0\']").is(":checked")) {
                        jQuery("#listNumOfChildren").parents(".field-req").next(".msg-error-valid").fadeIn().text("Veuillez sélectionner une valeur");
                        valid= false;
                    } else {
                        jQuery("#listNumOfChildren").parents(".field-req").next(".msg-error-valid").hide().text("");
                    }
                    
                    
                    var cadrefamille = document.getElementById("postalCodeBlock");
                    if (cadrefamille.style.display=="block"){
                        var chp_ville = document.getElementById("gp_ville").value;
                        if (chp_ville==""){
                            alert("Merci de saisir la ville de votre famille");
                            valid=false;
                        }
                        var chp_cpo = document.getElementById("gp_codepostal").value;
                        if (chp_cpo==""){
                            alert("Merci de saisir le code postal de votre famille");
                            valid=false;
                        }
                        if (document.getElementById("message2").innerHTML==""){
                            alert("Merci de valider l\'adresse de votre famille.");
                           valid=false;
                        } else if (document.getElementById("message2").innerHTML!=""){
                            if(jQuery("input[type=radio][name=geoadresse2]:checked").length!=1) {
                                alert("Merci de valider l\'adresse de votre famille.");
                                valid=false;
                            }
                        }
                    }
                    
                    /*if(jQuery("#bt_dejanounou1")) {
                        if (jQuery("#bt_dejafamille1").is(":checked") && jQuery("#bt_dejanounou1").is(":checked")){
                            alert("Veuillez vérifier votre saisie, car vous ne pouvez pas avoir besoin de nos services si vous avez déjà une garde d’enfant et une famille.");
                        }
                    }*/';
            }
            ?>
        }

        return valid;
    }
  
   
</script>