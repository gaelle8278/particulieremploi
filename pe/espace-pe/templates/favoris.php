<?php

/**
 * Contenu de la page de sélection d'annonces/offres
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
?>
<section class="<?php echo $_SESSION['utilisateur_groupe'] == 'SAL'?"compte-sal":"compte-emp"; ?>">
    <div class="content-central-column">
        <div class="bloc-header-espacepe">
            <p class="bloc-header-title">
                <?php
                if($_SESSION['utilisateur_groupe'] == 'SAL') {
                    echo "Offres d'emploi sélectionnées";
                } else {
                    echo "Candidatures sélectionnées";
                }
              ?>
            </p>
            <p class="bloc-header-teaser">
                <?php
                if($_SESSION['utilisateur_groupe'] == 'SAL') {
                    if($nbresult > 0) {
                        echo $nbresult." offre(s)";
                    } else {
                        echo "Aucune offre sélectionnée";
                    }
                } else {
                    if($nbresult > 0) {
                        echo $nbresult." candidatures";
                    }
                    else {
                        echo "Aucune candidature sélectionné.";
                    }
                }
                ?>
            </p>
        </div>
        <div class="wrap-clear"></div>
        
        <?php
        if($nbresult > 0 ) {
            $g=0;
            for ($g; $g < $nbresult; $g++) {
                if($g%2==0) {
                    ?>
                    <div class="bloc-row-espacepe">
                    <?php
                }
                ?>
                    <div class="bloc-cell-espacepe bloc-annonce <?php echo $g%2==0?"first-bloc-cell":""; ?>">
                        <?php 
                        $link_suppr= "/pe/espace-pe/favoris.php?part=suppression&annonceid=".$annonceid[$g];
                        if($_SESSION['utilisateur_groupe'] == 'EMP') {
                            $message_confirm="Voulez-vous supprimer cette candidature de votre sélection ?";
                        } else {
                            $message_confirm="Voulez-vous supprimer cette offre de votre sélection ?";
                        }
                        ?>
                        <a href="<?php echo $link_suppr; ?>" class="suppr-button" data-message="<?php echo $message_confirm; ?>"></a>
                        <?php
                        if ($annonceetat[$g]!=''){
                            if ($annonceetat[$g] =='SUP' || $annonceetat[$g] =='SUPPRIME'){
                                if($_SESSION['utilisateur_groupe'] == 'EMP'){
                                    ?>
                                    <p class="alert-annonce">Annonce supprimée</p>
                                    <?php
                                } else if ($_SESSION['utilisateur_groupe'] == 'SAL'){
                                    ?>
                                    <p class="alert-annonce">Offre supprimée</p> 
                                    <?php
                                }
                            }
                        }
                        
                       
                        ?>
                        <p class="bloc-annonce-title"><?php echo stripslashes($metier[$g]);?></p>
                        <p class="text-bold"><?php echo $civilite[$g]." ".ucfirst($prenom[$g])." ".ucfirst($nom[$g]); ?></p>
                        <p>Disponible à partir du : 
                            <?php echo $annoncedateprisefonction[$g];?>
                        </p>
                        <p> Référence : <?php echo $annonceid[$g];?></p>
                        <p> Localisation :
                            <?php  
                            if ($cpo[$g]!=""){
                                echo $cpo[$g].', ';
                            }
                            echo $ville[$g];
                            ?>
                        </p>
                        <p>Emploi(s)-repère(s) : 
                        <?php 
                            if(!empty($annonceemploirepere[$g])) {
                                echo $annonceemploirepere[$g];
                            }
                            else {
                                echo "Non précisé";
                            }
                            ?>
                        </p>
                        <div class="display-note">
                            <?php
                            if ($blocnotes[$g]!=""){
                                ?>
                                <div class="header-note">
                                    <span>Bloc-note</span>
                                    <p class="edit-note-button">Modifier</p>
                                </div>
                                <div class="wrap-clear"></div>
                                <div>
                                    <?php
                                    echo ucfirst($blocnotes[$g]);
                                    ?>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="header-note">
                                    <span>Bloc-note</span>
                                    <p class="edit-note-button">Ajouter une note</p>
                                </div>
                                <div class="wrap-clear"></div>
                            <?php
                            }
                            ?>
                            <div class="edit-note">
                                <form action="/pe/espace-pe/favoris.php" method="post">
                                    <textarea cols="23" rows="5" name="note"><?php echo ucfirst($blocnotes[$g]); ?></textarea>
                                    <input type="hidden" name="annonceid" value="<?php echo $annonceid[$g]; ?>">
                                    <input type="hidden" name="part" value="ajoutnotedb">
                                    <div class="bloc-buttons">
                                        <span class="edit-cancel">Annuler</span>
                                        | <input type='submit' value='Enregister'>
                                    </div>
                                </form>
                            </div>
                        </div>



                        <div class="bloc-buttons-espacepe">
                            <?php
                            $link_detail ="/pe/espace-pe/details_offre.php?annonceid=".$annonceid[$g];
                            $link_contact='/pe/espace-pe/messagerie/envoyer.php?id_dest_msg='.$idauteur[$g];
                            if ($_SESSION['utilisateur_groupe'] == 'EMP') {
                                        $labelAnnonce= "Détail de l'annonce";
                                        $labelContact="Contacter le salarié";
                                        $label_taux= "Taux brut souhaité";
                                    } else if ($_SESSION['utilisateur_groupe'] == 'SAL') {
                                        $labelAnnonce= "Détail de l'offre";
                                        $labelContact="Contacter l'employeur";
                                        $label_taux= "Taux brut proposé";
                                    }
                            ?>
                            <a href="<?php echo $link_detail; ?>"  class="button_details"  id="annonce-<?php echo $annonceid[$g];?>" >
                                Voir le détail</a>
                            <input type="button" class="res_button_details" id="res-annonce-<?php echo $annonceid[$g];?>"
                                   value="Voir le détail" />
                            <div class="custom-popup">
                                <div class="popup-title">
                                    <?php
                                    echo $labelAnnonce;
                                    ?>
                                </div>
                                <p><span class="text-bold">Référence annonce : </span><?php echo $annonceid[$g]; ?> </p>
                                <p><span class="text-bold">Métier : </span><?php echo stripslashes($metier[$g]); ?> </p>
                                <p><span class="text-bold">Expérience souhaitée dans ce métier : </span>
                                    <?php echo $experience[$g]; ?> </p>
                                <p><span class="text-bold">Particularités sur l'exercice du métier : </span>
                                    <?php echo stripslashes($description[$g]); ?> </p>
                                <p><span class="text-bold"><?php echo $label_taux; ?> (hors Cesu, hors ancienneté) : </span>
                                    <?php echo $tauxhoraire[$g]; ?> </p>
                                <p><span class="text-bold">Date de prise de fonction : </span>
                                    <?php echo $annoncedateprisefonction[$g]; ?> </p>
                                <p><span class="text-bold">Adresse : </span><?php echo $adresse[$g]; ?> </p>
                                <p><span class="text-bold">Code postal : </span><?php echo $cpo[$g]; ?> </p>
                                <p><span class="text-bold">Ville : </span><?php echo $ville[$g]; ?> </p>
                                <p><span class="text-bold">Horaires de travail souhaités : </span>
                                    <?php echo $dureehebdo[$g]; ?> h/semaine</p>
                                <div class="popup-buttons">
                                    <a href="<?php echo $link_contact; ?>"><?php echo  $labelContact ?></a>
                                    <input type="button" value="Ok" class="ok_button">
                                </div>
                                <div class="close_button"></div>
                            </div>
                            <a href="<?php echo $link_contact; ?>"><?php echo  $labelContact ?></a>
                            <div class="res-custom-popup">
                                <p><span class="text-bold">Référence annonce : </span><?php echo $annonceid[$g]; ?> </p>
                                <p><span class="text-bold">Métier : </span><?php echo stripslashes($metier[$g]); ?> </p>
                                <p><span class="text-bold">Expérience souhaitée dans ce métier : </span>
                                    <?php echo $experience[$g]; ?> </p>
                                <p><span class="text-bold">Particularités sur l'exercice du métier : </span>
                                    <?php echo stripslashes($description[$g]); ?> </p>
                                <p><span class="text-bold"><?php echo $label_taux; ?> (hors Cesu, hors ancienneté) : </span>
                                    <?php echo $tauxhoraire[$g]; ?> </p>
                                <p><span class="text-bold">Date de prise de fonction : </span>
                                    <?php echo $annoncedateprisefonction[$g]; ?> </p>
                                <p><span class="text-bold">Adresse : </span><?php echo $adresse[$g]; ?> </p>
                                <p><span class="text-bold">Code postal : </span><?php echo $cpo[$g]; ?> </p>
                                <p><span class="text-bold">Ville : </span><?php echo $ville[$g]; ?> </p>
                                <p><span class="text-bold">Horaires de travail souhaités : </span>
                                    <?php echo $dureehebdo[$g]; ?> h/semaine</p>
                                
                            </div>
                        </div>
                    </div>
                        
                        
                        
                <?php
                if($g%2!=0) {
                    ?>
                    </div>
                    <?php
                }
            } //end for
        } //end if
        ?>
        </div>
        <?php
        if ( isset( $validateDataInput['part'] ) && $validateDataInput['part']=="affiche-annonce" ) {
            echo "<script>
                
                jQuery(document).ready( function($) {
                    function showPopup(popup) {
                        $(popup).before('<div id=\"gray-overlay\"></div>');
                        $('#gray-overlay ').css('opacity', 0).fadeTo(300, 0.5, function () { $(popup).fadeIn(500); });
                    }
                    if(  $('.res_button_details#res-annonce-".$validateDataInput['annonceid']."').is(':visible') ) {
                        $('.res_button_details#res-annonce-".$validateDataInput['annonceid']."').nextAll('.res-custom-popup').toggle();
                    } else {
                        showPopup($('#annonce-".$validateDataInput['annonceid']."').nextAll('.custom-popup'));
                    }
                });
            </script>";
            
        }
            ?>
</section>