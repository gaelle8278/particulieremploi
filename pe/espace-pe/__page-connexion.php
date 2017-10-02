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
//get_header('connespacepe');

if (isset($_GET)) {
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
            <form action="/pe/espace-pe/login.php" method="post">
                
                <?php
                if(isset($insConnexion['idAnnonce'])) {
                    ?>
                    <input type="hidden" name="idAnnonce" value="<?php echo $insConnexion['idAnnonce']; ?>" />
                    <?php
                }
                
                if (isset($validateGetParam)) {
                     echo "<p class='error-input'>Erreur dans la saisie de votre login / mot de passe</p>";
                }
                if (isset($validateGetParam['erreurForm'])) {
                    echo "<p class='error-input'>" . $validateGetParam['erreurForm'] . "</p>";
                }
                ?>
                <div class="bloc-field-form">
                    <label class="field-label" for="form-email">Adresse e-mail <span class="field-required">*</span></label>
                    <div class="field-value">
                        <input type="text" placeholder="" name="email" id="form-email" class="input-style" size="50" />
                        <?php
                        if(isset($validateGetParam['erreurEmail'])) {
                            echo "<p  class='error-input'>".$validateGetParam['erreurEmail']."</p>";
                        }
                        ?>
                    </div>
                </div>
                <div class="bloc-field-form">
                    <label class="field-label" for="form-mdp">Mot de passe</label>
                    <div class="field-value">
                        <input type="password" placeholder="" name="password" id="form-mdp" class="input-style" size="20" />
                        <a href="" class="content-link">Mot de passe oublié ?</a>
                        <?php
                        if(isset($validateGetParam['erreurPassword'])) {
                            echo "<p  class='error-input'>".$validateGetParam['erreurPassword']."</p>";
                        }
                        ?>
                    </div>
                </div>
                <div class="bloc-submit-form">
                    <input type="submit" value="Se connecter">
                </div>
            </form>
            
        </div><!-- @whitespace
        --><div class="page-column-demi">
            <p class="section-title">Créer un compte</p>
            <div class="title-separator"></div>
            <ul class="content-list">
                <li><span class="text-bold">Un service de mise en relation entre employeurs 100% gratuit</span></li>
                <li><span class="text-bold">L'accès à des offres d'emploi au plus près de chez vous</span></li>
                <li><span class="text-bold">Un espace de gestion de vos annonces pour un suivi avancé</span></li>
            </ul>
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