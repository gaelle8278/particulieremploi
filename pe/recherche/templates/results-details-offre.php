<?php



//si les paramètres de recherche sont présents 
if(empty($message)) {
    
     //récup infos annonce
    $queryRecupAnnonce = "SELECT "
                        . "annonce_idmetier, "
                        . "annonce_dateprisefonction, "
                        . "annonce_codepostal, "
                        . "annonce_ville, "
                        . "annonce_titremetier "
                        . "FROM ".TBL_ANNONCES." "
                        . "WHERE annonce_id=".$validateDataInput['id'];
    $data_annonce=$wpdb->get_row($queryRecupAnnonce, ARRAY_A);
    $nbAnnonces= $wpdb->num_rows;
    //recherche du domaine d'activités lié au métier
    $queryLibDomaine = "select "
                        . "domaine_classif_libelle, domaine_classif_id "
                        . "from " . TBL_DOMAINE_CLASSIF . " tdc, "
                        . TBL_METIERS . " tref "
                        . "where tref.referentiel_id=" . $data_annonce['annonce_idmetier'] . ""
                        . " and tref.referentiel_domaine_classif=tdc.domaine_classif_id";
    $resLibdomaine = $wpdb->get_row($queryLibDomaine);
    $refLibDomaine = $resLibdomaine->domaine_classif_libelle;
    $idDomaine = $resLibdomaine->domaine_classif_id;
     
    //récupération des emplois-repères liés à l'annonce
    $queryRecupER = "select er.emploi_repere_libelle "
            . "from "
            . TBL_EMPLOI_REPERE . " er, "
            . TBL_ASSOC_ER_ANNONCE . " erannonce "
            . "where erannonce.annonce_id=" . $validateDataInput['id'] . " "
            . "and erannonce.emploi_repere_id=er.emploi_repere_id";
    $resEr = $wpdb->get_results($queryRecupER);
    $tabErAnnonce = array();
    foreach ($resEr as $dataEr) {
        $tabErAnnonce[] = $dataEr->emploi_repere_libelle;
    }
    if (isset($tabErAnnonce) && !empty($tabErAnnonce)) {
        $data_annonce['emploi-repere'] = implode(',', $tabErAnnonce);
    } else {
        $data_annonce['emploi-repere'] = "";
    }
}
?>
<div class="content-central-column">
    <section class="search_results search_results_one">
        <div class="breadcrumb">
            <a href="<?php echo get_bloginfo('wpurl'); ?>">
                <img src="<?php echo get_template_directory_uri() ?>/images/pictos/home.png" />
            </a> > 
            <span class="text-bold">Je cherche une offre</span> > Offre sélectionnée
        </div>

        <div class="bloc-res-search">
            <h1>Offre sélectionnée</h1>
            <p class="results-intro">
                Vous trouverez ci-après le détail de l'offre sélectionnée pour contacter l'employeur.
            </p>
            <?php
            if($nbAnnonces === 0) {
            ?>
            <p>L'offre demandée n'est plus disponible.</p>
            <?php
            } else {
            ?>
                <div id='results-data'>
                    <table id='resultsTable'>
                        <thead>
                            <tr>
                                <th>Référence</th>
                                <th>Localisation</th>
                                <th>Classification</th>
                                <th>&nbsp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <img src='<?php echo get_template_directory_uri() ?>/images/charte/img_domaine_<?php echo $idDomaine; ?>.png' />
                                    <p><span class="text-bold">Ref : <?php echo $validateDataInput['id']; ?></span><br>
                                        disponible à partir du
                                            <?php echo convert_date($data_annonce['annonce_dateprisefonction'], '/'); ?>
                                    </p>
                                </td>
                                <td>
                                    <?php echo $data_annonce['annonce_codepostal'] . "<br>" . $data_annonce['annonce_ville']; ?>
                                </td>
                                <td>
                                    <?php echo $data_annonce['emploi-repere'] ?>
                                </td>
                                <td class="cell-contact">
                                    <div>
                                        <p> Vous êtes déjà inscrit <br> à Particulier emploi ?</p>
                                        <a href="/pe/espace-pe/connexion.php?idAnnonce=<?php echo $validateDataInput['id']; ?>">
                                            Contactez <br>directement l'employeur</a>
                                    </div>
                                    <div>
                                        <p>Vous n'êtes pas encore inscrit <br>à Particulier emploi ?</p>
                                        <a href="/pe/inscription/compte.php?type=sal&idAnnonce=<?php echo $validateDataInput['id']; ?>"
                                           class="button-ins-sal">Inscrivez-vous <br/>pour contacter l'employeur</a>
                                    </div>
                                </td>
                        </tbody>
                    </table>
                </div>
            <?php
            }
            ?>
        </div>
    </section> 
</div>   




