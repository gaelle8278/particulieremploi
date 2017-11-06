<?php
/**
 * Template de la page d'inscription du module d'inscription
 */

/**
 * Constantes
 */

require(  ABSPATH .'pe/config/constants.php' );
require(  ABSPATH .'pe/config/functions.php' );

//1. vérifier que l'utilisateur est connecté avec le bon role
if(!check_access_to_module_inscription()) {
    header("Location: ".home_url( "page-non-accessible"));
    exit();
}


//2. traitement
$type_compte= get_query_var( 'type' );
if(empty($type_compte)) {
    $type_compte=$_SESSION['officer-inscription']['type_compte'];
}
if( !in_array($type_compte,['sal','emp']) ) {
    header("Location: ".home_url( "page-non-accessible"));
    exit();
}

global $wpdb;

$queryRecupMetiers="SELECT *
                         from ".TBL_METIERS." ref,
                         ".TBL_CATEGORIES." cat
                         where ref.referentiel_parent=''
                         and ref.referentiel_categorie=cat.categorie_id
                         and ref.referentiel_inscription=1
                         order by cat.categorie_id asc, referentiel_libelle asc";

//echo "<pre>";print_r($queryRecupMetiers);echo "</pre>";
$resultat= $wpdb->get_results($queryRecupMetiers, ARRAY_A);

$arrFirstNiv = array();
$i=0;
$affichageMetiers=array();
foreach ($resultat as $data) {
    //metiers
    $id1=$data['referentiel_id'];
    $libelle=$data['referentiel_libelle'];
    $categorie=$data['categorie_nom'];
    $categorieComplement=$data['categorie_plus_infos'];
    $domaineOfRef=$data['referentiel_domaine_classif'];

    //récupération du nom du domaine d'activités auquel appartient le métier
    $queryLibDomaine="select domaine_classif_libelle
                        from ".TBL_DOMAINE_CLASSIF."
                        where domaine_classif_id=".$domaineOfRef;
    $resLibdomaine=$wpdb->get_row($queryLibDomaine);
    $refLibDomaine[$id1]=$resLibdomaine->domaine_classif_libelle;


    //récupération des emploi-repères liés au métier
    $queryRecupER="select
                    refer.emploi_repere_id ,
                    er.emploi_repere_libelle,
                    er.emploi_repere_desc
                    from ".TBL_METIER_ER." refer ,
                    ".TBL_EMPLOI_REPERE." er
                    where refer.referentiel_id=".$id1."
                        and refer.emploi_repere_id=er.emploi_repere_id
                        order by er.emploi_repere_id" ;
                //echo "<pre>";print_r($queryRecupER);echo "</pre>";
    $resRecupER = $wpdb->get_results($queryRecupER);
    foreach ($resRecupER as $recupER) {
        $metierER[$id1][]=array($recupER->emploi_repere_id, $recupER->emploi_repere_libelle, $recupER->emploi_repere_desc);
    }

    //On stocke le premier niveau dans un tableau pour gérer ensuite l'arbre des métiers
    /*$arrFirstNiv[$i][0] = $data['referentiel_id'];
    $arrFirstNiv[$i][1] = $data['referentiel_libelle'];*/

    //on stocke les métiers par catégorie pour gérer ensuite l'affichage des métiers parents
    //id de la catégorie sert à créer une class pour appliquer des couleurs spécifiques
    $affichageMetiers[$categorie]['id']=$data['categorie_id'];
    $affichageMetiers[$categorie]['plusInfos']=$categorieComplement;
    $affichageMetiers[$categorie]['listeMetiers'][]=array($id1,$libelle);

    $i++;
}



include_once(__DIR__ . '/../templates/header.php');
include_once(__DIR__ . '/../templates/inscription_form.php');
include_once(__DIR__ . '/../templates/footer.php');


