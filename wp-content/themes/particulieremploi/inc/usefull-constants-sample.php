<?php

/**
 * Constants file
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */


/**
 * Identifiant de la catégorie "article régional"
 */
define ( 'IDCATREGIONAL', 12 );
/**
 * Slug de la catégorie "article régional"
 */
define ('SLUGCATREG', 'article-regional');
/**
 * Identifiant de la catégorie "article national"
 */
define ( 'IDCATNATIONAL', 11 );
/**
 * Slug de la catégorie "Jsuis particulier employeur"
 */
define ( 'SLUGCATPE', 'je-suis-particulier-employeur');
/**
 * Slug de la catégorie "Je suis salarié"
 */
define ( 'SLUGCATSPE', 'je-suis-salarie');
/**
 * Slug de la catégorie "glossaire"
 */
define ( 'SLUGCATGLOSS', 'glossaire');
/**
 * Identifiant de la custom taxonomy "Type" relais
 */
define ( 'IDTAXORELAIS', 'relais');
/**
 * Identifiant de la custom taxonomy "Type" point relais
 */
define ( 'IDTAXOPOINTRELAIS', 'point-relais');

/**
 * Nombre d'article par page pour les pages
 * liste d'article personalisées
 */
define ( 'POSTPERPAGE', 9);


/**
 * Identifiant de page utilisées dans le thème
 */
define ( 'ID_PAGEESSENTIEL', 175 );
define ( 'ID_PAGEADHESIONFEPEM', 177 );
define ( 'IDPAGERESEAU', 78 );
define ( 'ID_PAGECESU' , 80);
define ( 'ID_PAGE_VOLETCESU', 260);
define ( 'ID_PAGE_CGU_PE', 287);
define ( 'ID_PAGE_CGU_FEPEM', 293);
define ( 'ID_PAGE_MENTIONS', 295);
define ( 'ID_PAGE_OFFREGARDE' , 300);
define ( 'ID_PAGE_OFFREEMPLOYE' , 301);
define ( 'ID_PAGE_OFFREASSISTANT' , 302);
define ( 'ID_PAGE_OFFRE_CONTRAT' , 332);
define ( 'ID_PAGE_OFFRE_REMUNERATION' , 334);
define ( 'ID_PAGE_OFFRE_RELATION' , 336);
define ( 'ID_PAGE_OFFRE_SEPARATION' , 338);
//define ( 'ID_PAGE_MAINTENANCE' , 340);

/**
 * Identifiant de média utilisés dans le thème
 */
define ( 'ID_MEDIA_CARTEFR', 329);

/**
 * catégories du glossaire
 */
$glossaryEntries= array(
  'glossaire','a','b','c','d','e','f','g','h','i','j','k','l',
    'm','n','o','p','q','r','s','t','u','v','w','x','y','z'
);

/**
 * Réseaux sociaux
 */
define ( 'LINK_FACEBOOK' , 'https://www.facebook.com/particulieremploi.fr/');
define ( 'LINK_TWITTER' , 'https://twitter.com/PE_LeMag');
define ( 'LINK_YOUTUBE' , 'https://www.youtube.com/channel/UCbBFZmEPVrfEOPRaSLpMrbQ');

/**
 * géolocalisation
 */
//correspondance code département <=> région pour la géolocalisation
$tabRegion['rhone-alpes'] = array('01','07','26','74','38','42','69','73');
$tabRegion['alsace-lorraine'] = array('67','68','54','55','57','88');
$tabRegion['aquitaine'] = array('24','33','40','47','64');
$tabRegion['auvergne'] = array('03','15','43','63');
$tabRegion['normandie'] = array('14','50','61','27','76');
$tabRegion['bourgogne'] = array('21','58','71','89');
$tabRegion['bretagne'] = array('22','29','35','56');
$tabRegion['centre'] = array('18','28','36','37','41','45');
$tabRegion['champagne-ardenne'] = array('08','10','52','51');
$tabRegion['corse'] = array('2A','2B','20');
$tabRegion['franche-comte'] = array('25','70','39','90');
$tabRegion['ile-de-france'] = array('91','92','75','77','93','95','94','78');
$tabRegion['languedoc-roussillon'] = array('11','30','34','48','66');
$tabRegion['limousin'] = array('19','23','87');
$tabRegion['midi-pyrenees'] = array('09','12','32','31','65','46','81','82');
$tabRegion['nord-pas-de-calais'] = array('59','62');
$tabRegion['pays-de-la-loire'] = array('44','49','53','72','85');
$tabRegion['picardie'] = array('02','60','80');
$tabRegion['poitou-charentes'] = array('16','17','79','86');
$tabRegion['paca'] = array('04','06','13','05','83','84');
$tabRegion['ile-de-la-reunion'] = array('974');
$tabRegion['martinique'] = array('972');
$tabRegion['mayotte'] = array('976');
$tabRegion['guyane'] = array('973');
$tabRegion['guadeloupe'] = array('971');

//correspondance code département <=> nouvelle région pour la géolocalisation
$tabNewRegion['centre-val-de-loire'] = array('18','28','36','37','41','45');
$tabNewRegion['corse'] = array('2A','2B','20');
$tabNewRegion['bourgogne-franche-comte'] = array('25','70','39','90','21','58','71','89');
$tabNewRegion['occitanie'] = array('09','12','32','31','65','46','81','82','11','30','34','48','66');
$tabNewRegion['nouvelle-aquitaine'] = array('24','33','40','47','64','19','23','87','16','17','79','86');
$tabNewRegion['auvergne-rhone-alpes'] = array('01','07','26','74','38','42','69','73','03','15','43','63');
$tabNewRegion['grand-est'] = array('67','68','54','55','57','88','08','10','52','51');
$tabNewRegion['normandie'] = array('14','50','61','27','76');
$tabNewRegion['bretagne'] = array('22','29','35','56');
$tabNewRegion['ile-de-france'] = array('91','92','75','77','93','95','94','78');
$tabNewRegion['pays-de-la-loire'] = array('44','49','53','72','85');
$tabNewRegion['hauts-de-france'] = array('02','60','80','59','62');
$tabNewRegion['paca'] = array('04','06','13','05','83','84');
$tabNewRegion['ile-de-la-reunion'] = array('974');
$tabNewRegion['martinique'] = array('972');
$tabNewRegion['mayotte'] = array('976');
$tabNewRegion['guyane'] = array('973');
$tabNewRegion['guadeloupe'] = array('971');

/**
 * cartes
 */
$coordRegion['auvergne-rhone-alpes']=array(
    'lat'=> 45.6042384285212,
    'long'=> 4.0450286865234375,
    'zoom'=> 9,
    'title' => "Où nous trouver en Auvergne-Rhône-Alpes ?"
);
$coordRegion['grand-est']=array(
    'lat'=> 48.4392232114806,
    'long'=> 5.6751251220703125,
    'zoom'=> 9,
    'title' => "Où nous trouver dans le Grand Est ?"
);
$coordRegion['nouvelle-aquitaine']=array(
    'lat'=> 44.853806,
    'long'=> 0.4833919999999807,
    'zoom'=> 8,
    'title' => "Où nous trouver en Nouvelle-Aquitaine ?"
);
$coordRegion['normandie']=array(
    'lat'=> 48.954793345678155,
    'long'=> 0.4236602783203125,
    'zoom'=> 10,
    'title' => "Où nous trouver en Normandie ?"
);
$coordRegion['bourgogne-franche-comte']=array(
    'lat'=> 47.322047,
    'long'=> 5.041479999999979,
    'zoom'=> 9,
    'title' => "Où nous trouver en Bourgogne-Franche-Comté ?"
);
$coordRegion['bretagne']=array(
    'lat'=> 48.176274,
    'long'=> -2.7520210000000134,
    'zoom'=> 9,
    'title' => "Où nous trouver en Bretagne ?"
);
$coordRegion['centre-val-de-loire']=array(
    'lat'=> 47.65132764878544,
    'long'=> 1.3176727294921875,
    'zoom'=> 9,
    'title' => "Où nous trouver dans le Centre-Val de Loire ?"
);
$coordRegion['ile-de-france']=array(
    'lat'=> 48.85661400000001,
    'long'=> 2.3522219000000177,
    'zoom'=> 10,
    'title' => "Où nous trouver en Île-de-France ?"
);
$coordRegion['occitanie']=array(
    'lat'=> 43.92045010439841,
    'long'=> 2.1526336669921875,
    'zoom'=> 9,
    'title' => "Où nous trouver en Occitanie ?"
);
$coordRegion['hauts-de-france']=array(
    'lat'=> 50.160009081480815,
    'long'=> 2.3448944091796875,
    'zoom'=> 9,
    'title' => "Où nous trouver dans les Hauts-de-France ?"
);
$coordRegion['pays-de-la-loire']=array(
    'lat'=> 47.478419,
    'long'=> -0.5631660000000238,
    'zoom'=> 9,
    'title' => "Où nous trouver en Pays-de-la-Loire ?"
);
$coordRegion['corse']=array(
    'lat'=> 42.03960420000001,
    'long'=> 9.012892599999986,
    'zoom'=> 9,
    'title' => "Où nous trouver en Corse ?"
);
$coordRegion['paca_corse']=array(
    'lat'=> 42.72865497810296,
    'long'=> 7.3299407958984375,
    'zoom'=> 9,
    'title' => "Où nous trouver en Provence-Alpes-Côte d'azur / Corse ?"
);
$coordRegion['paca']=array(
    'lat'=> 43.9351691,
    'long'=> 6.067919399999937,
    'zoom'=> 9,
    'title' => "Où nous trouver en Provence-Alpes-Côte d'Azur ?"
);
$coordRegion['ile-de-la-reunion']=array(
    'lat'=> -21.098594269392088,
    'long'=> 55.479583740234375,
    'zoom'=> 11,
    'title' => "Où nous trouver sur l'île de la Réunion ?"
);
$coordRegion['martinique']=array(
    'lat'=> 14.641528,
    'long'=> -61.024174000000016,
    'zoom'=> 9,
    'title' => "Où nous trouver en Martinique ?"
);
$coordRegion['mayotte']=array(
    'lat'=> -12.8275,
    'long'=> 45.166244000000006,
    'zoom'=> 9,
    'title' => "Où nous trouver à Mayotte ?"
);
$coordRegion['guyane']=array(
    'lat'=> 3.933888999999999,
    'long'=> -53.125782000000015,
    'zoom'=> 9,
    'title' => "Où nous trouver en Guyane ?"
);
$coordRegion['guadeloupe']=array(
    'lat'=> 16.265,
    'long'=> -61.55099999999999,
    'zoom'=> 9,
    'title' => "Où nous trouver en Guadeloupe ?"
);





