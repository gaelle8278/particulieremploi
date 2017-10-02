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
if ($locCesu== "dom") {
    $tabCotisationsEmp=calcul_cotisations_employeur_dom($salaireCesu);
} else {
    $tabCotisationsEmp=calcul_cotisations_employeur($salaireCesu);
}

// calculs des cotisations
if($locCesu == "tous-dep") {
    $tabTotauxCotisationsEmp=calcul_cot_total_emp_dep($salaireCesu, 2);
    $tabTotauxCotisationsSal=calcul_cot_total_sal_dep($salaireCesu);
} elseif ($locCesu == "alsace") {
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
        Cotisations employeurs<br />
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
        <p>Cotisations employeur :
            <span class='simu-value'><?php echo $tabTotauxCotisationsEmp['EMPTotalCotisations']; ?> euros</span>
        </p>
        <p>Coût total pour l'employeur :
            <span class='simu-value'><?php echo $tabTotauxCotisationsEmp['EMPCoutTotal']; ?> euros</span>
        </p>
        <p>Coût total pour l'employeur après réduction de la déduction fiscale: 
            <span class='simu-value'><?php echo $tabTotauxCotisationsEmp['EMPCoutAbat']; ?> euros</span>
        </p>
    </div>
    <div class='simu-infos'>
        <?php get_template_part('glossaire-simu-cesu'); ?>
    </div>
    <div class='detail-simu-data'>
        <div>
            <p class="label-column simu-table-highlighted text-upper">Détail des cotisations employeur</p>
            <p class="value-column text-bold">Taux</p>
            <p class="value-column text-bold">Montant en €</p>
        </div>
        <div class="row-pair">
            <p class="label-column">Maladie, Maternité, Invalidité, Décès</p>
            <p class="value-column"><?php echo $tabCotisationsEmp['taux']['EMPMaladie01']; ?></p>
            <p class="value-column"><?php echo $tabCotisationsEmp['EMPMaladie01']; ?></p>
        </div>
        <div>
            <p class="label-column">Assurance vieillesse déplafonnée</p>
            <p class="value-column"><?php echo $tabCotisationsEmp['taux']['EMPAssVieillesse']; ?></span>
            <p class="value-column"><?php echo $tabCotisationsEmp['EMPAssVieillesse']; ?></p>
        </div>
        <div class="row-pair">
            <p class="label-column">Vieillesse plafonnée </p>
            <p class="value-column"><?php echo $tabCotisationsEmp['taux']['EMPVieillessePlaf']; ?></span>
            <p class="value-column"><?php echo $tabCotisationsEmp['EMPVieillessePlaf']; ?></p>
        </div>
        <div>
            <p class="label-column">Accident de travail</p>
            <p class="value-column"><?php echo $tabCotisationsEmp['taux']['EMPAccTravail']; ?></span>
            <p class="value-column"><?php echo $tabCotisationsEmp['EMPAccTravail']; ?></p>
        </div>
        <div class="row-pair">
            <p class="label-column">Allocations familiales</p>
            <p class="value-column"><?php echo $tabCotisationsEmp['taux']['EMPAllocFam']; ?></span>
            <p class="value-column"><?php echo $tabCotisationsEmp['EMPAllocFam']; ?></p>
        </div>
        <div>
            <p class="label-column text-bold">Sous Total 1</p>
            <p class="value-column"></p>
            <p class="value-column text-bold"><?php echo $tabTotauxCotisationsEmp['EMPSousTotal_01']; ?></p>
        </div>
        <div class="row-pair">
            <?php
            if ($locCesu == "dom") {
                ?>
                <p class="label-column">ARRCO</p>
                <p class="value-column"><?php echo $tabCotisationsEmp['taux']['ARRCO']; ?></p>
                <p class="value-column"><?php echo $tabCotisationsEmp['ARRCO']; ?></p>

                <?php
            } else {
                ?>
                <p class="label-column">IRCEM (retraite complémentaire) </p>
                <p class="value-column"><?php echo $tabCotisationsEmp['taux']['EMPIRCEMRetraite']; ?></p>
                <p class="value-column"><?php echo $tabCotisationsEmp['EMPIRCEMRetraite']; ?></p>
                <?php
            }
            ?>
        </div>
        <div>
            <p class="label-column">AGFF</p>
            <p class="value-column"><?php echo $tabCotisationsEmp['taux']['EMPAGFF'];  ?></p>
            <p class="value-column"><?php echo $tabCotisationsEmp['EMPAGFF'];  ?></p>
        </div>
        <div class="row-pair">
            <p class="label-column">Assurance chômage</p>
            <p class="value-column"><?php echo $tabCotisationsEmp['taux']['EMPAssuChomage']; ?></p>
            <p class="value-column"><?php echo $tabCotisationsEmp['EMPAssuChomage']; ?></p>
        </div>
        <?php
        if ($locCesu != "dom") {
            ?>
            <div>

                <p class="label-column">IRCEM (Prévoyance)</p>
                <p class="value-column"><?php echo $tabCotisationsEmp['taux']['EMPIRCEMPrev']; ?></p>
                <p class="value-column"><?php echo $tabCotisationsEmp['EMPIRCEMPrev']; ?></p>
            </div>
            <?php
            $classRowPair="row-pair";
            $classRowImpair="";
        } else {
            $classRowPair="";
            $classRowImpair="row-pair";
        }
        ?>
        <div class="<?php echo $classRowPair ?>">
            <p class="label-column">Contribution Solidarité Autonomie</p>
            <p class="value-column"><?php echo $tabCotisationsEmp['taux']['EMPContriSoliAuto']; ?></p>
            <p class="value-column"><?php echo $tabCotisationsEmp['EMPContriSoliAuto']; ?></p>
        </div>
        <div class="<?php echo $classRowImpair ?>">
            <p class="label-column">Formation Professionnelle</p>
            <p class="value-column"><?php echo $tabCotisationsEmp['taux']['EMPFormationPro']; ?></p>
            <p class="value-column"><?php echo $tabCotisationsEmp['EMPFormationPro']; ?></p>
        </div>
        <div class="<?php echo $classRowPair ?>">
            <p class="label-column">Fonds National d'aide au logement</p>
            <p class="value-column"><?php echo $tabCotisationsEmp['taux']['EMPFondNatLogement']; ?></p>
            <p class="value-column"><?php echo $tabCotisationsEmp['EMPFondNatLogement']; ?></p>
        </div>
        <div class="<?php echo $classRowImpair ?>">
            <p class="label-column">Contribution au financement des organisations syndicales</p>
            <p class="value-column"><?php echo $tabCotisationsEmp['taux']['OrgSyn']; ?></p>
            <p class="value-column"><?php echo $tabCotisationsEmp['OrgSyn']; ?></span>
        </div>
        <div class="<?php echo $classRowPair ?>">
            <p class="label-column text-bold">Sous Total 2</p>
            <p class="value-column"></p>
            <p class="value-column text-bold"><?php echo $tabTotauxCotisationsEmp['EMPSousTotal_02']; ?></p>
        </div>
        <div class="<?php echo $classRowImpair ?>">
            <p class="label-column">Déduction forfaitaire</p>
            <p class="value-column"></p>
            <p class="value-column"><?php echo $tabTotauxCotisationsEmp['DeductionForfait']; ?></p>
        </div>
        <div class="<?php echo $classRowPair ?>">
            <p class="label-column simu-table-highlighted">Total des cotisations employeur</p>
            <p class="value-column"></p>
            <p class="value-column simu-table-highlighted"><?php echo $tabTotauxCotisationsEmp['EMPTotalCotisations']; ?></p>
        </div>
    </div>
</div>
