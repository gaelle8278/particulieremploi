<?php

/**
 * Page de connexion
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

/**
 * Fonctions de Wordpress
 */
require( dirname(dirname(dirname(__FILE__))).'/wp-load.php' );

include_once(dirname(__FILE__).'/templates/header-connespacepe.php');

if (!empty($_GET)) {
    $options = array(
        'erreurForm' => FILTER_SANITIZE_STRING,
        'erreurEmail' => FILTER_SANITIZE_STRING,
        'erreurPassword' => FILTER_SANITIZE_STRING
    );
    $validateGetParam = filter_input_array(INPUT_GET, $options);

    $optionsIns = array(
        'idAnnonce' => FILTER_SANITIZE_STRING,
    );
    $insConnexion=filter_input_array(INPUT_GET, $optionsIns);
}

?>
<section>
    <div class="content-central-column">
        <div class="popup-title">Accès à mon espace de mise en relation</div>
        <div class="page-column-demi page-column-highlight">
            <p class="section-title">Se connecter à mon compte</p>
            <div class="title-separator"></div>
            <?php
            include_once(dirname(__FILE__).'/templates/form-connexion.php');
            ?>

        </div><!-- @whitespace
        --><div class="page-column-demi">
            <p class="section-title">Créer un compte</p>
            <div class="title-separator"></div>
            <ul class="content-list">
                <li>Un service de mise en relation de l'emploi à domicile entre particuliers 100% gratuit</li>
                <li>L'accès à des annonces au plus près de chez vous</li>
                <li>Un espace de mise en relation avec une messagerie sécurisée</li></ul>
            <div class="compte-buttons">
                <a href="/pe/inscription/compte.php?type=sal" class="button-ins-sal">Sinscrire comme salarié</a>
                <a href="/pe/inscription/compte.php?type=emp" class="button-ins-emp">S'inscrire comme employeur</a>
            </div>
        </div>
    </div>
</section>

<?php
get_template_part("logos-partenaires");
include_once(dirname(dirname(__FILE__)).'/common-templates/footer.php');
