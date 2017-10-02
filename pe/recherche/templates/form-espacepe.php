<?php

/**
 * Formulaire de recherche de l'espace pe
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

global $wpdb;
$queryMetier= "SELECT 
    referentiel_id, 
    referentiel_libelle 
    from ".TBL_REF_METIERS."
    WHERE referentiel_visibilite = '1' 
    order by referentiel_libelle ASC";
$resMetier=$wpdb->get_results($queryMetier);
?>
<div class="bloc-recherche-espacepe">
    <div class="content-central-column">
        <form id="espacepe-search" action="/pe/espace-pe/recherche.php" method="post">
            <input type="hidden" name="type_annonce" value="<?php echo $_SESSION['utilisateur_groupe']=="SAL" ? "emp":"sal"; ?>" />
            <div class='bloc-search'>
                <div class="field-metier">
                    <label for="metier">Métiers</label>
                    <div class="select-style">
                        <select name="metier" id="metier">
                            <option value="0">Sélectionner</option>
                            <?php
                            foreach($resMetier as $result ){
                                echo "<option value='".$result->referentiel_id."'>";
                                echo $result->referentiel_libelle."</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="field-cp">
                    <label for="codep">Localisation</label>
                    <input type="text" class="input-style" id="codep" name="codep" placeholder="Code Postal">
                </div>
                <div class="field-distance">
                    <label for="distance">Etendre ma recherche</label>
                    <div class="select-style">
                        <select name="distance" id="distance">
                            <option value="0">Ne pas étendre ma recherche </option>
                            <option value="5" selected="selected"> à un rayon de 5 kms</option>
                            <?php
                            for ($i = 10; $i <= 50; $i+=5){
                                echo '<option value="'.$i.'"> à un rayon de '.$i.' kms</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="bloc-search advanced-search">
                <div class="field-date">
                    <label for="datepf">Date de prise de fonction : </label>
                    <input type="text" class="input-style datepicker-full" id="datepf" name="datepf"  placeholder="">
                </div>
                <div class="field-duree">
                    <label>Durée hebdomadaire :</label>
                    De : <input type="text" class="input-style" id="dureehebdomin" name="dureehebdomin"  placeholder="">
                    à : <input type="text" class="input-style" id="dureehebdomax" name="dureehebdomax" placeholder="">
                    heures
                </div>
                <div class="field-taux">
                    <label for="tauxh">Taux horaire minimum de :</label>
                    <input type="text" class="input-style" id="tauxh" name="tauxh"  placeholder="">
                </div>
            </div>
            <!--<div>
                 <input type="checkbox" name="carte" id="carte" <?php echo !empty($params['carte']) ? 'checked="checked"':""; ?> />
                <label for="carte" >Afficher les résultats sur la carte </label>
            </div>-->
            <div class="advanced-search-toggle">
                <input type="submit" value="Rechercher"  />
                <p id='advanced-search-toggle'>Recherche avancée</p>
            </div>
              
        </form>
    </div>
</div>