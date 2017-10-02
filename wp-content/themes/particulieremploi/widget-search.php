<?php

/**
 * widget de recherche d'annonces/offres
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

//adaptation (couleur, image et type de recherche) en fonction de la catégorie
$postCatSlugs=[];
if (is_single()) { 
    $postCategories = get_the_category();
    if (!empty($postCategories)) {
        foreach ($postCategories as $category) {
            $postCatSlugs[] = $category->slug;
        }
    }
}
if(in_array(SLUGCATSPE, $postCatSlugs)) {
   $classForm="bloc-recherche-sidebar-sal";
   $classWidget= "widget-search-sal";
   $title="Vous recherchez un emploi à domicile ?";
   $subTitle="Trouver un emploi en fonction de vos besoins";
   $type_annonce="emp";
} else {
    $classForm="bloc-recherche-sidebar-emp";
    $classWidget= "widget-search-emp";
    $title="Vous recherchez un salarié à domicile ?";
    $subTitle="Trouver un salarié en fonction de vos besoins";
    $type_annonce="sal";
}

//recherche des métiers
global $wpdb;
$queryMetier= "SELECT 
    referentiel_id, 
    referentiel_libelle 
    from tbl_ref_metiers
    WHERE referentiel_visibilite = '1' 
    order by referentiel_libelle ASC";
$resMetier=$wpdb->get_results($queryMetier);
?>
<div class="sidebar-widget-article <?php echo $classWidget ?>">
    <div class='sidebar-title sidebar-title-search'>
        <p><?php echo $title; ?></p>
    </div>
    <div>
        <div class='title-separator'></div>
        <p><?php echo $subTitle; ?></p>
    </div>
    <div class="bloc-recherche-sidebar <?php echo $classForm ?>">
        <form action="/pe/recherche/results.php" method="post" >
            <input type="hidden" name="type_annonce" value="<?php echo $type_annonce ?>" />
            <div class="bloc-field-form">
                <label for="metier">Métiers</label>
                <div class="select-style">
                    <select name="metier" id="metier">
                        <option value="0">Sélectionner</option>
                        <?php
                        foreach($resMetier as $result ){
                            echo "<option value='".$result->referentiel_id."'>";
                            echo $result->referentiel_libelle."</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="bloc-field-form">
                <div class="bloc-field-inline field-cp">
                    <label for="codep">Localisation</label>
                    <input type="text" class="input-style" id="codep" name="codep" placeholder="Code Postal">
                </div>
                <div class="bloc-field-inline field-submit">
                    <input type="submit" value="Rechercher"  />
                </div>  
            </div>
        </form>
    </div>
</div>
