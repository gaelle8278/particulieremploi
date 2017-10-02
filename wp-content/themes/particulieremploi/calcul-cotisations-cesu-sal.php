<?php

/**
 *
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

$locCesu=htmlentities($_POST['cesu_loc']);
$salaireCesu=htmlentities($_POST['cesu_salaire']);

//pour affichage des données
$tabCsg=calcul_csg($salaireCesu);
if ($locCesu== "dom") {
    $tabCotisationsSal=calcul_cotisations_salarie_dom($salaireCesu);
    $tabCotisationsEmp=calcul_cotisations_employeur_dom($salaireCesu);
} else {
    $tabCotisationsSal=calcul_cotisations_salarie($salaireCesu);
    $tabCotisationsEmp=calcul_cotisations_employeur($salaireCesu);
}

// calcul des cotisations
if($locCesu == "tous-dep") {
    $tabTotauxCotisationsEmp=calcul_cot_total_emp_dep($salaireCesu, 2);
    $tabTotauxCotisationsSal=calcul_cot_total_sal_dep($salaireCesu);
} else if ($locCesu == "alsace") {
    $tabTotauxCotisationsEmp=calcul_cot_total_emp_dep($salaireCesu, 2);
    $tabTotauxCotisationsSal=calcul_cot_total_sal_alsace($salaireCesu);
} elseif ($locCesu== "dom") {
    $tabTotauxCotisationsEmp=calcul_cot_total_emp_dom($salaireCesu, 3.7);
    $tabTotauxCotisationsSal=calcul_cot_total_sal_dom($salaireCesu);
}
?>
<div class='recap-simu'>
    <div class="article-toolbar">
        <?php 
        get_template_part('article-features-bar');
        get_template_part('small-social-links'); 
        ?>
    </div>
    <div class="wrap-clear"></div>
    
    <p class='title-recap-simu'>
        Cotisations salariés<br>
        <?php
        if($locCesu == "tous-dep") {
            ?>
            Tous départements sauf Alsace Moselle et DOM
            <?php
        } else if ($locCesu == "alsace") {
            ?>
            Alsace Moselle
            <?php
        } elseif ($locCesu == "dom") {
            ?>
            DOM
            <?php
        }
        ?>
    </p>
    <div class='main-simu-data'>
        <p>Taux horaire brut : 
            <span class='simu-value'><?php echo $salaireCesu; ?> euros</span>
        </p>
        <p>Taux horaire net : 
            <span class='simu-value'><?php echo $salaireCesu - $tabTotauxCotisationsSal['TotalCotisations']; ?> euros</span>
        </p>
        <p>Charges salariales :
            <span class='simu-value'><?php echo $tabTotauxCotisationsSal['TotalCotisations']; ?> euros</span>
        </p>
        <p>Coût total pour l'employeur :
            <span class='simu-value'><?php echo $tabTotauxCotisationsEmp['EMPCoutTotal']; ?> euros</span>
        </p>
        
    </div>
    <div class='simu-infos'>
        <?php get_template_part('glossaire-simu-cesu'); ?>
    </div>
    <div class='detail-simu-data'>
        <div>
            <p class="label-column simu-table-highlighted text-upper">Détail des cotisations salarié</p>
            <p class="value-column">Taux</p>
            <p class="value-column">Montant en €</p>
        </div>
        <div  class="row-pair">
            <p class="label-column">Maladie, Maternité, Invalidité, Décès</p>
            <p class="value-column"><?php echo $tabCotisationsSal['taux']['Maladie']; ?></p>
            <p class="value-column"><?php echo $tabCotisationsSal['Maladie']; ?></p>
        </div>
        <?php
        if ($locCesu == "alsace") {
            ?>
            <div>
                <p class="label-column">Cotisation supp. Alsace Moselle</p>
                <p class="value-column"><?php echo $tabCotisationsSal['taux']['CotSuppALSMOS']; ?></span>
                <p class="value-column"><?php echo $tabCotisationsSal['CotSuppALSMOS']; ?></p>
            </div>
            <?php
            $classRowPair="row-pair";
            $classRowImpair="";
            
        } else {
            $classRowPair="";
            $classRowImpair="row-pair";
        }
        ?>
        <div class="<?php echo $classRowPair ?>" >
            <p class="label-column">Assurance vieillesse déplafonnée</p>
            <p class="value-column"><?php echo $tabCotisationsSal['taux']['AssVieillesse']; ?></span>
            <p class="value-column"><?php echo $tabCotisationsSal['AssVieillesse']; ?></p>
        </div>
        <div class="<?php echo $classRowImpair ?>">
            <p class="label-column">Vieillesse plafonnée </p>
            <p class="value-column"><?php echo $tabCotisationsSal['taux']['VieillessePlaf']; ?></span>
            <p class="value-column"><?php echo $tabCotisationsSal['VieillessePlaf']; ?></p>
        </div>
        <div class="<?php echo $classRowPair ?>">
            <?php
            if ($locCesu == "dom") {
                ?>
                <p class="label-column">ARRCO</p>
                <p class="value-column"><?php echo $tabCotisationsSal['taux']['ARRCO']; ?></p>
                <p class="value-column"><?php echo $tabCotisationsSal['ARRCO']; ?></p>
                <?php
            } else {
                ?>
                <p class="label-column">IRCEM (retraite complémentaire) </p>
                <p class="value-column"><?php echo $tabCotisationsSal['taux']['IRCEMRetraite']; ?></p>
                <p class="value-column"><?php echo $tabCotisationsSal['IRCEMRetraite']; ?></p>
                <?php
            }
            ?>
        </div>
        <div class="<?php echo $classRowImpair ?>">
            <p class="label-column">AGFF</p>
            <p class="value-column"><?php echo $tabCotisationsSal['taux']['AGFF'];  ?></p>
            <p class="value-column"><?php echo $tabCotisationsSal['AGFF'];  ?></p>
        </div>
        <div class="<?php echo $classRowPair ?>">
            <p class="label-column">Assurance chômage</p>
            <p class="value-column"><?php echo $tabCotisationsSal['taux']['AssuChomage']; ?></p>
            <p class="value-column"><?php echo $tabCotisationsSal['AssuChomage']; ?></p>
        </div>
        <?php
        if ($locCesu != "dom") {
            ?>
            <div class="<?php echo $classRowImpair ?>">
                <p class="label-column">IRCEM (Prévoyance)</p>
                <p class="value-column"><?php echo $tabCotisationsSal['taux']['IRCEMPrev'];  ?></p>
                <p class="value-column"><?php echo $tabCotisationsSal['IRCEMPrev'];  ?></p>
            </div>
            <?php
            $classRowPair="";
            $classRowImpair="row-pair";

        } else {
            $classRowPair="row-pair";
            $classRowImpair="";
        }
        ?>
        <div class="<?php echo $classRowPair ?>">
            <p class="label-column text-bold">Sous Total 1</p>
            <p class="value-column"></p>
            <p class="value-column text-bold"><?php echo $tabTotauxCotisationsSal['SousTotalCotisations']; ?> euros</p>
        </div>
        <div class="<?php echo $classRowImpair ?>">
            <p class="label-column text-bold">Calcul CSG - CRDS</p>
            <p class="value-column"></p>
            <p class="value-column"></p>
        </div>
        <div class="<?php echo $classRowPair ?>">
            <p class="label-column">Montant de base 98,25 % du Brut</p>
            <p class="value-column"></p>
            <p class="value-column"><?php echo $tabCsg['CsgRdsAV']; ?></p>
        </div>
        <div class="<?php echo $classRowImpair ?>">
            <p class="label-column">CGS Deductible</p>
            <p class="value-column">5.10%</p>
            <p class="value-column"><?php echo $tabCsg['CSGDeduc']; ?></p>
        </div>
        <div class="<?php echo $classRowPair ?>">
            <p class="label-column">CGS Non Déductible</p>
            <p class="value-column">2.40%</p>
            <p class="value-column"><?php echo $tabCsg['CSGNonDeductible']; ?></p>
        </div>
        <div class="<?php echo $classRowImpair ?>">
            <p class="label-column">C R D S Non Déductible </p>
            <p class="value-column">0.50%</p>
            <p class="value-column"><?php echo $tabCsg['CRDSNonDeductible']; ?></p>
        </div>
        <div class="<?php echo $classRowPair ?>">
            <p class="label-column text-bold">Sous Total 2</p>
            <p class="value-column"></p>
            <p class="value-column text-bold"><?php echo $tabCsg['CsgRdsAP']; ?> euros</p>
        </div>
        <div class="<?php echo $classRowImpair ?>">
            <p class="label-column simu-table-highlighted">Total des cotisations salarié</p>
            <p class="value-column"></p>
            <p class="value-column simu-table-highlighted"><?php echo $tabTotauxCotisationsSal['TotalCotisations']; ?> euros</p>
        </div>
    </div>
</div>

