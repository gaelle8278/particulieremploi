<?php
/**
* Constantes de configuration
*/

define('CDIPE', 'CDI salarié du particulier employeur');
define('CDIGP', "CDI garde d'enfant");
define('CDDTP', 'CDD terme précis');
define('CDDTI', 'CDD terme imprécis');

$tabNomContratPdf['cdipe']="CONTRAT DE TRAVAIL A DUREE INDETERMINEE (CDI)";
$tabNomContratPdf['cdigp']="CONTRAT DE TRAVAIL A DUREE INDETERMINEE (CDI) <br /> GARDE D'ENFANTS PARTAGEE";
$tabNomContratPdf['cddtp']="CONTRAT DE TRAVAIL A DUREE DETERMINEE (CDD) <br /> A TERME PRECIS";
$tabNomContratPdf['cddti']="CONTRAT DE TRAVAIL A DUREE DETERMINEE (CDD) <br /> A TERME IMPRECIS";

$tabDomaineActivite=array(1=>'Enfant',2=>'Adulte',3=>'Espaces de vie',4=>'Environnement technique',5=>'Environnement externe');
//$tabER=array("Enfant","Adulte","Espaces de vie","Environnement technique","Environnement externe");
$tabER['Enfant']=array(1=>"Baby-sitter",2=>"Garde d'enfant(s) A",3=>"Garde d'enfant(s) B");
$tabER['Adulte']=array(4=>"Assistant(e) de vie A",5=>"Assistant(e) de vie B",6=>"Assistant(e) de vie C",7=>"Assistant(e) de vie D");
$tabER['Espaces de vie']=array(8=>"Employé(e) familial(e) A",9=>"Employé(e) familial(e) B",10=>"Employé(e) familial(e) auprès d'enfant(s)");
$tabER['Environnement technique']=array(11=>"Accompagnateur(rice)/Personne de compagnie",12=>"Secrétaire particulier(ère)",13=>"Enseignant(e) particulier(ère) (niveau élémentaire) A",
        14=>"Enseignant(e) particulier(ère) (niveau collège/lycée) B",15=>"Enseignant(e) particulier(ère) (niveau études supérieures) C",16=>"Assistant(e) informatique A",
    17=>"Assistant(e) informatique B");
$tabER['Environnement externe']=array(18=>"Employé(e) d'entretien et petits travaux/Homme-Femme toutes mains A", 19=>"Employé(e) d'entretien et petits travaux/Homme-Femme toutes mains B",
        20=>"Gardien(ne) A",21=>"Gardien(ne) B");

$tabAllER=array(1=>"Baby-sitter",2=>"Garde d'enfant(s) A",3=>"Garde d'enfant(s) B",
        4=>"Assistant(e) de vie A",5=>"Assistant(e) de vie B",6=>"Assistant(e) de vie C",7=>"Assistant(e) de vie D",
    8=>"Employé(e) familial(e) A",9=>"Employé(e) familial(e) B",10=>"Employé(e) familial(e) auprès d'enfant(s)",
    11=>"Accompagnateur(rice)/Personne de compagnie",12=>"Secrétaire particulier(ère)",13=>"Enseignant(e) particulier(ère) (niveau élémentaire) A",
    14=>"Enseignant(e) particulier(ère) (niveau collège/lycée) B",15=>"Enseignant(e) particulier(ère) (niveau études supérieures) C",16=>"Assistant(e) informatique A",
    17=>"Assistant(e) informatique B",18=>"Employé(e) d'entretien et petits travaux/Homme-Femme toutes mains A", 
    19=>"Employé(e) d'entretien et petits travaux/Homme-Femme toutes mains B",20=>"Gardien(ne) A",21=>"Gardien(ne) B"
    );

$tabDescER[1]="Cet emploi-repère correspond :<ul><li>Surveiller et assurer une présence occasionnelle de courte durée auprès d’un ou plusieurs enfants de plus de 3 ans</li></ul>";
$tabDescER[2]="Cet emploi-repère correspond :<ul><li>S’occuper d’un ou de plusieurs enfants de plus ou moins 3 ans</li><li>Nettoyer les espaces de vie de l’enfant</li><li>Surveiller un ou plusieurs enfants dans réalisation des devoirs</li></ul>";
$tabDescER[3]="Cet emploi-repère correspond :<ul><li>S’occuper d’un ou de plusieurs enfants de plus ou moins 3 ans</li><li>Nettoyer les espaces de vie de l’enfant</li><li>Surveiller un ou plusieurs enfants dans réalisation des devoirs</li><li>Entretenir le linge de l’enfant</li></ul>";
$tabDescER[4]="L’emploi-repère d’Assistant(e) de vie A consiste à accompagner une personne adulte dont l’autonomie est altérée de manière temporaire, évolutive ou permanente dans la réalisation des tâches courantes.<ul><li<Effectuer et /ou accompagner l’employeur dans les activités sociales et/ou de loisirs, les courses, les tâches ménagères, l’entretien du linge, la préparation de repas courants, les tâches administratives courantes.</li></ul>";
$tabDescER[5]="L’emploi-repère d’Assistant(e) de vie B consiste à accompagner une personne adulte dont l’autonomie est altérée de manière temporaire, évolutive ou permanente dans la réalisation des tâches courantes et des actes essentiels de la vie quotidienne. 
<ul>
<li>Effectuer et /ou accompagner l’employeur dans les activités sociales et/ou de loisirs, les courses, les tâches ménagères, l’entretien du linge, la préparation de repas courants, les tâches administratives courantes.</li>
<li>Effectuer et/ou accompagner l’employeur dans la préparation de repas spécifiques.</li><li>Accompagner l’employeur dans la prise des repas, la réalisation des gestes d’hygiène corporelle, les transferts et les déplacements à l’intérieur ou à l’extérieur du domicile, l’habillage.</li></ul>";
$tabDescER[6]="L’emploi-repère d’Assistant(e) de vie C consiste à réaliser les tâches courantes et les actes essentiels de la vie quotidienne (hors soins d’hygiène corporelle) d’une personne dont l’autonomie est altérée de manière temporaire, évolutive ou permanente qu’elle ne peut effectuer seule.
<ul>
<li>Effectuer et /ou accompagner l’employeur dans les activités sociales et/ou de loisirs, les courses, les tâches ménagères, l’entretien du linge, la préparation de repas courants, les tâches administratives courantes.</li>
<li>Réaliser à la place de l’employeur la préparation de repas spécifiques.</li>
<li>Assister l’employeur dans la prise des repas, lors de ses transferts et déplacements à l’intérieur ou à l’extérieur du domicile, dans l’habillage.</li><li>Assister une tierce personne (professionnel de santé, aidant familial) dans la réalisation des soins d’hygiène corporelle.</li></ul>";
$tabDescER[7]="L’emploi-repère d’Assistant(e) de vie D consiste à réaliser les tâches courantes et les actes essentiels de la vie quotidienne d’une personne en situation de handicap qu’elle ne peut effectuer seule dont les gestes liés à des soins délégués.
<ul>
<li>Effectuer et /ou accompagner l’employeur dans les activités sociales et/ou de loisirs, les courses, les tâches ménagères, l’entretien du linge, la préparation de repas courants, les tâches administratives courantes.</li>
<li>Réaliser à la place de l’employeur la préparation de repas spécifiques.</li>
<li>Assister l’employeur dans la prise des repas, lors de ses transferts et déplacements à l’intérieur ou à l’extérieur du domicile, dans l’habillage.</li><li>Assister une tierce personne (professionnel de santé, aidant familial) dans la réalisation des soins d’hygiène corporelle.</li><li>Réaliser les gestes délégués liés à des soins d’un employeur en situation de handicap.</li></ul>";
$tabDescER[8]="Cet emploi-repère correspond :<ul><li>Entretenir les espaces de vie</li><li>Repasser le linge courant</li></ul>";
$tabDescER[9]="Cet emploi-repère correspond :<ul><li>Entretenir les espaces de vie</li><li>Repasser le linge courant</li><li>Entretenir le linge</li><li>Repasser le linge délicat</li><li>Préparer des repas courants</li><li>Effectuer les courses</li></ul>";
$tabDescER[10]="Cet emploi-repère correspond :<ul><li>Entretenir les espaces de vie</li><li>Repasser le linge courant</li><li>Entretenir le linge</li><li>Repasser le linge délicat</li><li>Surveiller et assurer une présence auprès d'un ou de plusieurs enfants de plus de 3 ans</li><li>Surveiller un ou plusieurs enfants dans la réalisation des devoirs</li></ul>";
$tabDescER[11]="Cet emploi-repère correspond :<ul><li>Accompagner une personne adulte dans les activités de loisirs</li></ul>";
$tabDescER[12]="Cet emploi-repère correspond :<ul><li>Rédiger des écrits, rechercher des documents</li><li>Réaliser une assistance administrative </li><li>Réaliser une assistance à la gestion du budget familial </li></ul>";
$tabDescER[13]="Cet emploi-repère correspond :<ul><li>Evaluer le niveau de l’apprenant</li><li>Elaborer et /ou dispenser l’enseignement particulier (niveau élémentaire) A</li></ul>";
$tabDescER[14]="Cet emploi-repère correspond :<ul><li>Evaluer le niveau de l’apprenant</li><li>Elaborer et /ou dispenser l’enseignement particulier (niveau collège/lycée) B</li></ul>";
$tabDescER[15]="Cet emploi-repère correspond :<ul><li>Evaluer le niveau de l’apprenant</li><li>Elaborer et /ou dispenser l’enseignement particulier (niveau études supérieures) C</li></ul>";
$tabDescER[16]="Cet emploi-repère correspond :<ul><li>Identifier le besoin</li><li>Installer et configurer le matériel informatique</li><li>Intervenir sur une panne informatique</li></ul>";
$tabDescER[17]="Cet emploi-repère correspond :<ul><li>Identifier le besoin</li><li>Installer et configurer le matériel informatique</li><li>Intervenir sur une panne informatique</li><li>Accompagner la personne dans le domaine informatique</li></ul>";
$tabDescER[18]="Cet emploi-repère correspond :<ul><li>Effectuer des petits travaux de bricolage</li><li>Nettoyer et entretenir les espaces extérieurs</li></ul>";
$tabDescER[19]="Cet emploi-repère correspond :<ul><li>Effectuer des petits travaux de bricolage</li><li>Nettoyer et entretenir les espaces extérieurs</li><li>ffectuer des petits travaux de jardinage</li></ul>";
$tabDescER[20]="Cet emploi-repère correspond :<ul><li>Surveiller la propriété (habitation et dépendances)</li><li>Entretenir la propriété (habitation et dépendances)</li>
</ul>";
$tabDescER[21]="Cet emploi-repère correspond :<ul><li>Surveiller la propriété (habitation et dépendances)</li><li>Entretenir la propriété (habitation et dépendances)</li><li>Assurer des tâches complémentaires : par exemple s’occuper des animaux de compagnie (les promener, les alimenter, nettoyer leur espace), nettoyer et entretenir les bassins, la piscine ainsi que les annexes techniques, nettoyer la voiture de l’employeur, fendre, ranger et stocker le bois</li></ul>";