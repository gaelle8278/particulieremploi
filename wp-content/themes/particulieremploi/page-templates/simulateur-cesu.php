<?php

/**
 * Template Name: Simulateur CESU
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

//enregistrement et récupération du cp de l'internaute
set_user_depcode();
$depCode=get_user_depcode();
get_header();
include(locate_template('plugin-form-cp.php'));

?>

<div class="content-central-column">
    <section>
        <?php
        if (isset($_POST['cesu-load']) && isset($_POST['simu-cesu-verif'])) {
            if (wp_verify_nonce($_POST['simu-cesu-verif'], 'simu-cesu')) {
                require_once(dirname(dirname(__FILE__))."/inc/donnees-simulateur-cesu.php");
                ?>
                <div class="infos-calcul-simu">
                    <h1>Résultat de votre simulation du coût Cesu</h1>
                    <p><span class="text-bold">La présente simulation a un caractère uniquement informatif et général</span><br />
                    Le résultat présenté est susceptible d'être différent du coût réel du salaire en raison de divers éléments, 
                    notamment des éléments spécifiques à votre cas et ne pouvant être
                    pris en compte dans le présent simulateur.
                    </p>
                </div>
                <div class="bloc-page-cesu">
                    <?php
                    $typeCesu=htmlentities($_POST['cesu_type']);
                    get_template_part('calcul-cotisations',$typeCesu);
                    ?>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="bloc-page-cesu">
                <div class=" bloc-cesu-info">
                    <h1>Calculer le coût du Cesu</h1>
                    <p><span class="text-bold">Simulation du coût d'une heure de travail effectif payée par Cesu déclaratif</span><br />
                        Pour lancer la simulation, renseignez les informations ci-dessous
                    </p>
                </div>
                <form action="<?php echo get_permalink( ID_PAGECESU ) ; ?>" method="POST" class="cesu-form" id="cesu-form">
                    <?php wp_nonce_field('simu-cesu', 'simu-cesu-verif'); ?>

                    <div class="bloc-field-form">
                        <label class="field-label"><span>1</span>êtes-vous particulier employeur ou salarié ?</label>
                        <div class="field-req field-value">
                            <input type="radio" name="cesu_type" value="cesu-emp" id="cesu-emp">  
                            <label for="cesu-emp">Particulier employeur</label>
                            <input type="radio" name="cesu_type" value="cesu-sal" id="cesu-sal">
                            <label for="cesu-sal">Salarié</label>
                            <div class="msg-error-valid"></div>
                        </div>
                    </div>
                    <div class="bloc-field-form">
                        <label class="field-label" for="cesu-loc"><span>2</span>indiquez votre département</label>
                        <div class="field-value">
                            <div class="select-style">
                                <select name="cesu_loc" id="cesu-loc">
                                    <option value="tous-dep">Tous départements (sauf Alsace-Moselle/DOM)</option>
                                    <option value="alsace">Alsace-Moselle</option>
                                    <option value="dom">DOM</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bloc-field-form">
                        <label class="field-label" for="cesu-salaire"><span>3</span>renseignez le montant horaire brut</label>
                        <div class="field-req field-value">
                            <p class="text-italic">Smic brut applicable au 1er janvier 2017 : 9.76 € (10.74 € si majoration des 10% au titre des congés payés)</p>
                            <input type="text" placeholder="ex:10.74" name="cesu_salaire" id="cesu-salaire"
                                   class="input-style" size="20" />
                            <div class="msg-error-valid"></div>
                        </div>
                    </div>
                    <div class="bloc-submit-form">
                        <input type="submit" value="lancer la simulation" name="cesu-load" id="cesu-submit">
                    </div>
                </form>
            </div>
            <div class="bloc-page-cesu">
                <div class="bloc-cesu-info">
                    <h1> Tout savoir sur le Cesu</h1>
                    <p class="cesu-question">Comment fonctionne le Cesu </p>
                    <p>C'est très simple ! La personne qui emploie un salarié à domicile 
                        lui remet un Chèque emploi service (Cesu). S'il est rempli par l'employeur (Cesu déclaratif),
                        le salarié peut le déposer directement sur son compte.</p>
                    <p>S'il s'agit du Cesu préfinancé, il doit être envoyé au centre de remboursement
                        du Cesu, qui effectuera un virement sur le compte du salarié. 
                        Le Centre national du Cesu établit ensuite une attestation valant bulletin de salaire.</p>
                    <p class="cesu-question"> Quels salariés peuvent être rémunérés avec le Cesu ?</p>
                    <p>Le Cesu sert à rémunérer le salarié à domicile :  assistant de vie, garde d'enfants, employé familial etc...</p>
                    <p class="cesu-question"> Quels sont les avantages du Chèque emploi service universel ?</p>
                    <p>
                        Le Cesu simplifie la vie de l'employeur en le dispensant de nombreuses formalités administratives
                        comme la déclaration préalable à l'embauche auprès de l'Ursaff
                        et lui donne droit à une réduction d'impôt 
                        et, sous certaines conditions, à un allègement
                        de charges patronales. Le salarié a la garantie d'être 
                        déclaré et de bénéficier de droits sociaux.
                    </p>
                </div>
            </div>
            <?php
        }
        ?>
    </section><!-- @white-space
    --><aside>
        <?php
        get_sidebar();
        ?>
    </aside>
</div>
<?php
get_template_part("logos-partenaires");
get_footer();