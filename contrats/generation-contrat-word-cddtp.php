<?php
/** 
 * Autoloader
 */
require __DIR__.'/../vendor/autoload.php';

/**
 * Include configuration and constant values
 */
require_once 'configuration.php';

use PhpOffice\PhpWord\Settings;


// Turn output escaping on
//Settings::setOutputEscapingEnabled(true);
//Settings::setCompatibility(false);

//valeurs dynamiques à intégrées au contrat
foreach ($_POST as $postName=>$postValue) {
 //echo $postName;
 $$postName= htmlspecialchars($postValue);
}

switch($civiliteEmp){
 case 1:
	$civiliteEmp = 'Monsieur';
 break;
 case 2:
 $civiliteEmp = 'Madame';
 break;
 default:
	$civiliteEmp = '';
 break;
}
switch($civiliteSal){
 case 1:
	$civiliteSal = 'Monsieur';
 break;
 case 2:
 $civiliteSal = 'Madame';
 break;
 default:
	$civiliteSal = '';
 break;
}
//var_dump($emploiRepere);
$listER=explode(',',$emploiRepere);
//var_dump($listER);
foreach ($listER as $ER) {
    $listNomER[]=$tabAllER[$ER];
    
}
$nomER=implode(', ',$listNomER);

// Creating the new document...
$phpWord = new \PhpOffice\PhpWord\PhpWord();
//$phpWord->getCompatibility()->setOoxmlVersion(15);

//properties
$nomContrat=$tabNomContratPdf[$type];
$titleDoc=str_replace("<br />"," ",$nomContrat);
list($titleDoc1,$titleDoc2)= explode("<br />", $nomContrat);
$properties = $phpWord->getDocInfo();
$properties->setCompany('FEPEM');
$properties->setTitle($titleDoc);
$properties->setCreated(time());

$phpWord->setDefaultFontName('Times New Roman');
$phpWord->setDefaultFontSize(12);


//new page
$section = $phpWord->addSection();

///////////////////////////////////////////
$titleTableStyleName = 'Title table';
$titleTableStyle = array( 
    'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 
    'cellMargin' => 10
    );
$subtitleTableStyleName = 'SubTitle table';
$subtitleTableStyle = array(
    'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::START, 
    );
$titleLTableStyleName = "Title table right";
$titleLTableStyle = array(
    'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::END, 
    );
$phpWord->addTableStyle($titleTableStyleName, $titleTableStyle);
$phpWord->addTableStyle($subtitleTableStyleName, $subtitleTableStyle);
$phpWord->addTableStyle($titleLTableStyleName, $titleLTableStyle);
$titleTableCellStyle = array(
    'valign' => 'center', 
    'bgColor' => '428ABD',
    );
$subtitleEmpTableCellStyle = array(
    'valign' => 'center',
    'bgColor' => 'F4A557',
    );
$subtitleSalTableCellStyle = array(
    'valign' => 'center', 
    'bgColor' => '8EAFD8',
    );
$titleCelleHeader = array(
    'valign' => 'center',
    'bgColor' => 'EE7F01',
    );
$cellHCentered = array(
    'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
    'spaceBefore' => 0,
    'spaceAfter' => 0);
$cellLCentered = array(
    'spaceBefore' => 0,
    'spaceAfter' => 0);
$titleTableFontStyle = array(
    'color' => 'ffffff',
    'size' => 16
    );
$subtitleTableFontStyle = array(
    'color' => 'ffffff',
    'size' => 14
    );
$noSpace = array(
    'spaceBefore' => 0,
    'spaceBefore' => 0
    );
$subtitleFontStyleName = 'Inside Subtitle';
$phpWord->addFontStyle($subtitleFontStyleName, array('color' => 'F4A557', 'size' => 12));
$itemFontStyleName = 'Inside Item';
$phpWord->addFontStyle($itemFontStyleName, array('color' => '8EAFD8', 'size' => 12));

$phpWord->addParagraphStyle('pJustify', array('align'=>'both', 'spaceBefore' => 0, 'spaceBefore' => 0));

$linkFontStyleName = 'linkStyle';
$phpWord->addLinkStyle($linkFontStyleName, array('color' => '0000FF', 'underline' => \PhpOffice\PhpWord\Style\Font::UNDERLINE_SINGLE));


////////////////////////////////

$table = $section->addTable($titleTableStyleName);
$table->addRow(200);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(21), $titleTableCellStyle)->addText($titleDoc1, $titleTableFontStyle, $cellHCentered);
$table->addRow(200);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(21), $titleTableCellStyle)->addText($titleDoc2, $titleTableFontStyle, $cellHCentered);

$section->addTextBreak(1);

//emp informations
$table = $section->addTable($subtitleTableStyleName);
$table->addRow(400);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.5), $subtitleEmpTableCellStyle)->addText("", $subtitleTableFontStyle);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(20.5), $subtitleEmpTableCellStyle)->addText("Entre l'employeur :", $subtitleTableFontStyle, $cellLCentered);
$section->addTextBreak(1);
$table = $section->addTable();
$table->addRow();
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(21), array('gridSpan' => 2))->addText($civiliteEmp);
$table->addRow();
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(10.5))->addText("Nom : ".ucfirst($nomEmp));
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(10.5))->addText("Prénom : ".ucfirst($prenomEmp));
$table->addRow();
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(21), array('gridSpan' => 2))->addText("Adresse : ".$adresseEmp);
$table->addRow();
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(10.5))->addText('Code postal : '.$cpoEmp);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(10.5))->addText("Localité : ".$villeEmp);
$table->addRow();
$text="N° d'immatriculation Urssaf : ......................................................... Code NAF : NAF 97 00Z ";
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(15), array('gridSpan' => 2))->addText($text);

$section->addTextBreak(1);

//sal informations
$table = $section->addTable($subtitleTableStyleName);
$table->addRow(400);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.5), $subtitleSalTableCellStyle)->addText("", $subtitleTableFontStyle);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(20.5), $subtitleSalTableCellStyle)->addText("Et le (la) salarié(e) : ", $subtitleTableFontStyle, $cellLCentered);
$section->addTextBreak(1);
$table = $section->addTable();
$table->addRow();
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(21), array('gridSpan' => 2))->addText($civiliteSal);
$table->addRow();
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(10.5))->addText('Nom : '.ucfirst($nomSal));
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(10.5))->addText("Prénom : ".ucfirst($prenomSal));
$table->addRow();
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(21), array('gridSpan' => 2))->addText("Adresse : ".$adresseSal);
$table->addRow();
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(10.5))->addText('Code postal : '.$cpoSal);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(10.5))->addText("Localité : ".$villeSal);
$table->addRow();
$text="N° d'immatriculation Sécurité Sociale :......................................................................................";
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(15), array('gridSpan' => 2))->addText($text);

$section->addText("Il est conclu un contrat de travail régi par les dispositions "
        . "de la convention collective nationale des salariés du particulier "
        . "employeur tenue à la disposition du (de la) salarié(e) qui pourra "
        . "la consulter sur le lieu de travail", null, 'pJustify');
$section->addText("Toute modification de ces textes lui sera notifiée dans le délai d'un mois après sa date d'effet.",
     null,
    'pJustify'
    );
$section->addTextBreak(1, null, $noSpace);

//retraite
$section->addText("Organismes de retraite et prévoyance",
        $subtitleFontStyleName);
$textrun = $section->addTextRun();
$textrun->addText('Les institutions compétentes en matière de retraite et prévoyance sont : <w:br/>'
        . '- Ircem retraite <w:br/>'
        . '- Ircem prévoyance <w:br/>'
        . 'Toutes deux sises : 261 avenue des Nations-Unies – BP 593 – 59 060 ROUBAIX Cedex.',
        'pJustify');

$section->addTextBreak(1, null, $noSpace);

//date d'entrée
$section->addText("Il est convenu ce qui suit :");
$textrun = $section->addTextRun();
$textrun->addText("Date d'entrée : ", $subtitleFontStyleName);
$textrun->addText("....../....../......");

$section->addText("Le(a) salarié(e) est embauché(e) en contrat à durée déterminée à compter du ......./......./...... dans le cadre de ............................", null, 'pJustify');
$section->addText("Le présent contrat est conclu pour une durée de … semaines/mois et prendra automatiquement fin le ......../......../......... inclus. ", null, 'pJustify');

//Période d'essai
$section->addText("Période d'essai :",
        $subtitleFontStyleName);
$section->addText("La durée de la période d' essai est de .................................... ", null, 'pJustify');
$section->addText("S'agissant d'une période de travail effectif, toute suspension qui l'affecterait (maladie, absences, etc.) la prolongerait d'une durée égale.", null, 'pJustify');
$section->addText("Durant cette période d'essai, chacune des parties pourra mettre fin au contrat, sans indemnités.", null, 'pJustify');
$section->addText("En cas de rupture du fait de l'employeur, ce dernier devra respecter un délai de prévenance égal à :", null, 'pJustify');
$section->addText("- 24 heures en deçà de 8 jours de présence du(de la) salarié(e) ;<w:br/>"
        . "- 48 heures entre 8 jours de présence et 1 mois de présence du(de la) salarié(e) ;<w:br/>"
        . "- 2 semaines après un mois de présence du(de la) salarié(e).");

$section->addText("En cas de rupture du fait du (de la) salarié(e), aucun délai de prévenance ne sera à respecter.", null, 'pJustify');

$section->addTextBreak(1, null, $noSpace);

//lieu de travail
$section->addText("Lieu habituel de travail" ,
        $subtitleFontStyleName);
$section->addText("Adresse : .................................................................................................................................... ");
$section->addText("Code postal : ....................... Localité.........................................................................................");
$section->addTextBreak(1, null, $noSpace);
$section->addText("Autre(s) lieu(x) : " ,
        $subtitleFontStyleName);
$section->addText("Adresse : .................................................................................................................................... ");
$section->addText("Code postal : ....................... Localité.........................................................................................");
$section->addText("Si le (la) salarié(e) est appelé(e) à travailler sur un lieu autre que celui habituel, un accord entre "
 . "l'employeur et le(la) salarié(e) en fixera les modalités particulières.",
        null, 'pJustify');
$section->addTextBreak(1, null, $noSpace);

//nature de l'emploi
$section->addText("Nature de l'emploi " ,
        $subtitleFontStyleName);
$textrun = $section->addTextRun();
$textrun->addText("Emploi(s)-Repère(s) : ", $itemFontStyleName);
$textrun->addText($nomER, null, 'pJustify');
$textrun = $section->addTextRun();
$textrun->addText("Descriptif de(s) (l')emploi(s)-repère(s) : ", $itemFontStyleName);
$textrun->addText("Se reporter à la fiche ou aux fiches de(s) emploi(s) repère(s) en annexe du présent contrat.");
$textrun = $section->addTextRun();
$textrun->addText("Echelle de classification : ", $itemFontStyleName);
$textrun = $section->addTextRun();
$textrun->addText("Eventuelles activités complémentaires : ", $itemFontStyleName);
$section->addText(".....................................................................................................................................................");
$section->addText(".....................................................................................................................................................");
$section->addText(".....................................................................................................................................................",
        null, $noSpace);


//durée du travail
$section->addText("Durée du travail hebdomadaire : ........................ heures" ,
        $subtitleFontStyleName);
$section->addText("- Le(la) salarié(e) effectuera ................. heures de travail effectif hebdomadaire, réparties de la façon suivante : ", null, 'pJustify');

$fancyTableStyleName = 'Fancy Table';
$fancyTableStyle = array('borderSize' => 6, 'borderColor' => '000000');
$fancyTableFirstRowStyle = array('borderBottomSize' => 6, 'borderBottomColor' => '000000', 'bgColor' => 'F4A557');
$fancyTableFontStyleHead =  array(
    'color' => 'ffffff'
    );
$fancyTableFontStyle = array(
    'color' => '000000'
    );
$fancyTableCellStyle = array('valign' => 'center');
$phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
$table = $section->addTable($fancyTableStyleName);
$table->addRow(600);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(5), $fancyTableCellStyle)->addText("", $fancyTableFontStyleHead, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("Lundi", $fancyTableFontStyleHead, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("Mardi", $fancyTableFontStyleHead, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("Mercredi", $fancyTableFontStyleHead, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("Jeudi", $fancyTableFontStyleHead, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("Vendredi", $fancyTableFontStyleHead, $cellHCentered);
$table->addRow(1000);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(5), $fancyTableCellStyle)->addText("Amplitude horaire de présence", $fancyTableFontStyle, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("", $fancyTableFontStyle, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("", $fancyTableFontStyle, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("", $fancyTableFontStyle, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("", $fancyTableFontStyle, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("", $fancyTableFontStyle, $cellHCentered);
$table->addRow(1000);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(5), $fancyTableCellStyle)->addText("Travail effectif", $fancyTableFontStyle, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("", $fancyTableFontStyle, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("", $fancyTableFontStyle, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("", $fancyTableFontStyle, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("", $fancyTableFontStyle, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("", $fancyTableFontStyle, $cellHCentered);
$table->addRow(1000);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(5), $fancyTableCellStyle)->addText("Présence responsable", $fancyTableFontStyle, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("", $fancyTableFontStyle, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("", $fancyTableFontStyle, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("", $fancyTableFontStyle, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("", $fancyTableFontStyle, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("", $fancyTableFontStyle, $cellHCentered);
$table->addRow(1000);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(5), $fancyTableCellStyle)->addText("Total travail effectif", $fancyTableFontStyle, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("", $fancyTableFontStyle, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("", $fancyTableFontStyle, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("", $fancyTableFontStyle, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("", $fancyTableFontStyle, $cellHCentered);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3), $fancyTableCellStyle)->addText("", $fancyTableFontStyle, $cellHCentered);

$section->addTextBreak(1, null, $noSpace);
$section->addText("- S'il y a lieu préciser : planning, présence de nuit ...",
        null, $noSpace);
$section->addText("- Périodicité de relevé de situation si horaire irrégulier.",
        null, $noSpace);

//$section->addTextBreak(1, null, $noSpace);

//repos
$section->addText("Repos hebdomadaire" ,
        $subtitleFontStyleName);
$textrun = $section->addTextRun();
$textrun->addText("- Jour habituel de repos hebdomadaire : ...........<w:br/>"
        . "A ce jour de repos hebdomadaire s'ajoutera la demi-journée du .................. dans le cadre de l'aménagement de l'horaire de travail. ",
        'pJustify');

$section->addTextBreak(1, null, $noSpace);

//jour férié
$section->addText("Jours fériés" ,
        $subtitleFontStyleName);
$section->addText("Les jours fériés ordinaires seront :");
$section->addCheckBox('chkBox1', ' Travaillés');
$section->addCheckBox('chkBox2', ' Chômés');

$section->addTextBreak(1, null, $noSpace);

//Rémunération
$section->addText("Rémunération à la date d'embauche : " ,
        $subtitleFontStyleName);
$section->addText("- Salaire brut horaire : ........... €", null, $noSpace);
$section->addText("correspondant à un salaire net horaire : ........... €",
        null, $noSpace);
$section->addTextBreak(1, null, $noSpace);
//new page
$section->addText("- Salaire mensuel brut : ........... €",null, $noSpace);
$section->addText("correspondant à un salaire mensuel net : ........... €",
        null, $noSpace);

$section->addText("- Le (la) salarié(e) étant déclaré par le biais du Cesu, il est expressément convenu entre les parties que :", null, 'pJustify');
$section->addCheckBox('chkBox3', " Le salaire ci-dessus inclut la majoration de 10% au titre des congés payés. En conséquence, il (elle) ne sera pas rémunéré(e) lors de son départ effectif en congés.", null, 'pJustify');
$section->addCheckBox('chkBox4', " Les congés payés sont rémunérés quand ils sont pris");
$section->addTextBreak(1, null, $noSpace);

$section->addText("- Les prestations en nature fournies seront déduites de la rémunération nette, à hauteur de : ");
$section->addCheckBox('chkBox5', " 4.70 euros par repas fourni");
$section->addCheckBox('chkBox6', " 71 euros pour un logement");
$section->addTextBreak(1, null, $noSpace);
$section->addText("- L'employeur prendra en charge, sur présentation des justificatifs, 50 % des frais d'abonnement aux transports en commun engagés par le (la) salarié(e) pour se rendre de son domicile à son lieu de travail.",
        null, 'pJustify');
$section->addTextBreak(1, null, $noSpace);

//conduite
$section->addText("Conduite automobile" ,
        $subtitleFontStyleName);
$section->addText("- Le(la) salarié(e) sera amené(e) à utiliser le véhicule de l'employeur dans le cadre de son activité professionnelle. 
Il lui est attribué un supplément de rémunération de ................... €", null, 'pJustify');
//$textrun = $section->addTextRun();
$section->addText("- Le(la) salarié(e) utilisera son véhicule dans le cadre de son activité professionnelle. Il(elle) présentera, à la signature
du présent contrat et chaque année, l'attestation de son assurance l'autorisant à utiliser son véhicule dans le cadre de son activité professionnelle.
Il lui est attribué un supplément de rémunération de ...................... € et une indemnité kilométrique destinée à compenser les frais 
occasionnés pour les kilomètres parcourus.<w:br/>Choix du barème : .......... ", null,'pJustify');
$section->addText("- Le (la) salarié(e) respectera les règles du code de la route et prendra toutes les mesures assurant la sécurité des passagers.",
        null, 'pJustify');
$section->addTextBreak(1, null, $noSpace);

//nuit
$section->addText("Présence de nuit : ...................... heures par nuit",
        $subtitleFontStyleName);
$section->addText("En application de l'article 6 b) de la convention collective nationale des salariés du particulier employeur, la rémunération du(de la) salarié(e) est calculée sur la base suivante : ................................................. ",
        null, 'pJustify');
$section->addTextBreak(1, null, 'pJustify');

//Absences
$section->addText("Absences",
        $subtitleFontStyleName);
$section->addText("Toute absence doit être justifiée dans les 48 heures. ");

//new page
//congés
$section->addText("Congés payés",
        $subtitleFontStyleName);
$section->addText("Le(a) salarié(e) bénéficie de 2,5 jours ouvrables de congés payés par mois de travail effectif. Ces congés donneront lieu au versement 
    d'une indemnité compensatrice de 10 % des rémunérations perçues (incluant l'indemnité de fin de contrat si le salarié y a droit), sauf en 
    de rémunération par chèque emploi service universel qui inclurait déjà 10% de majoration chaque mois au titre du paiement des congés payés.", null, 'pJustify');
$section->addTextBreak(1, null, $noSpace);

//renouvellement
$section->addText("Renouvellement : ",
        $subtitleFontStyleName);
$section->addText("Le contrat pourra être renouvelé deux fois pour une durée déterminée, dans des conditions qui feront l'objet 
 d'un avenant soumis au (à la) salarié(e) préalablement au terme du présent contrat et préalablement au terme du premier renouvellement. ", null, 'pJustify');
$section->addTextBreak(1, null, $noSpace);

//indemnités
$section->addText("Indemnités de fin de contrat : ",
        $subtitleFontStyleName);
$section->addText("Au terme du présent contrat, le(a) salarié(e) percevra, une indemnité de fin de contrat égale à 10 % de la rémunération brute globale perçue pendant la durée du contrat (sauf exceptions). ", null, 'pJustify');

$section->addTextBreak(1);

$section->addText("Fait à..........................................................le.......................(en 2 exemplaires).");
$section->addTextBreak(1);

//signatures
$section = $phpWord->addSection(
    array(
        'colsNum'   => 2,
        'colsSpace' => 800,
        'breakType' => 'continuous',
    )
);
$textrunCol1 = $section->addTextRun();
$textrunCol1->addText("Signature de l'employeur ",array('bold'=>true) );
$textrunCol1->addText("<w:br/>(précédée de la mention « Lu et approuvé »)", array('size'=>10));
$textrunCol2 = $section->addTextRun(array('alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::END) );
$textrunCol2->addText("Signature du(de la) salarié(e) ",array('bold'=>true) );
$textrunCol2->addText("<w:br/>(précédée de la mention « Lu et approuvé »)", array('size'=>10));

$section = $phpWord->addSection(array('breakType' => 'continuous'));

$section->addPageBreak();


$header = $section->addHeader();
$table = $header->addTable($titleLTableStyleName);

//$table = $section->addTable($titleLTableStyleName);
$table->addRow(300);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(8), $titleCelleHeader)->addText("NOTICE D'ACCOMPAGNEMENT", $subtitleTableFontStyle, $cellHCentered);

//$section->addTextBreak(1, null, $noSpace);
$table = $section->addTable($titleTableStyleName);
$table->addRow(300);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(12), $titleTableCellStyle)->addText("NOTICE D'ACCOMPAGNEMENT AU CONTRAT CDD", $subtitleTableFontStyle, $cellHCentered);
$table->addRow(300);
$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(8), $titleTableCellStyle)->addText("A TERME PRECIS", $subtitleTableFontStyle, $cellHCentered);
$section->addTextBreak(1, null, $noSpace);

$section = $phpWord->addSection(
    array(
        'colsNum'   => 2,
        'colsSpace' => 400,
        'breakType' => 'continuous',
    )
);
$colored=array(
    'color' => 'F4A557'
);
$coloredBold=array(
    'color' => 'F4A557',
    'bold'=> true
);
$underlined=array(
    'underline' => 'single'
);
$bold=array(
    'bold'=> true
);
$italic=array(
    'italic'=>true
);

//$textrunCol1 = $section->addTextRun('pJustify');
$section->addText("Date d'entrée :", $coloredBold);
$section->addText("Le(a) salarié(e) est embauché(e) en contrat à durée déterminée à compter du (Date du premier jour de la relation de travail.) 
dans le cadre de (Indiquer le motif de recours au CDD).",null,'pJustify');
$section->addText("Le présent contrat est conclu pour une durée de ........... semaines/mois et prendra automatiquement fin le (Indiquer le dernier jour de travail) inclus. ",null,'pJustify');

$section->addText("Période d'essai :", $coloredBold);
$section->addText("La durée de la période d'essai est limitée à :");
$section->addText("- 1 jour par semaine de travail dans la limite de deux semaines calendaires si la durée du contrat de travail est inférieure ou égale à six mois ou moins. ", null, 'pJustify');
$section->addText("- 1 mois si la durée du contrat de travail excède six mois. ", null, 'pJustify');
$textrun = $section->addTextRun('pJustify');
$textrun->addText("Attention,", $italic);
$textrun->addText(" il n'est possible de prévoir une période d'essai que si le contrat de travail n'a pas encore commencé à être exécuté (sauf si une lettre d'engagement indiquant la durée de la période d'essai a préalablement été signée entre les parties).");

$text ="Nature de l'emploi :";
$section->addText($text, $coloredBold);
$textrun = $section->addTextRun('pJustify');
$textrun->addText("A titre informatif, l'accord de classification du 21 mars 2014 met en place ");
$textrun->addText("une grille des métiers ", $bold);
$textrun->addText("comprenant ");
$textrun->addText("21 emplois-repères ");
$textrun->addText("(modèles d’emplois qui illustrent les situations de travail les plus courantes) répartis dans 5 domaines d'activités.");

$textrun = $section->addTextRun('pJustify');
$textrun->addText("Pour ");
$textrun->addText("identifier l'emploi du salarié, ", $colored);
$textrun->addText("il convient de ");
$textrun->addText("dresser la liste des activités confiées ", $colored); 
$textrun->addText("et le temps passé pour chaque activité. Il faut ensuite ");
$textrun->addText("choisir le domaine d'activités ", $colored);
$textrun->addText("correspondant à l'activité qui prend le plus de temps. Enfin, ");
$textrun->addText("retenir au sein de ce domaine l’emploi-repère correspondant à l'activité exercée :", $colored);

$textrun = $section->addTextRun('pJustify');
$textrun->addText("- Domaine « Enfant » ", $bold);
$textrun->addText("la garde d’un ou de plusieurs enfants) (cliquez sur : ");
$textrun = $section->addTextRun();
$textrun->addLink("http://www.fepem.fr/documents/10163/1274052/ANNEXE+1+du+domaine+enfant_Avril2016.pdf", "http://www.fepem.fr/documents/10163/1274052/ANNEXE+1+du+domaine+enfant_Avril2016.pdf", $linkFontStyleName);
$textrun->addText(");");

$textrun = $section->addTextRun('pJustify');
$textrun->addText("- Domaine « Adulte » ", $bold);
$textrun->addText("(l'accompagnement d'une personne dans le maintien de son autonomie ou en situation de handicap) (cliquez sur : ");
$textrun = $section->addTextRun();
$textrun->addLink("http://www.fepem.fr/documents/10163/1274052/ANNEXE+2+du+domaine+adulte_Avril2016.pdf", "http://www.fepem.fr/documents/10163/1274052/ANNEXE+2+du+domaine+adulte_Avril2016.pdf", $linkFontStyleName);
$textrun->addText(");");

$textrun = $section->addTextRun('pJustify');
$textrun->addText("- Domaine « Espaces de vie » ", $bold);
$textrun->addText("(notamment l'entretien du domicile : ménage, repassage) (cliquez sur : ");
$textrun = $section->addTextRun();
$textrun->addLink("http://www.fepem.fr/documents/10163/1274052/ANNEXE+3+domaine+espaces+de+vie+_Avril2016.pdf", "http://www.fepem.fr/documents/10163/1274052/ANNEXE+3+domaine+espaces+de+vie+_Avril2016.pdf", $linkFontStyleName);
$textrun->addText(");");

$textrun = $section->addTextRun('pJustify');
$textrun->addText("- Domaine « Environnement technique » ", $bold);
$textrun->addText("(notamment secrétariat particulier, enseignement particulier, assistance informatique) (cliquez sur : ");
$textrun = $section->addTextRun();
$textrun->addLink("http://www.fepem.fr/documents/10163/1274052/ANNEXE+4+domaine+environnement+technique_Avril2016.pdf", "http://www.fepem.fr/documents/10163/1274052/ANNEXE+4+domaine+environnement+technique_Avril2016.pdf", $linkFontStyleName);
$textrun->addText(");");

$textrun = $section->addTextRun('pJustify');
$textrun->addText("- Domaine « Environnement externe » ", $bold);
$textrun->addText("(la réalisation d’activités de petits travaux de bricolage, petits travaux de jardinage, gardiennage) (cliquez sur : ");
$textrun = $section->addTextRun();
$textrun->addLink("http://www.fepem.fr/documents/10163/1274052/ANNEXE+5+domaine+environnement+externe_Avril2016.pdf", "http://www.fepem.fr/documents/10163/1274052/ANNEXE+5+domaine+environnement+externe_Avril2016.pdf", $linkFontStyleName);
$textrun->addText(");");

$section->addText("Particularités :", $italic);
$section->addText("Lorsque les activités concernent plusieurs domaines, et que l'une d'elles consiste en :", null, 'pJustify');
$section->addText("- l'accompagnement d’une personne adulte (domaine « Adulte ») ;", null, 'pJustify');
$section->addText("- ou en la garde d'enfant(s) de moins de 3 ans (domaine « Enfant ») ;) ;", null, 'pJustify');
$section->addText("=> Cette activité auprès de personnes fragiles est assimilée à l'activité principale. 
Dans ce cas, il faut retenir l’un de ces 2 domaines d’activités, indépendamment du temps consacré à l'activité et choisir l'un des emplois-repères d’assistant(e) de vie du domaine « Adulte » ou l'un des emplois-repères de garde d'enfant(s) du domaine « Enfant » (Enfant de moins de 3 ans). ", null, 'pJustify');

$textrun = $section->addTextRun('pJustify');
$textrun->addText("S'il y a ");
$textrun->addText("plusieurs activités principales de durée équivalente,", $underlined);
$textrun->addText(" il faut retenir l'ensemble des emplois-repères correspondant (les mentionner dans le contrat de travail) et l'échelle la plus élevée de ces emplois-repères (à mentionner également dans le contrat de travail)");

$textrun = $section->addTextRun('pJustify');
$textrun->addText("S'il y a ");
$textrun->addText("des activités complémentaires ", $underlined);
$textrun->addText("aux activités de l'emploi-repère retenu, (c'est-à-dire des activités qui ne figurent pas dans la liste de l'emploi-repère retenu mais qui sont confiées au salarié) les lister dans le contrat de travail.");
$section->addText("Les activités complémentaires ne donnent pas lieu à majoration de salaire sauf négociation entre les parties.", null, 'pJustify'); 

$textrun = $section->addTextRun('pJustify');
$textrun->addText("Il convient enfin de retenir le niveau de ");
$textrun->addText("l'échelle ", $colored);
$textrun->addText("correspondant à l'emploi-repère retenu et de la mentionner dans le contrat de travail. Pour consulter la grille cliquez sur : ");
$textrun->addLink("http://www.fepem.fr/documents/10163/1274052/Grille+des+metiers_FEPEM2016.pdf", "http://www.fepem.fr/documents/10163/1274052/Grille+des+metiers_FEPEM2016.pdf", $linkFontStyleName);
$textrun->addText(".");


$section->addText("Durée du travail hebdomadaire :",$coloredBold);
$section->addText("La durée du travail est limitée à 48 heures par semaine sur une période de 12 semaines consécutives. Quoi qu'il en soit, la durée hebdomadaire de travail ne peut excéder 50 heures au cours d'une même semaine."
        , null, 'pJustify'); 


$section->addText("Présence responsable", $underlined);
$section->addText("Les heures de présence responsable sont celles où le salarié peut utiliser son temps pour lui-même tout en restant vigilant pour intervenir, s'il y a lieu.",null, 'pJustify');
$section->addText("Possible uniquement pour les postes d'emploi à caractère familial.",null, 'pJustify');
$section->addText("1 heure de présence responsable équivaut à 2/3 d'une heure de travail effectif.",null, 'pJustify');

$section->addText("Repos hebdomadaire :",$coloredBold);
$section->addText("Prévoir une demi-journée supplémentaire. Le samedi après-midi par exemple. ",null, 'pJustify');

$section->addText("Rémunération à la date d'embauche :",$coloredBold);
$section->addText("Il convient d'indiquer le salaire horaire brut minimum conventionnel correspondant au niveau de l'échelle de l'emploi-repère retenu.",null, 'pJustify');
$section->addText("Il n'est pas obligatoire de mentionner les salaires nets.",null, 'pJustify');

$section->addText("Modalités de rémunération des congés payés dans le cadre du Cesu déclaratif",$underlined, 'pJustify');

$section->addText("Si le salarié travaille moins de 32/h/mois, le salaire inclut la majoration de 10% au titre du paiement des congés payés.",null, 'pJustify');
$section->addText("Si le salarié travaille 32h ou plus/mois (sauf en cas de volet social Cesu papier), les congés payés sont rémunérés quand ils sont pris sauf accord au contrat entre les parties prévoyant que le salaire soit majoré de 10% au titre des congés payés.",null,'pJustify');

$section->addText("Frais d'abonnement aux transports en commun",$underlined, 'pJustify');
$section->addText("Remboursement à hauteur de 50% si le salarié travaille au moins 17h30 par semaine. En deçà, il convient d'appliquer un prorata.<w:br/>", null, 'pJustify');


$section = $phpWord->addSection(array('breakType' => 'continuous'));
$section = $phpWord->addSection(
    array(
        'colsNum'   => 2,
        'colsSpace' => 400,
        'breakType' => 'nextColumn',
    )
);
$section->addText("Conduite automobile :",$coloredBold);
$section->addText("Il existe deux possibilités :<w:br/>
- barème minimal : barème des fonctionnaires <w:br/>
- barème maximal : barème fiscal. Au-delà de ce barème, les sommes versées sont réintégrées dans le salaire et soumises à cotisations.", null, 'pJustify'); 

$section->addText("Présence de nuit :",$coloredBold);
$section->addText("Indemnité forfaitaire au moins égale à 1/6ème du salaire conventionnel minimal pour une même durée de travail effectif.",  null, 'pJustify'); 

$section->addText("Renouvellement :" ,$coloredBold);
$section->addText("L'employeur peut renouveler le contrat à durée déterminée dont le terme est précis à deux reprises.");

$section->addText("Le double renouvellement ne devra pas déroger à la durée maximale de 18 mois prévue par la loi (sauf exceptions).", null, 'pJustify');

$section->addTextBreak(1, null, $noSpace);
$section->addImage('img/logo-fepem.png', array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
$section->addTextBreak(1, null, $noSpace);

$section->addText("Besoin d’informations ?", $colored);
$section->addText("Appelez le 0 805 292 292 (appel et service gratuits)", null, 'pJustify');

$textrun=$section->addTextRun('pJustify');
$textrun->addText("Nos conseillers vous répondent aussi sur votre Espace Particulier Employeur accessible ici : " );
$textrun->addLink("http://reseau.fepem.fr", "http://reseau.fepem.fr", $linkFontStyleName);
$textrun->addText(".");
//$section->addText("Nos conseillers vous répondent sur votre Espace Particulier Employeur.", null, 'pJustify');

$section->addText("Besoin d'être accompagné dans la rédaction de votre contrat de travail ?", $colored);
$section->addText("Souscrivez une consultation et obtenez un contrat de travail adapté à vos besoins, validé par le service juridique de la FEPEM", null, 'pJustify');





//output
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment;filename="'.$titleDoc.'.docx"');
header('Cache-Control: max-age=0');
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
//$objWriter->save('helloWorld.docx','Word2007');
$objWriter->save('php://output');



