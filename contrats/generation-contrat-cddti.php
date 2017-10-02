<?php
/**
* Génération du PDF pour le contrat CDD à terme imprécis
*/

/**
 * Include configuration and constant values
 */
require_once 'configuration.php';

/**
 * Include the main TCPDF library 
 */
require_once(dirname(dirname( __FILE__ )).'/lib/tcpdf/tcpdf.php');
/**
 * Include the main FPDI library : addon to include existing pdf
 */
require_once(dirname(dirname( __FILE__ )).'/lib/fpdi/fpdi.php');


//valeurs dynamiques à intégrées au contrat
foreach ($_POST as $postName=>$postValue) {
 //echo $postName;
 $$postName= htmlspecialchars($postValue);
}
//$typeContrat=htmlspecialchars($_POST['type']);
$nomContrat=$tabNomContratPdf[$type];
$titlePdf=str_replace("<br />"," ",$nomContrat);
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

$listER=explode(',',$emploiRepere);
foreach ($listER as $ER) {
    $listNomER[]=$tabAllER[$ER];
    
}
$nomER=implode(',',$listNomER);


// create new PDF document
$pdf = new FPDI(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true,'UTF-8', false);

// set document information
$pdf->SetTitle($titlePdf);
$pdf->SetKeywords('PDF, contrat, modèle, particulier employeur, assistant maternel', 'cdd','cdi');
// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetLeftMargin(20);
$pdf->SetRightMargin(20);
$pdf->SetTopMargin(25);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 20);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set default font subsetting mode
$pdf->setFontSubsetting(true);


/****************page 1 *************/
$pdf->AddPage();

$pdf->SetFont('times', '', 14, '', true);
$pdf->SetFillColor(67, 139, 190);
$pdf->SetTextColor(0,0,0,0);
$pdf->writeHTMLCell('','','','',$nomContrat,0,1,true,true,'C');
$pdf->ln(5);
//section employeur
$pdf->SetFillColor(245, 166, 88);
$pdf->writeHTMLCell('','','','',"Entre l'employeur : ",0,1,true,true,'L');
$pdf->SetFont('times', '', 11, '', true);
$pdf->SetTextColor(0,0,0);
$pdf->ln(5);
$pdf->writeHTMLCell('','','','',$civiliteEmp,0,1,false,true,'L');
$pdf->ln(1);
$pdf->writeHTMLCell('','','','','Nom : '.ucfirst($nomEmp),0,0,false,true,'L');
$pdf->writeHTMLCell('','',100,'',"Prénom : ".ucfirst($prenomEmp),0,1,false,true,'L');
$pdf->ln(1);
$pdf->writeHTMLCell('','','','',"Adresse : ".$adresseEmp,0,1,false,true,'L');
$pdf->ln(1);
$pdf->writeHTMLCell('','','','','Code postal : '.$cpoEmp,0,0,false,true,'L');
$pdf->writeHTMLCell('','',100,'',"Localité : ".$villeEmp,0,1,false,true,'L');
$pdf->ln(1);
$textEmp="N° d'immatriculation Urssaf : .................................................................................. Code NAF : NAF 97 00Z ";
$pdf->Write(1,$textEmp,'', 0,'L',1);
$pdf->ln(5);

//section salarié
$pdf->SetFont('times', '', 14, '', true);
$pdf->SetTextColor(0,0,0,0);
$pdf->SetFillColor(142, 176, 216);
$pdf->writeHTMLCell('','','','',"Et le (la) salarié(e) : ",0,1,true,true,'L');
$pdf->SetFont('times', '', 11, '', true);
$pdf->SetTextColor(0,0,0);
$pdf->ln(5);
$pdf->writeHTMLCell('','','','',$civiliteSal,0,1,false,true,'L');
$pdf->ln(1);
$pdf->writeHTMLCell('','','','','Nom : '.ucfirst($nomSal),0,0,false,true,'L');
$pdf->writeHTMLCell('','',100,'',"Prénom : ".ucfirst($prenomSal),0,1,false,true,'L');
$pdf->ln(1);
$pdf->writeHTMLCell('','','','',"Adresse : ".$adresseSal,0,1,false,true,'L');
$pdf->ln(1);
$pdf->writeHTMLCell('','','','','Code postal : '.$cpoSal,0,0,false,true,'L');
$pdf->writeHTMLCell('','',100,'',"Localité : ".$villeSal,0,1,false,true,'L');
$pdf->ln(1);
$textSal="N° d'immatriculation Sécurité Sociale : ............................................................................................................";
$pdf->Write(1,$textSal,'', 0,'L',1);
$pdf->ln(5);

$textSubCoord="<p>Il est conclu un contrat de travail régi par les dispositions "
        . "de la convention collective nationale des salariés du particulier "
        . "employeur tenue à la disposition du (de la) salarié(e) qui pourra "
        . "la consulter sur le lieu de travail.</p>";
$pdf->writeHTMLCell('','','','',$textSubCoord,0,1,0,true,'J',true, false);
$textSubCoord2="<p>Toute modification de ces textes lui sera notifiée dans le délai d'un mois après sa date d'effet.</p>";
$pdf->writeHTMLCell('','','','',$textSubCoord2,0,1,0,true,'J',true, false);
$pdf->ln(5);

//retraite
$pdf->SetTextColor(239,137,20);
$pdf->writeHTMLCell('','','','',"Organismes de retraite et prévoyance",0,1,0,true,'L',true, false);
$pdf->ln(2);
$textRetraite="Les institutions compétentes en matière de retraite et prévoyance sont : <br>
   - Ircem retraite<br> 
 - Ircem prévoyance <br>
Toutes deux sises : 261 avenue des Nations-Unies – BP 593 – 59 060 ROUBAIX Cedex. ";
$pdf->SetTextColor(0, 0, 0);
$pdf->writeHTMLCell('','','','',$textRetraite,0,1,0,true,'J',true, false);
$pdf->ln(5);

//date entrée
$pdf->writeHTMLCell('','','','',"Il est convenu ce qui suit :",0,1,0,true,'J',true, false);
$pdf->ln(2);
$pdf->SetTextColor(239,137,20);
$pdf->writeHTMLCell('','','','',"Date d'entrée : ",0,0,false,true,'L',true, false);
$pdf->SetTextColor(0, 0, 0);
$pdf->writeHTMLCell('','','48','',"....../....../......",0,1,0,true,'L',true, false);
$pdf->ln(2);
$textDE1="Le(a) salarié(e) est embauché(e) en contrat à durée déterminée à compter du ......./......./...... dans le cadre du remplacement de Monsieur/Madame ............................................ embauché(e) 
    en qualité de............................................, absent(e) pour cause de ......................................................................";
$pdf->writeHTMLCell('','','','',$textDE1,0,1,0,true,'J',true, false);
$pdf->ln(5);
$textDE2="Le présent contrat est conclu pour une durée minimale de ................................. semaines/mois.";
$pdf->writeHTMLCell('','','','',$textDE2,0,1,0,true,'J',true, false);
$pdf->ln(5);
$textDE3="Si l'absence de Monsieur/Madame .........................................................................  se prolongeait au-delà de 
  la durée minimale envisagée par le présent contrat, celui-ci se poursuivrait jusqu’au ................................................................ du retour de Monsieur/Madame 
  ..................................................................... qui constituerait alors le terme automatique du contrat. ";
$pdf->writeHTMLCell('','','','',$textDE3,0,1,0,true,'J',true, false);
$pdf->ln(5);

//période d'essai
$pdf->SetTextColor(239,137,20);
$pdf->writeHTMLCell('','','','',"Période d'essai :",0,1,0,true,'L',true, false);
$pdf->ln(2);
$pdf->SetTextColor(0, 0, 0);
$textPE="La durée de la période d' essai est de .................................... <br>
S'agissant d'une période de travail effectif, toute suspension qui l'affecterait (maladie, absences, etc.) la prolongerait d'une durée égale.<br>
";
$pdf->writeHTMLCell('','','','',$textPE,0,1,0,true,'J',true, false);


/*****************page 2*****************/
$pdf->AddPage();

$textPE2="Durant cette période d'essai, chacune des parties pourra mettre fin au contrat, sans indemnités.<br>
<br>
En cas de rupture du fait de l' employeur, ce dernier devra respecter un délai de prévenance égal à : <br>
- 24 heures en deçà de 8 jours de présence du (de la) salarié(e) ; <br>
- 48 heures entre 8 jours de présence et 1 mois de présence du (de la) salarié(e) ; <br>
- 2 semaines après un mois de présence du (de la) salarié(e). <br>
<br>
En cas de rupture du fait du (de la) salarié(e), aucun délai de prévenance ne sera à respecter.";
$pdf->writeHTMLCell('','','','',$textPE2,0,1,0,true,'J',true, false);
$pdf->ln(5);

//lieu de travail
$pdf->SetTextColor(239,137,20);
$pdf->writeHTMLCell('','','','',"Lieu habituel de travail ",0,1,false,true,'L',true, false);
$pdf->ln(1);
$pdf->SetTextColor(0, 0, 0);
$pdf->writeHTMLCell('','','','',"Adresse : ............................................................................................................................................................ ",0,1,false,true,'L',true, false);
$pdf->ln(1);
$pdf->writeHTMLCell('','','','',"Code postal : .................................. Localité......................................................................................................",0,1,0,true,'L',true, false);
$pdf->ln(5);
$pdf->SetTextColor(239,137,20);
$pdf->writeHTMLCell('','','','',"Autre(s) lieu(x) : ",0,1,false,true,'L',true, false);
$pdf->ln(1);
$pdf->SetTextColor(0, 0, 0);
$pdf->writeHTMLCell('','','','',"Adresse : ............................................................................................................................................................ ",0,1,false,true,'L',true, false);
$pdf->ln(1);
$pdf->writeHTMLCell('','','','',"Code postal : .................................. Localité......................................................................................................",0,1,0,true,'L',true, false);
$pdf->ln(2);
$textLieu="<p>Si le (la) salarié(e) est appelé(e) à travailler sur un lieu autre que celui habituel, un accord entre "
 . "l'employeur et le(la) salarié(e) en fixera les modalités particulières.</p>";
$pdf->writeHTMLCell('','','','',$textLieu,0,1,0,true,'J',true, false);
$pdf->ln(5);

//nature de l'emploi
$pdf->SetTextColor(239,137,20);
$pdf->writeHTMLCell('','','','',"Nature de l'emploi ",0,1,false,true,'L',true, false);
$pdf->ln(1);
$pdf->SetTextColor(67, 139, 190);
$pdf->writeHTMLCell('','','','',"Emploi(s)-Repère(s) : ",0,0,false,true,'L',true, false);
$pdf->SetTextColor(0,0,0);
$pdf->writeHTMLCell('','','60','',$nomER,0,1,false,true,'L',true, false);
$pdf->ln(2);
$pdf->SetTextColor(67, 139, 190);
$pdf->writeHTMLCell('','','','',"Descriptif de(s) (l')emploi(s)-repère(s) : ",0,0,false,true,'J',true, false);
$pdf->SetTextColor(0,0,0);
$pdf->writeHTMLCell('','',85,'',"Se reporter à la fiche ou aux fiches de(s) emploi(s) repère(s) en annexe du présent contrat ",0,1,false,true,'L',true, false);
/*$pdf->writeHTMLCell('','','','',"Se reporter au(x) fiche(s) emploi repère correspondante(s) à annexer au présent contrat : ",0,1,false,true,'L',true, false);
foreach($listER as $ER) {
    $textLien='<a href="http://'.$_SERVER['SERVER_NAME'].'/contrats/fiches/emploi-repere-'.$ER.'.pdf" target="_blank">'.$tabAllER[$ER].'</a>';
    $pdf->writeHTMLCell('','','25','','- '.$textLien,0,1,false,true,'L',true, false);
}*/
$pdf->ln(2);
$pdf->SetTextColor(67, 139, 190);
$pdf->writeHTMLCell('','','','',"Echelle de classification : ",0,0,false,true,'L',true, false);
$pdf->SetTextColor(0,0,0);
$pdf->writeHTMLCell('','','100','',"",0,1,false,true,'L',true, false);
$pdf->ln(2);
$pdf->SetTextColor(67, 139, 190);
$pdf->writeHTMLCell('','','','',"Eventuelles activités complémentaires : ",0,1,false,true,'L',true, false);
$pdf->SetTextColor(0,0,0);
$pdf->writeHTMLCell('','','','',".......................................................................................................................................................................... ",0,1,false,true,'L',true, false);
$pdf->writeHTMLCell('','','','',".......................................................................................................................................................................... ",0,1,false,true,'L',true, false);
$pdf->writeHTMLCell('','','','',".......................................................................................................................................................................... ",0,1,false,true,'L',true, false);
$pdf->ln(5);

//heures de travail
$pdf->SetTextColor(239,137,20);
$pdf->writeHTMLCell('','','','',"Durée du travail hebdomadaire : ............. heures",0,1,false,true,'L',true, false);
$pdf->ln(1);
$pdf->SetTextColor(0,0,0);
$pdf->writeHTMLCell('','','','',"- Le(la) salarié(e) effectuera ........ heures de travail effectif hebdomadaire, réparties de la façon suivante : ",0,1,false,true,'L',true, false);
$pdf->ln(5);

/***********************page 3 ***********************/
$pdf->AddPage();
//tableau
//entete
$pdf->SetFillColor(239,137,20);
$pdf->SetTextColor(0, 0, 0,0);
$pdf->writeHTMLCell(30, 7, '','',"", 0, 0,0,1,'C');
$pdf->writeHTMLCell(25, 7, 50,'',"Lundi", 1, 0,1,1,'C',true);
$pdf->writeHTMLCell(25, 7, 75,'',"Mardi", 1, 0,1,1,'C');
$pdf->writeHTMLCell(25, 7, 100,'',"Mercredi",1, 0,1,1,'C');
$pdf->writeHTMLCell(25, 7, 125,'',"Jeudi", 1, 0,1,1,'C');
$pdf->writeHTMLCell(25, 7, 150,'',"Vendredi", 1, 1,1,1,'C');
$pdf->SetTextColor(0, 0, 0);
//1ere ligne
$pdf->writeHTMLCell(30, 25, '','',"<br><br>Amplitude <br> horaire de <br> présence",1, 0,0,1,'C');
$pdf->writeHTMLCell(25, 25, 50,'',"", 1, 0,0,1,'C');
$pdf->writeHTMLCell(25, 25, 75,'', "",1, 0,0,1,'C');
$pdf->writeHTMLCell(25, 25, 100,'', "",1, 0,0,1,'C');
$pdf->writeHTMLCell(25, 25, 125,'', "",1, 0,0,1,'C');
$pdf->writeHTMLCell(25, 25, 150,'',"",1, 1,0,1,'C');
//2ème ligne
$pdf->writeHTMLCell(30, 25, '','',"<br><br><br>Travail effectif",1, 0,0,1,'C');
$pdf->writeHTMLCell(25, 25, 50,'',"", 1, 0,0,1,'C');
$pdf->writeHTMLCell(25, 25, 75,'', "",1, 0,0,1,'C');
$pdf->writeHTMLCell(25, 25, 100,'', "",1, 0,0,1,'C');
$pdf->writeHTMLCell(25, 25, 125,'', "",1, 0,0,1,'C');
$pdf->writeHTMLCell(25, 25, 150,'',"",1, 1,0,1,'C');
//3ème ligne
$pdf->writeHTMLCell(30, 25, '','',"<br><br>Présence <br>responsable",1, 0,0,1,'C');
$pdf->writeHTMLCell(25, 25, 50,'',"", 1, 0,0,1,'C');
$pdf->writeHTMLCell(25, 25, 75,'', "",1, 0,0,1,'C');
$pdf->writeHTMLCell(25, 25, 100,'', "",1, 0,0,1,'C');
$pdf->writeHTMLCell(25, 25, 125,'', "",1, 0,0,1,'C');
$pdf->writeHTMLCell(25, 25, 150,'',"",1, 1,0,1,'C');
//4ème ligne
$pdf->writeHTMLCell(30, 30, '','',"<br><br><br>Total travail <br>effectif",1, 0,0,1,'C');
$pdf->writeHTMLCell(25, 30, 50,'',"", 1, 0,0,1,'C');
$pdf->writeHTMLCell(25, 30, 75,'', "",1, 0,0,1,'C');
$pdf->writeHTMLCell(25, 30, 100,'', "",1, 0,0,1,'C');
$pdf->writeHTMLCell(25, 30, 125,'', "",1, 0,0,1,'C');
$pdf->writeHTMLCell(25, 30, 150,'',"",1, 1,0,1,'C');

$pdf->ln(5);
$pdf->SetTextColor(0, 0, 0);
$pdf->writeHTMLCell('','','','',"- S' il y a lieu préciser : planning, présence de nuit ...<br>- Périodicité de relevé de situation si horaire irrégulier.",0,1,false,true,'L',true, false);
$pdf->ln(5);

//repos
$pdf->SetTextColor(239,137,20);
$pdf->writeHTMLCell('','','','',"Repos hebdomadaire",0,1,false,true,'L',true, false);
$pdf->ln(1);
$pdf->SetTextColor(0,0,0);
$pdf->writeHTMLCell('','','','',"Jour habituel de repos hebdomadaire : ...........<br>A ce jour de repos hebdomadaire s'ajoutera la demi-journée du .................. dans le cadre de l'aménagement de l'horaire de travail. ",0,1,false,true,'J',true, false);
$pdf->ln(5);

//jours fériés
$pdf->SetTextColor(239,137,20);
$pdf->writeHTMLCell('','','','',"Jours fériés",0,1,false,true,'L',true, false);
$pdf->ln(1);
$pdf->SetTextColor(0,0,0);
$pdf->writeHTMLCell('','','','',"Les jours fériés ordinaires seront : ",0,1,false,true,'L',true, false);
$pdf->ln(1);
$pdf->writeHTMLCell('','','','',"Travaillés",0,0,false,true,'L',true, false);
$pdf->Image('img/checkbox_false.png','40','',4,4,'PNG','','',false,72,'',false,false,0,true);
$pdf->writeHTMLCell('','','80','',"Chômés",0,0,false,true,'L',true, false);
$pdf->Image('img/checkbox_false.png','100','',4,4,'PNG','','N',false,72,'',false,false,0,true);
$pdf->ln(5);

//Rémunération 
$pdf->SetTextColor(239,137,20);
$pdf->writeHTMLCell('','','','',"Rémunération à la date d'embauche : ",0,1,false,true,'L',true, false);
$pdf->ln(1);
$pdf->SetTextColor(0,0,0);
$pdf->writeHTMLCell('','','','',"- Salaire brut horaire : ........... €",0,1,false,true,'L',true, false);
$pdf->ln(1);
$pdf->writeHTMLCell('','','','',"correspondant à un salaire net horaire : ........... €",0,1,false,true,'L',true, false);
$pdf->ln(5);
$pdf->writeHTMLCell('','','','',"- Salaire mensuel brut : ........... €",0,1,false,true,'L',true, false);
$pdf->ln(1);
$pdf->writeHTMLCell('','','','',"correspondant à un salaire mensuel net : ........... €",0,1,false,true,'L',true, false);
$pdf->ln(5);
$pdf->writeHTMLCell('','','','',"- Le (la) salarié(e) étant déclaré par le biais du Cesu, il est expréssément convenu entre les parties que :",0,1,false,true,'J',true, false);
$pdf->ln(1);
$pdf->Image('img/checkbox_false.png',25,'',4,4,'PNG','','T',false,72,'',false,false,0,true);
$pdf->writeHTMLCell('','',30,'',"Le salaire ci-dessus inclut la majoration de 10% au titre des congés payés. En conséquence, il (elle) ne sera pas rémunéré(e) lors de son départ effectif en congés.",0,1,false,true,'J',true, false);
$pdf->ln(1);
$pdf->Image('img/checkbox_false.png',25,'',4,4,'PNG','','T',false,72,'',false,false,0,true);
$pdf->writeHTMLCell('','','30','',"Les congés payés sont rémunérés quand il sont pris",0,1,false,true,'J',true, false);

/*************** page 4 **************/
$pdf->AddPage();
$pdf->writeHTMLCell('','','','',"- Les prestations en nature fournies seront déduites de la rémunération nette, à hauteur de : ",0,1,false,true,'J',true, false);
$pdf->ln(1);
$pdf->Image('img/checkbox_false.png',25,'',4,4,'PNG','','',false,72,'',false,false,0,true);
$pdf->writeHTMLCell('','',30,'',"4.70 euros par repas fourni",0,1,false,true,'J',true, false);
$pdf->ln(1);
$pdf->Image('img/checkbox_false.png',25,'',4,4,'PNG','','',false,72,'',false,false,0,true);
$pdf->writeHTMLCell('','',30,'',"71 euros pour un logement",0,1,false,true,'J',true, false);
$pdf->ln(5);

$textRemun="- L'employeur prendra en charge, sur présentation des justificatifs, 50 % des frais 
 d'abonnement aux transports en commun engagés par le (la) salarié(e) pour se rendre de 
 son domicile à son lieu de travail.";
$pdf->writeHTMLCell('','','','',$textRemun,0,1,false,true,'J',true, false);
$pdf->ln(5);

//auto
$pdf->SetTextColor(239,137,20);
$pdf->writeHTMLCell('','','','',"Conduite automobile",0,1,false,true,'L',true, false);
$pdf->ln(1);
$pdf->SetTextColor(0,0,0);
$textAuto1="- Le(la) salarié(e) sera amené(e) à utiliser le véhicule de l'employeur dans le cadre de son activité professionnelle. 
 Il lui est attribué un supplément de rémunération de ....................... €";
$pdf->writeHTMLCell('','','','',$textAuto1,0,1,false,true,'J',true, false);
$pdf->ln(5);
$textAuto2="- Le(la) salarié(e) utilisera son véhicule dans le cadre de son activité professionnelle. Il(elle) présentera, à la signature 
 du présent contrat et chaque année, l'attestation de son assurance l'autorisant à utiliser son véhicule dans le cadre de son activité professionnelle.
 Il lui est attribué un supplément de rémunération de ....................... € et une indemnité kilométrique destinée à compenser les frais 
 occasionnés pour les kilomètres parcourus. <br>Choix du barème : .......... ";
$pdf->writeHTMLCell('','','','',$textAuto2,0,1,false,true,'J',true, false);
$pdf->ln(5);
$pdf->writeHTMLCell('','','','',"- Le (la) salarié(e) respectera les règles du code de la route et prendra toutes les mesures assurant la sécurité des passagers",0,1,false,true,'J',true, false);
$pdf->ln(5);

//nuit
$pdf->SetTextColor(239,137,20);
$pdf->writeHTMLCell('','','','',"Présence de nuit : ................... heures par nuit",0,1,false,true,'L',true, false);
$pdf->ln(1);
$pdf->SetTextColor(0,0,0);
$textNuit="En application de l'article 6 b) de la convention collective nationale des salariés du particulier employeur, 
 la rémunération du(de la) salarié(e) est calculée sur la base suivante : ................................................. ";
$pdf->writeHTMLCell('','','','',$textNuit,0,1,false,true,'J',true, false);
$pdf->ln(5);


//absences
$pdf->SetTextColor(239,137,20);
$pdf->writeHTMLCell('','','','',"Absences : ",0,1,false,true,'L',true, false);
$pdf->ln(1);
$pdf->SetTextColor(0,0,0);
$pdf->writeHTMLCell('','','','',"Toute absence doit être justifiée dans les 48 heures. ",0,1,false,true,'J',true, false);
$pdf->ln(5);

//congés
$pdf->SetTextColor(239,137,20);
$pdf->writeHTMLCell('','','','',"Congés payés : ",0,1,false,true,'L',true, false);
$pdf->ln(1);
$pdf->SetTextColor(0,0,0);
$textConges="Le(a) salarié(e) bénéficie de 2,5 jours ouvrables de congés payés par mois de travail effectif. Ces congés donneront lieu au versement 
d'une indemnité compensatrice de 10 % des rémunérations perçues (incluant l'indemnité de fin de contrat si le salarié y a droit), sauf en 
cas de rémunération par chèque emploi service universel qui inclurait déjà 10% de majoration chaque mois au titre du paiement des congés payés.";
$pdf->writeHTMLCell('','','','',$textConges,0,1,false,true,'J',true, false);
$pdf->ln(5);

//indemnités
$pdf->SetTextColor(239,137,20);
$pdf->writeHTMLCell('','','','',"Indemnités de fin de contrat : ",0,1,false,true,'L',true, false);
$pdf->ln(1);
$pdf->SetTextColor(0,0,0);
$textInd="Au terme du présent contrat, le(a) salarié(e) percevra, une indemnité de fin de contrat égale 
à 10 % de la rémunération brute globale perçue pendant la durée du contrat (sauf 
exceptions). ";
$pdf->writeHTMLCell('','','','',$textInd,0,1,false,true,'J',true, false);
$pdf->ln(5);

$pdf->Write(1,"Fait à………………………………le……………………(en 2 exemplaires).",'', 0,'L',1);
$pdf->ln(5);
$pdf->SetFont('times', 'B', 11, '', true);
$pdf->writeHTMLCell(100,'','','',"Signature de l'employeur",0,0,false,true,'L');
$xpos=$pdf->getPageWidth()-PDF_MARGIN_RIGHT-100;
$pdf->writeHTMLCell(100,'',$xpos,'',"Signature du(de la) salarié(e)",0,1,false,true,'R');
$pdf->SetFont('times', '', 8, '', true);
$pdf->writeHTMLCell(100,'','','',"(précédée de la mention « Lu et approuvé »)",0,0,false,true,'L');
$pdf->writeHTMLCell(100,'',$xpos,'',"(précédée de la mention « Lu et approuvé »)",0,1,false,true,'R');


/*************** page 5 **************/
$pdf->SetTopMargin(10);
$pdf->AddPage();

$pdf->SetFont('times', 'B', 12, '', true);
$pdf->SetFillColor(245, 166, 88);
$pdf->SetTextColor(0,0,0,0);
$xpos=$pdf->getPageWidth()-PDF_MARGIN_RIGHT-80;
$pdf->writeHTMLCell(80,'',$xpos,'',"NOTICE D'ACCOMPAGNEMENT",0,1,true,true,'C');
$pdf->ln(5);
$pdf->SetFillColor(67, 139, 190);
$xpos=($pdf->getPageWidth()-120)/2;
$pdf->writeHTMLCell(120,'',$xpos,'',"NOTICE D'ACCOMPAGNEMENT AU CONTRAT CDD",0,1,true,true,'C');
$pdf->ln(1);
$xpos=($pdf->getPageWidth()-100)/2;
$pdf->writeHTMLCell(100,'',$xpos,'',"SANS TERME PRECIS",0,1,true,true,'C');
$pdf->ln(5);


$pdf->SetTextColor(0,0,0);
$pdf->SetFont('times', '', 11, '', true);
$texteColGauche="<b><span style=\"color:#EF8914;\">Date d'entrée :</span></b><br>
    Le(a) salarié(e) est  embauché(e) en contrat à durée  déterminée  à  compter  du  (Date  du premier  jour  de  la  relation  de  travail.)  dans  le 
cadre du remplacement de Monsieur/Madame (Indiquer  l’identité  du(de  la)  salarié(e) remplacé(e)  embauché(e))  en  qualité  de 
(Indiquer  l’emploi  occupé  par  le(la)  salarié(e) remplacé(e)),  absent(e)  pour  cause  de (Indiquer le motif de l’absence). <br>
<br>
Fin du CDD : <br>
Préciser le terme envisagé :<br>
-  Le jour même du retour ;<br>
-  le surlendemain (au plus tard)  <br>
<br>
<b><span style=\"color:#EF8914;\">Période d'essai : </span></b><br>
La durée de la période d'essai est limitée à : <br>
&nbsp; &nbsp;&nbsp; &nbsp;- 1 jour par semaine de travail dans la limite de deux semaines calendaires si la durée du contrat de travail est 
inférieure ou égale à six mois ou moins. <br>
&nbsp; &nbsp;&nbsp; &nbsp;- 1 mois si la durée du contrat de travail excède six mois. <br>
<br>
<i>Attention,</i> il n'est possible de prévoir une période d'essai que si le contrat de travail n'a pas encore commencé à être exécuté (sauf si 
une lettre d'engagement indiquant la durée de la période d'essai a préalablement été signée entre les parties). <br>
<br>
<b><span style=\"color:#EF8914;\">Nature de l'emploi :</span></b><br>
A titre informatif, l'accord de classification du 21 mars 2014 met en place <b>une 
grille des métiers</b> comprenant <b>21 emplois-repères</b> (modèles d’emplois qui illustrent 
les situations de travail les plus courantes) répartis dans 5 domaines d'activités.<br>
<br>
Pour <span style=\"color:#EF8914;\">identifier l'emploi du salarié,</span> il convient de 
<span style=\"color:#EF8914;\">dresser la liste des activités confiées</span>
et le temps passé pour chaque activité. Il faut ensuite <span style=\"color:#EF8914;\">choisir le domaine 
d'activités</span> correspondant à l'activité qui prend le plus de temps. 
Enfin, <span style=\"color:#EF8914;\">retenir au sein de ce domaine l’emploi-repère correspondant à l'activité exercée</span> :<br>
<br>
&bull; <b>Domaine « Enfant »</b> (la garde d’un ou de plusieurs enfants) (cliquez <a href=\"http://www.fepem.fr/documents/10163/1274052/ANNEXE+1+du+domaine+enfant_Avril2016.pdf\">ici</a>) ;<br>
<br>";
$y = $pdf->getY();
$pdf->writeHTMLCell(86, '', '', $y, $texteColGauche, 0, 0, 0, true, 'J', true);
$pdf->writeHTMLCell(5, '', '', '', "", 0, 0, 0, true, 'J', true);
$texteColDroite="&bull; <b>Domaine « Adulte »</b> (l'accompagnement d'une personne dans le maintien de son autonomie ou en situation de handicap) (cliquez <a href=\"http://www.fepem.fr/documents/10163/1274052/ANNEXE+2+du+domaine+adulte_Avril2016.pdf\">ici</a>) ;<br>
<br>
&bull;  <b>Domaine « Espaces de vie »</b> (notamment l'entretien du domicile : ménage, repassage) (cliquez <a href=\"http://www.fepem.fr/documents/10163/1274052/ANNEXE+3+domaine+espaces+de+vie+_Avril2016.pdf\">ici</a>) ;<br>
<br>
&bull; <b>Domaine « Environnement technique »</b> (notamment secrétariat particulier, enseignement particulier, assistance informatique)  (cliquez <a href=\"http://www.fepem.fr/documents/10163/1274052/ANNEXE+4+domaine+environnement+technique_Avril2016.pdf\">ici</a>) ;<br>
<br>
&bull; <b>Domaine « Environnement externe »</b> (la réalisation d’activités de petits travaux de bricolage, petits travaux de jardinage, gardiennage)  (cliquez <a href=\"http://www.fepem.fr/documents/10163/1274052/ANNEXE+5+domaine+environnement+externe_Avril2016.pdf\">ici</a>).<br>
<br>
<i>Particularités :</i><br>
<br>
Lorsque les activités concernent plusieurs domaines, et que l'une d'elles consiste en :<br>
- l'accompagnement d’une personne adulte (domaine « Adulte ») ; <br>
- ou en la garde d'enfant(s) de moins de 3 ans (domaine « Enfant ») ; <br>
=> cette activité auprès de personnes fragiles est assimilée à l'activité principale. 
Dans ce cas, il faut retenir l’un de ces 2 domaines d’activités, indépendamment du temps consacré à l'activité, 
et choisir l'un des emplois-repères d’assistant(e) de vie du domaine « Adulte » ou 
l'un des emplois-repères de garde d'enfant(s) du domaine « Enfant » (Enfant de moins de 3 ans). <br>
<br>
S'il y a <u>plusieurs activités principales de durée équivalente,</u> il faut retenir l'ensemble des 
emplois-repères correspondant (les mentionner dans le contrat de travail) et l'échelle 
la plus élevée de ces emplois-repères (à mentionner également dans le contrat de travail).<br>
<br>
S'il y a des <span style=\"color:#EF8914;\">activités complémentaires</span> aux activités de l'emploi-repère retenu, 
(c'est-à-dire des activités qui ne figurent pas dans la liste de l'emploi-repère retenu 
mais qui sont confiées au salarié) les lister dans le contrat de travail.<br>
<br>
Les activités complémentaires ne donnent pas lieu à majoration de salaire sauf négociation entre les parties.<br>
<br>";
$pdf->writeHTMLCell(86, '', '', '', $texteColDroite, 0, 0, 0, true, 'J', true);

/************page 6***********/
$pdf->AddPage();

$pdf->SetFont('times', 'B', 12, '', true);
$pdf->SetFillColor(245, 166, 88);
$pdf->SetTextColor(0,0,0,0);
$xpos=$pdf->getPageWidth()-PDF_MARGIN_RIGHT-80;
$pdf->writeHTMLCell(80,'',$xpos,'',"NOTICE D'ACCOMPAGNEMENT",0,1,true,true,'C');
$pdf->ln(5);

$pdf->SetTextColor(0,0,0);
$pdf->SetFont('times', '', 11, '', true);
$texteColGauche="Il convient enfin de retenir le niveau de <span style=\"color:#EF8914;\">l'échelle</span> correspondant à l'emploi-repère retenu 
et de la mentionner dans le contrat de travail. Pour consulter la grille cliquez <a href=\"http://www.fepem.fr/documents/10163/1274052/Grille+des+metiers_FEPEM2016.pdf\">ici</a>.<br>
<br><b><span style=\"color:#EF8914;\">Durée du travail hebdomadaire :</span></b><br> 
La durée du travail est limitée à 48 heures par semaine sur une période de 12 semaines consécutives. Quoi qu'il en soit, la durée 
hebdomadaire de travail ne peut excéder 50 heures au cours d'une même semaine.<br> 
<br>
<u>Présence responsable </u><br>
Les heures de présence responsable sont celles où le salarié peut utiliser son temps pour lui-même tout en restant vigilant pour 
intervenir, s'il y a lieu. <br>
Possible uniquement pour les postes d'emploi à caractère familial.<br> 1 heure de présence responsable équivaut à 
2/3 d'une heure de travail effectif.<br>
<br>
<b><span style=\"color:#EF8914;\">Repos hebdomadaire : </span></b><br>
Prévoir une demi-journée supplémentaire. Le samedi après-midi par exemple. <br>
<br>
<b><span style=\"color:#EF8914;\">Rémunération à la date d'embauche :</span></b><br>
Il convient d'indiquer le salaire horaire brut minimum conventionnel correspondant au niveau de l'échelle de l'emploi-repère retenu.
Il n'est pas obligatoire de mentionner les salaires nets.<br>
<br>
<u>Modalités de rémunération des congés payés dans le cadre du Cesu déclaratif </u><br>
Si le salarié travaille moins de 32h/mois, le salaire inclut la majoration de 10% au titre du paiement des congés payés.<br>
Si le salarié travaille 32h ou plus/mois (sauf en cas de volet social Cesu papier), les congés 
payés sont rémunérés quand ils sont pris sauf accord au contrat entre les parties prévoyant que le salaire soit majoré de 10% au titre des congés payés.<br>
<br>
<u>Frais d'abonnement aux transports en commun</u><br>
Remboursement à hauteur de 50% si le salarié travaille au moins 17h30 par semaine. En deçà, il convient d'appliquer un prorata.<br>
<br>
<b><span style=\"color:#EF8914;\">Conduite automobile : </span></b><br>
Il existe deux possibilités :<br>
- barème minimal : barème des fonctionnaires <br>";
$y = $pdf->getY();
$pdf->writeHTMLCell(86, '', '', $y, $texteColGauche, 0, 0, 0, true, 'J', true);
$pdf->writeHTMLCell(5, '', '', '', "", 0, 1, 0, true, 'J', true);
//$pdf->Image('img/encadre-contrat-pdf.png','','','','','PNG','','N',false,72,'',false,false,0,true);
//$texteColDroite="<img src='img/encadre-contrat-pdf.png' />";
$texteColDroite1="- barème maximal : barème fiscal. Au-delà de ce barème, les sommes versées sont réintégrées dans le salaire et soumises à cotisations.<br> 
<br>
<b><span style=\"color:#EF8914;\">Présence de nuit : </span></b><br>
Indemnité forfaitaire au moins égale à 1/6ème du salaire conventionnel minimal pour une même durée de travail effectif.<br>
<br>
<br>";
$pdf->writeHTMLCell(86, '', 112, $y, $texteColDroite1, 0, 1, 0, true, 'J', true);
$pdf->Image('img/logo-fepem.png',112,'','','','PNG','','N',false,72,'',false,false,0,true);
$textecolDroite2="<span style=\"color:#EF8914;\">Besoin d'informations ?</span><br>
Appelez le 0 805 292 292 (appel et service gratuits)<br>
Nos conseillers vous répondent aussi sur votre Espace Particulier Employeur accessible <a href=\"http://reseau.fepem.fr\">ici</a>.<br>
<br>
<span style=\"color:#EF8914;\">Besoin d’être accompagné dans la rédaction de votre contrat de travail ? </span><br>
Souscrivez une consultation et obtenez un contrat de travail adapté à vos besoins validé par le service juridique de la FEPEM";
$pdf->writeHTMLCell(86,'', 112, '', $textecolDroite2, 0, 0, 0, true, 'J', true);

/************pages Annexes***********/
foreach($listER as $idER) {
    $fullPathAnnexe="fiches/emploi-repere-".$idER.".pdf";
    $pageCount = $pdf->setSourceFile($fullPathAnnexe);
    for ($i = 1; $i <= $pageCount; $i++) {
            $pdf->AddPage();
            $pdf->useTemplate($pdf->importPage($i));
    }

}

$pdf->Output('modele_contrat_pdf.pdf', 'I');