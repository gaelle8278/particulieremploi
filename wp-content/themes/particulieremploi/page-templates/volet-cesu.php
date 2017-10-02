<?php

/**
 * Template Name: Volet CESU
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
        <div class="bloc-page-cesu bloc-cesu-oneblock">
            <div class="article-toolbar">
                <?php
                get_template_part('article-features-bar');
                get_template_part('small-social-links');
                ?>
            </div>
            <div class="wrap-clear"></div>

            <h1>Comment remplir le volet social ?</h1>
            <img class="full-img" src="<?php echo get_template_directory_uri() ?>/images/volet-social-cesu.jpg" alt="image du volet social avec légende" >

            <div class='volet-cesu-sal'>
                <p class='volet-cesu-title'>Personne employée</p>
                <div class='volet-cesu-step'>
                    <div class='step-number'>1</div>
                    <div class='step-desc'>
                        <p>- Nom de naissance</p>
                        <p>Si votre salarié est marié, veuillez préciser son nom de naissance en premier</p>
                    </div>
                </div>
                <div class='volet-cesu-step'>
                    <div class='step-number'>2</div>
                    <div class='step-desc'>
                        <p>- Adresse</p>
                        <p>Indiquez son adresse</p>
                    </div>
                </div>
                <div class='volet-cesu-step'>
                    <div class='step-number'>3</div>
                    <div class='step-desc'>
                        <p>- N° de SecSoc</p>
                        <p>Complétez le numéro de sécurité sociale</p>
                    </div>
                </div>
            </div>
            <div class='volet-cesu-separator'></div>
            <div class='volet-cesu-emp'>
                <p class='volet-cesu-title'>Travail effectué et rémunération</p>
                <div class='volet-cesu-step'>
                    <div class='step-number'>4</div>
                    <div class='step-desc'>
                        <p>- heures effectuées</p>
                        <p>N'indiquez que des heures entières</p>
                    </div>
                </div>
                <div class='volet-cesu-step'>
                    <div class='step-number'>5</div>
                    <div class='step-desc'>
                        <p>- Salaire horaire net</p>
                        <p>
                            Indiquez le montant du salaire net horaire.<br />
                            Dans le cadre de l'utilisation du Cesu déclaratif, 
                            celui-ci ne peut être inférieur au Smic majoré de 10%
                            au titre des congés payés.
                        </p>
                    </div>
                </div>
                <div class='volet-cesu-step'>
                    <div class='step-number'>6</div>
                    <div class='step-desc'>
                        <p>- total net payé</p>
                        <p>Indiquez le salaire mensuel versé</p>
                    </div>
                </div>
                <div class='volet-cesu-step'>
                    <div class='step-number'>7</div>
                    <div class='step-desc'>
                        <p>- Période du... au ...</p>
                        <p>Indiquez le premier et le dernier jour du mois civil,
                            sauf en cas d'embauche ou de départ en cours de mois.</p>
                    </div>
                </div>
                <div class='volet-cesu-step'>
                    <div class='step-number'>8</div>
                    <div class='step-desc'>
                        <p>- base forfaitaire</p>
                        <p>Cochez obligatoirement l'option 'Salaire réel', la base 
                            forfaitaire ayant été supprimée en janvier 2013.</p>
                    </div>
                </div>
                <div class='volet-cesu-step'>
                    <div class='step-number'>9</div>
                    <div class='step-desc'>
                        <p>- le ...</p>
                        <p>Datez et n'oubliez pas de signer.</p>
                    </div>
                </div>
            </div>

            <p>
                Vous devez envoyer votre volet social par voie postale, 
                <span class='text-bold'>au plus tard dans les quinze jours</span>
                suivant la fin du mois au cours duquel le salarié a effectué sa prestation.
            </p>
        </div>
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