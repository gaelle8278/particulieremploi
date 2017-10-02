<?php

/**
 *
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

global $wpdb;
$queryMetier= "SELECT referentiel_id, referentiel_libelle from tbl_ref_metiers 
    WHERE referentiel_visibilite = '1' order by referentiel_libelle ASC";
$resMetier=$wpdb->get_results($queryMetier);
?>
<h1 class="text-center">L'emploi à domicile entre particuliers,<br> économique, solidaire et responsable</h1>
<div id="search-tabs">
    <ul>
        <li><a href="#search-emp"><span>Je recherche un salarié à domicile</span></a></li>
        <li><a href="#search-sal"><span>Je recherche un emploi à domicile</span></a></li>
    </ul>
    <div id="search-emp">
        <form action="/pe/recherche/results.php" method="post" enctype="multipart/form-data" name="rechemployeur" >
            <input type="hidden" name="type_annonce" value="sal" />
            <div class="field-metier">
                <label for="metierEmp">Métiers</label>
                <div class="select-style">
                    <select name="metier" id="metierEmp" class="">
                         <option value="0">Sélectionner </option>
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
                <label for="codepEmp">Localisation</label>
                <input type="text" class="input-style" id="codepEmp" name="codep" class=""  placeholder="Code Postal"
                       value="<?php  echo !empty($depCode)? $depCode : ""; ?>">
            </div>
            <div class="field-distance">
                <label for="distanceEmp">Etendre ma recherche</label>
                <div class="select-style">
                    <select name="distance" id="distanceEmp">
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
            <input type="submit" name="searchEmp" value="Rechercher"  class="emp-rech"/>
        </form>
    </div>
    <div id="search-sal">
        <form id="hp-search" action="/pe/recherche/results.php" method="post" enctype="multipart/form-data" name="rechsalarie" >
            <input type="hidden" name="type_annonce" value="emp" />
            <div class="field-metier">
                <label for="metierSal">Métiers</label>
                <div class="select-style">
                    <select name="metier" id="metierSal">
                        <option value="0">Sélectionner </option>
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
                <label for="codepSal">Localisation</label>
                <input type="text" class="input-style" id="codepSal" name="codep" placeholder="Code Postal"
                       value="<?php  echo !empty($depCode)? $depCode : ""; ?>" >
            </div>
            <div class="field-distance">
                <label for="distanceSal">Etendre ma recherche</label>
                <div class="select-style">
                    <select name="distance" id="distanceSal">
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
            <input type="submit" name="searchSal" value="Rechercher" class="sal-rech"/>
        </form>
    </div>
</div>
