<?php

/**
 * Fichier contenant les données et calcul du simulateur CESU
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

$SMIC = "9.67 euros au 01/01/2016";


/**
 * Fonction qui construit le tableau des cotisations salariés 
 * pour tous départements et Alsace
 * 
 * @param type $salaireBrut
 * @return type array
 */
function calcul_cotisations_salarie ($salaireBrut) {
    
    /* Maladie, Maternité, Invalidité, Décès 0,75% */ 
    $tabCotSal['taux']['Maladie']="0,75%";
    $tabCotSal['Maladie'] = round(($salaireBrut * 0.75/100), 2);
    /*Cotisation Supplementaire Alsace Moselle */ 
    $tabCotSal['taux']['CotSuppALSMOS']="1,50%";
    $tabCotSal['CotSuppALSMOS'] = round(($salaireBrut * 1.50/100), 2);
    /*Assurance vieillesse déplafonnée 0,10% */ 
    $tabCotSal['taux']['AssVieillesse']="0,40%";
    $tabCotSal['AssVieillesse'] = round(($salaireBrut * 0.40/100), 2);
    /*Vieillesse plafonnée	6,75% */ 
    $tabCotSal['taux']['VieillessePlaf']="6,90%";
    $tabCotSal['VieillessePlaf'] = round(($salaireBrut * 6.90/100), 2);
    /*IRCEM (retraite complémentaire) 3,75% */ 
    $tabCotSal['taux']['IRCEMRetraite']="3,87%";
    $tabCotSal['IRCEMRetraite'] = round(($salaireBrut * 3.87/100), 2);
    /* ARRCO */
    $tabCotSal['taux']['ARRCO']="3,10%";
    $tabCotSal['ARRCO'] = round(($salaireBrut * 3.1/100), 2);
    /*AGFF 0,80% */ 
    $tabCotSal['taux']['AGFF']="0,80%";
    $tabCotSal['AGFF'] = round(($salaireBrut * 0.80/100), 2);
    /*Assurance chômage	2,40% */ 
    $tabCotSal['taux']['AssuChomage']="2,40%";
    $tabCotSal['AssuChomage'] = round(($salaireBrut * 2.40/100), 2);
    /*IRCEM (Prévoyance) 0,70% */ 
    $tabCotSal['taux']['IRCEMPrev']="0,70%";
    $tabCotSal['IRCEMPrev'] = round(($salaireBrut * 0.70/100), 2);
    /*NOUVELLE CHARGE - Organisation Syndicales 0.016 %*/ 
    //$tabCotSal['OrgSyn'] = $salaireBrut * 0.016/100;

    
    return $tabCotSal;
}
/**
 * Fonction qui construit le tableau des cotisations salariés 
 * pour dom
 * pour tous départements et Alsace
 * 
 * @param type $salaireBrut
 * @return type array
 */
function calcul_cotisations_salarie_dom ($salaireBrut) {
    
    /* Maladie, Maternité, Invalidité, Décès 0,75% */ 
    $tabCotSal['taux']['Maladie']="0,75%";
    $tabCotSal['Maladie'] = round(($salaireBrut * 0.75/100), 2);
    /*Cotisation Supplementaire Alsace Moselle */ 
    $tabCotSal['taux']['CotSuppALSMOS']="1,50%";
    $tabCotSal['CotSuppALSMOS'] = round(($salaireBrut * 1.50/100), 2);
    /*Assurance vieillesse déplafonnée 0,10% */ 
    $tabCotSal['taux']['AssVieillesse']="0,40%";
    $tabCotSal['AssVieillesse'] = round(($salaireBrut * 0.40/100), 2);
    /*Vieillesse plafonnée	6,75% */ 
    $tabCotSal['taux']['VieillessePlaf']="6,90%";
    $tabCotSal['VieillessePlaf'] = round(($salaireBrut * 6.90/100), 2);
    /*IRCEM (retraite complémentaire) 3,75% */
    $tabCotSal['taux']['IRCEMRetraite']="3,87%";
    $tabCotSal['IRCEMRetraite'] = round(($salaireBrut * 3.87/100), 2);
    /* ARRCO */
    $tabCotSal['taux']['ARRCO']="3,10%";
    $tabCotSal['ARRCO'] = round(($salaireBrut * 3.1/100), 2);
    /*AGFF 0,80% */ 
    $tabCotSal['taux']['AGFF']="0,80%";
    $tabCotSal['AGFF'] = round(($salaireBrut * 0.80/100), 2);
    /*Assurance chômage	2,40% */
    $tabCotSal['taux']['AssuChomage']="2,40%";
    $tabCotSal['AssuChomage'] = round(($salaireBrut * 2.40/100), 2);
    /*IRCEM (Prévoyance) 0,70% */
    $tabCotSal['taux']['IRCEMPrev']="0,70%";
    $tabCotSal['IRCEMPrev'] = round(($salaireBrut * 0.70/100), 2);
    /*NOUVELLE CHARGE - Organisation Syndicales 0.016 %*/ 
    //$tabCotSal['OrgSyn'] = $salaireBrut * 0.016/100;

    
    return $tabCotSal;
}
/**
 * Fonction qui construit le tableau des calculs de la csg
 *
 * @param type $salaireBrut
 * @return type array
 */
function calcul_csg ($salaireBrut) {
    //a mettre dans un tableau
    $tabCSG['CsgRdsAV'] = round(($salaireBrut * 98.25/100), 2);
    /*CGS Deductible 5.10% */
    $tabCSG['CSGDeduc'] =  round(($tabCSG['CsgRdsAV'] * 5.10/100), 2);
    //CGS Non Déductible 2.40% */
    $tabCSG['CSGNonDeductible'] = round(($tabCSG['CsgRdsAV'] * 2.40/100), 2);
    /*C R D S Non Déductible 0.50% */
    $tabCSG['CRDSNonDeductible'] = round(($tabCSG['CsgRdsAV'] * 0.50/100), 2);
    /* Montant Total CSG et RDS */
    $tabCSG['CsgRdsAP'] = $tabCSG['CSGDeduc'] + $tabCSG['CSGNonDeductible'] + $tabCSG['CRDSNonDeductible'] ;

    return $tabCSG;
}
/**
 * Fonction qui construit le tableau contenant les sommes basées sur les cotisations salariés
 * pour tous les départements sauf Alsace-Moselle et DOM
 *
 * @param type $salaireBrut
 * @return type array
 */
function calcul_cot_total_sal_dep ($salaireBrut) {
    $tabCotSal=calcul_cotisations_salarie($salaireBrut);
    $tabCsg=calcul_csg($salaireBrut);
    $tabSalTotalCot['SousTotalCotisations'] = round(($tabCotSal['Maladie'] + $tabCotSal['AssVieillesse'] + $tabCotSal['VieillessePlaf'] +
        $tabCotSal['IRCEMRetraite'] + $tabCotSal['AGFF'] + $tabCotSal['AssuChomage'] + $tabCotSal['IRCEMPrev']), 2);
    $tabSalTotalCot['TotalCotisations'] = round(($tabSalTotalCot['SousTotalCotisations'] + $tabCsg['CsgRdsAP']), 2);

    return  $tabSalTotalCot;
}
/**
 * Fonction qui construit le tableau contenant les sommes basées sur les cotisations salariés
 * pour Alsace-Moselle
 *
 * @param type $salaireBrut
 * @return type array
 */
function calcul_cot_total_sal_alsace ($salaireBrut) {
    $tabCotSal=calcul_cotisations_salarie($salaireBrut);
    $tabCsg=calcul_csg($salaireBrut);
    $tabSalTotalCot['SousTotalCotisations'] =  round(($tabCotSal['Maladie'] + $tabCotSal['CotSuppALSMOS'] + $tabCotSal['AssVieillesse'] +
        $tabCotSal['VieillessePlaf'] + $tabCotSal['IRCEMRetraite'] + $tabCotSal['AGFF'] + $tabCotSal['AssuChomage'] +
        $tabCotSal['IRCEMPrev']), 2);
    $tabSalTotalCot['TotalCotisations'] = round(($tabSalTotalCot['SousTotalCotisations'] + $tabCsg['CsgRdsAP']), 2);

    return  $tabSalTotalCot;
}
/**
 * Fonction qui construit le tableau contenant les sommes basées sur les cotisations salariés
 * pour DOM
 *
 * @param type $salaireBrut
 * @return type array
 */
function calcul_cot_total_sal_dom ($salaireBrut) {
    $tabCotSal=calcul_cotisations_salarie_dom($salaireBrut);
    $tabCsg=calcul_csg($salaireBrut);
    $tabSalTotalCot['SousTotalCotisations'] =  round(($tabCotSal['Maladie'] + $tabCotSal['AssVieillesse'] +
        $tabCotSal['VieillessePlaf'] + $tabCotSal['ARRCO'] + $tabCotSal['AGFF'] + $tabCotSal['AssuChomage']), 2) ;
    $tabSalTotalCot['TotalCotisations'] = round(($tabSalTotalCot['SousTotalCotisations'] + $tabCsg['CsgRdsAP']), 2);

    return  $tabSalTotalCot;
}

/**
 * Fonction qui construit le tableau des cotisations employeurs
 * pour tous départements et Alsace
 * 
 * @param type $salaireBrut
 * @return type array
 */
function calcul_cotisations_employeur ($salaireBrut) {
    /* Maladie, Maternité, Invalidité, Décès 12.80% */ 
    $tabCotEmp['taux']['EMPMaladie01']="12,89%";
    $tabCotEmp['EMPMaladie01'] = round(($salaireBrut * 12.89/100), 2);
    /* Assurance vieillesse déplafonnée 1.60% */ 
    $tabCotEmp['taux']['EMPAssVieillesse']="1,90%";
    $tabCotEmp['EMPAssVieillesse'] = round(($salaireBrut * 1.90/100), 2);
    /* Vieillesse plafonnée	8.40% */ 
    $tabCotEmp['taux']['EMPVieillessePlaf']="8,55%";
    $tabCotEmp['EMPVieillessePlaf'] = round(($salaireBrut * 8.55/100), 2);
    /* Accident de travail 2.10% */
    $tabCotEmp['taux']['EMPAccTravail']="2,10%";
    $tabCotEmp['EMPAccTravail'] = round(($salaireBrut * 2.10/100), 2);
    /* Allocation Familliales	5.25% */ 
    $tabCotEmp['taux']['EMPAllocFam']="5,25%";
    $tabCotEmp['EMPAllocFam'] = round(($salaireBrut * 5.25/100), 2);
    /* AIRCEM Retraite complémetaire	3.88% */ 
    $tabCotEmp['taux']['EMPIRCEMRetraite']="3,88%";
    $tabCotEmp['EMPIRCEMRetraite'] = round(($salaireBrut * 3.88/100), 2);
    
    $tabCotEmp['taux']['ARRCO']="4,65%";
    $tabCotEmp['ARRCO']= round(($salaireBrut * 4.65/100),2);
    /* AGFF 1.20% */ 
    $tabCotEmp['taux']['EMPAGFF']="1,20%";
    $tabCotEmp['EMPAGFF'] = round(($salaireBrut * 1.20/100), 2);
    /* Assurance chômage 4% */ 
    $tabCotEmp['taux']['EMPAssuChomage']="4,00%";
    $tabCotEmp['EMPAssuChomage'] = round(($salaireBrut * 4.00/100), 2);
    /* IRCEM (Prévoyance) 0,91% - AUGMENTATION DU 01/03/2014 */ 
    $tabCotEmp['taux']['EMPIRCEMPrev']="0,91%";
    $tabCotEmp['EMPIRCEMPrev'] = round(($salaireBrut * 0.91/100), 2);
    /* Contribution Solidarité Autonomie 0.30% */ 
    $tabCotEmp['taux']['EMPContriSoliAuto']="0,30%";
    $tabCotEmp['EMPContriSoliAuto'] = round(($salaireBrut * 0.30/100), 2);
    /* Formation Professionnelle 0.35% */ 
    $tabCotEmp['taux']['EMPFormationPro']="0,35%";
    $tabCotEmp['EMPFormationPro'] = round(($salaireBrut * 0.35/100), 2);
    /* Fond National D'aide au Logement 0.10% */ 
    $tabCotEmp['taux']['EMPFondNatLogement']="0,10%";
    $tabCotEmp['EMPFondNatLogement'] = round(($salaireBrut * 0.10/100), 2);
    /*NOUVELLE CHARGE - Organisation Syndicales 0.016 %*/ 
    $tabCotEmp['taux']['OrgSyn']="0,016%";
    $tabCotEmp['OrgSyn'] = round(($salaireBrut * 0.016/100), 3);
    
    return $tabCotEmp;
}
/**
 * Fonction qui construit le tableau des cotisations employeurs
 * pour dom
 * 
 * @param type $salaireBrut
 * @return type array
 */
function calcul_cotisations_employeur_dom ($salaireBrut) {
    /* Maladie, Maternité, Invalidité, Décès 12.80% */ 
    $tabCotEmp['taux']['EMPMaladie01']="12,89%";
    $tabCotEmp['EMPMaladie01'] = round(($salaireBrut * 12.89/100), 2);
    /* Assurance vieillesse déplafonnée 1.60% */ 
    $tabCotEmp['taux']['EMPAssVieillesse']="1,90%";
    $tabCotEmp['EMPAssVieillesse'] = round(($salaireBrut * 1.90/100), 2);
    /* Vieillesse plafonnée	8.40% */ 
    $tabCotEmp['taux']['EMPVieillessePlaf']="8,55%";
    $tabCotEmp['EMPVieillessePlaf'] = round(($salaireBrut * 8.55/100), 2);
    /* Accident de travail 2.10% */ 
    $tabCotEmp['taux']['EMPAccTravail']="2,10%";
    $tabCotEmp['EMPAccTravail'] = round(($salaireBrut * 2.10/100), 2);
    /* Allocation Familliales	5.25% */ 
    $tabCotEmp['taux']['EMPAllocFam']="5,25%";
    $tabCotEmp['EMPAllocFam'] = round(($salaireBrut * 5.25/100), 2);
    
    $tabCotEmp['taux']['EMPIRCEMRetraite']="3,88%";
    $tabCotEmp['EMPIRCEMRetraite'] = round(($salaireBrut * 3.88/100), 2);
    
    $tabCotEmp['taux']['ARRCO']="4,65%";
    $tabCotEmp['ARRCO']= round(($salaireBrut * 4.65/100),2);
    /* AGFF 1.20% */ 
    $tabCotEmp['taux']['EMPAGFF']="1,20%";
    $tabCotEmp['EMPAGFF'] = round(($salaireBrut * 1.20/100), 2);
    /* Assurance chômage 4% */ 
    $tabCotEmp['taux']['EMPAssuChomage']="4,00%";
    $tabCotEmp['EMPAssuChomage'] = round(($salaireBrut * 4.00/100), 2);
    /* IRCEM (Prévoyance) 0,91% - AUGMENTATION DU 01/03/2014 */ 
    $tabCotEmp['taux']['EMPIRCEMPrev']="0,91%";
    $tabCotEmp['EMPIRCEMPrev'] = round(($salaireBrut * 0.91/100), 2);
    /* Contribution Solidarité Autonomie 0.30% */ 
    $tabCotEmp['taux']['EMPContriSoliAuto']="0,30%";
    $tabCotEmp['EMPContriSoliAuto'] = round(($salaireBrut * 0.30/100), 2);
    /* Formation Professionnelle 0.35% */ 
    $tabCotEmp['taux']['EMPFormationPro']="0,35%";
    $tabCotEmp['EMPFormationPro'] = round(($salaireBrut * 0.35/100), 2);
    /* Fond National D'aide au Logement 0.10% */ 
    $tabCotEmp['taux']['EMPFondNatLogement']="0,10%";
    $tabCotEmp['EMPFondNatLogement'] = round(($salaireBrut * 0.10/100), 2);
    /*NOUVELLE CHARGE - Organisation Syndicales 0.016 %*/ 
    $tabCotEmp['taux']['OrgSyn']="0,016%";
    $tabCotEmp['OrgSyn'] = round(($salaireBrut * 0.016/100), 3);
    
    
    return $tabCotEmp;
}
/**
 * Fonction qui construit le tableau contenant les sommes basées sur les cotisations employeur
 * pour tous les départements et Alsace
 * 
 * @param type $salaireBrut
 * @return type array
 */
function calcul_cot_total_emp_dep ($salaireBrut, $deductionforfaitaire = 2) {
    $tabCotEmp=  calcul_cotisations_employeur($salaireBrut);
    $tabEmpTotalCot['DeductionForfait']=$deductionforfaitaire;
    $tabEmpTotalCot['EMPSousTotal_01'] = round(($tabCotEmp['EMPMaladie01'] + $tabCotEmp['EMPAssVieillesse'] +
        $tabCotEmp['EMPVieillessePlaf'] + $tabCotEmp['EMPAccTravail'] + $tabCotEmp['EMPAllocFam']), 2);
    $tabEmpTotalCot['EMPSousTotal_02'] = round(($tabCotEmp['EMPIRCEMRetraite'] + $tabCotEmp['EMPAGFF'] +
        $tabCotEmp['EMPAssuChomage'] + $tabCotEmp['EMPIRCEMPrev'] + $tabCotEmp['EMPContriSoliAuto']
        + $tabCotEmp['EMPFormationPro'] + $tabCotEmp['EMPFondNatLogement'] + $tabCotEmp['OrgSyn']), 2);
    $tabEmpTotalCot['EMPTotalCotisations'] = 
        round(($tabEmpTotalCot['EMPSousTotal_01'] + $tabEmpTotalCot['EMPSousTotal_02'] - $deductionforfaitaire), 2);
    /* COUT POUR L'EMPLOYEUR BRUT + CHARGES */
    $tabEmpTotalCot['EMPCoutTotal'] = round(($salaireBrut + $tabEmpTotalCot['EMPTotalCotisations']), 2);
    /* COUT POUR L'EMPLOYEUR APRES ABATEMENT DE 50% */
    $tabEmpTotalCot['EMPCoutAbat'] = round(($tabEmpTotalCot['EMPCoutTotal'] / 2), 2);

    return $tabEmpTotalCot;
    
}
/**
 * Fonction qui construit le tableau contenant les sommes bassées sur les cotisations employeur
 * pour DOM
 * 
 * @param type $salaireBrut
 * @return type array
 */
function calcul_cot_total_emp_dom ($salaireBrut, $deductionforfaitaire = 2) {
    $tabCotEmp=  calcul_cotisations_employeur_dom($salaireBrut);
    $tabEmpTotalCot['DeductionForfait']=$deductionforfaitaire;
    $tabEmpTotalCot['EMPSousTotal_01'] = round(($tabCotEmp['EMPMaladie01'] + $tabCotEmp['EMPAssVieillesse'] +
        $tabCotEmp['EMPVieillessePlaf'] + $tabCotEmp['EMPAccTravail'] + $tabCotEmp['EMPAllocFam']), 2);
    $tabEmpTotalCot['EMPSousTotal_02'] = round(($tabCotEmp['ARRCO'] + $tabCotEmp['EMPAGFF'] + $tabCotEmp['EMPAssuChomage'] +
         $tabCotEmp['EMPContriSoliAuto'] + $tabCotEmp['EMPFormationPro'] + $tabCotEmp['EMPFondNatLogement'] +
        $tabCotEmp['OrgSyn']), 2);
    $tabEmpTotalCot['EMPTotalCotisations'] =
        round(($tabEmpTotalCot['EMPSousTotal_01'] + $tabEmpTotalCot['EMPSousTotal_02'] - $deductionforfaitaire), 2);
    /* COUT POUR L'EMPLOYEUR BRUT + CHARGES */
    $tabEmpTotalCot['EMPCoutTotal'] = round(($salaireBrut + $tabEmpTotalCot['EMPTotalCotisations']), 2);
    /* COUT POUR L'EMPLOYEUR APRES ABATEMENT DE 50% */
    $tabEmpTotalCot['EMPCoutAbat'] = round(($tabEmpTotalCot['EMPCoutTotal'] / 2), 2);

    return $tabEmpTotalCot;
}


