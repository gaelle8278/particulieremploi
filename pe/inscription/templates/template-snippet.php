<?php

/**
 *
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
?>
<div class="form-separator"></div>
                <p class="section-title">Sélectionner le domaine d'activités de l'emploi recherché</p>
                <div class="section-separator"></div>
                <div class="bloc-field-form">
                    <p>Identifier le domaine d’activités correspondant 
                         parmi un des 5 domaines proposés ci-après.  
                         Lorsque plusieurs domaines d’activités sont concernés,
                         le domaine retenu est celui correspondant à l’activité principale
                         qui est celle qui prend le plus de temps.
                    </p>
                    <div class="field-value">
                        <?php
                        $querydomainesActivites="SELECT 
                                domaine_classif_id,
                                domaine_classif_libelle, 
                                categorie_nom 
                            from 
                                ".TBL_DOMAINE_CLASSIF.",  
                                ".TBL_CATEGORIES." 
                            where 
                                domaine_classif_ref_categorie=categorie_id 
                            order by domaine_classif_ordre ASC";
                        $domainesActivites=$wpdb->get_results($querydomainesActivites);
                        ?>
                        <div class="select-style">
                            <select name="domaine_activite" id="domaine_activite">
                                <option value="0">Sélectionner votre domaine d'activité</option>
                                <?php
                                foreach ($domainesActivites as $domaine) {
                                        echo "<option value='".$domaine->domaine_classif_id."'>";
                                        echo $domaine->domaine_classif_libelle." / ".ucfirst($domaine->categorie_nom)."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>