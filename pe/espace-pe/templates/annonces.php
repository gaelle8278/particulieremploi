<?php

/**
 * Template d'affichage des annonces/offres
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
                    echo "Mes candidatures déposées";
                } else {
                    echo "Mes offres d'emploi";
                }
              ?>
            </p>
            <p class="bloc-header-teaser">
                <?php
                if($_SESSION['utilisateur_groupe'] == 'SAL') {
                    if($nbresult > 0) {
                        echo $nbresult." candidatures(s)";
                    } else {
                        echo "Aucune candidature déposée";
                    }
                } else {
                    if($nbresult > 0) {
                        echo $nbresult." offre(s)";
                    }
                    else {
                        echo "Aucune offre déposée.";
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
                        $link_suppr= "/pe/espace-pe/annonces.php?part=supprimer&annonceid=".$annonceid[$g];
                        if($_SESSION['utilisateur_groupe'] == 'EMP') {
                            $message_confirm="Voulez-vous supprimer cette offre d'emploi ?";
                        } else {
                            $message_confirm="Voulez-vous supprimer cette candidature ?";
                        }
                        ?>
                        <a href="<?php echo $link_suppr; ?>" class="suppr-button" data-message="<?php echo $message_confirm; ?>"></a>
                        
                        <p class="bloc-annonce-title"><?php echo stripslashes($metier[$g]);?></p>
                        <p><span class="txt-bold"> Référence : </span><?php echo $annonceid[$g];?></p>
                        <p><span class="txt-bold">Disponible à partir du : </span>
                            <?php echo $annoncedateprisefonction[$g];?>
                        </p>
                        <p><span class="txt-bold">Publié le : </span>
                            <?php echo $annoncedatecrea[$g];?>
                        </p>
                        <p><span class="txt-bold">Localisation : </span>
                            <?php  
                            if ($cpo[$g]!=""){
                                echo $cpo[$g].', ';
                            }
                            echo $ville[$g];
                            ?>
                        </p>
                        <p><span class="txt-bold">Emploi(s)-repère(s) : </span>
                        <?php 
                            if(!empty($annonceemploirepere[$g])) {
                                echo $annonceemploirepere[$g];
                            }
                            else {
                                echo "Non précisé";
                            }
                            ?>
                        </p>
                        <p>
                            <span>Vue : </span> <?php echo $annoncevisites[$g] == "" ? '0 fois' : $annoncevisites[$g].' fois' ?>
                        </p>
                       
                        <div class="bloc-buttons-espacepe">
                            <?php
                            $link_modif= "/pe/inscription/conditions.php?metierid=".$idmetier[$g]."&firstannonce=0";
                            ?>
                            <a href="<?php echo $link_modif; ?>">Modifier</a>
                            <?php
                            $link_detail ="/pe/espace-pe/details_offre.php?annonceid=".$annonceid[$g];
                            ?>
                            <a href="<?php echo $link_detail; ?>"  class="button_details"  >Voir le détail</a>
                            <input type="button" class="res_button_details" value="Voir le détail" />

                            <div class="custom-popup">
                                <?php
                                $label_taux="";
                                if ($_SESSION['utilisateur_groupe'] == 'EMP') {
                                    $label_taux= "Taux brut proposé";
                                } else if ($_SESSION['utilisateur_groupe'] == 'SAL') {
                                    $label_taux= "Taux brut souhaité";
                                }
                                ?>
                                <div class="popup-title">
                                    <?php
                                    if ($_SESSION['utilisateur_groupe'] == 'EMP') {
                                        echo "Détail de l'offre";
                                    } else if ($_SESSION['utilisateur_groupe'] == 'SAL') {
                                        echo "Détail de l'annonce";
                                    }
                                    ?>
                                </div>
                                <p><span class="text-bold">Référence annonce : </span><?php echo $annonceid[$g]; ?> </p>
                                <p><span class="text-bold">Métier : </span><?php echo stripslashes($metier[$g]); ?> </p>
                                <p><span class="text-bold">Expérience souhaitée dans ce métier : </span><?php echo $experience[$g]; ?> </p>
                                <p><span class="text-bold">Particularités sur l'exercice du métier : </span><?php echo stripslashes($description[$g]); ?> </p>
                                <p><span class="text-bold"><?php echo $label_taux; ?> (hors Cesu, hors ancienneté) : </span><?php echo $tauxhoraire[$g]; ?> </p>
                                <p><span class="text-bold">Date de prise de fonction : </span><?php echo $annoncedateprisefonction[$g]; ?> </p>
                                <p><span class="text-bold">Adresse : </span><?php echo $adresse[$g]; ?> </p>
                                <p><span class="text-bold">Code postal : </span><?php echo $cpo[$g]; ?> </p>
                                <p><span class="text-bold">Ville : </span><?php echo $ville[$g]; ?> </p>
                                <p><span class="text-bold">Horaires de travail souhaités : </span><?php echo $dureehebdo[$g]; ?> h/semaine</p>
                                <div class="popup-buttons">
                                    <input type="button" value="Ok" class="ok_button">
                                </div>
                                 <div class="close_button"></div>
                            </div>
                            <div class="res-custom-popup">
                                <p><span class="text-bold">Référence annonce : </span><?php echo $annonceid[$g]; ?> </p>
                                <p><span class="text-bold">Métier : </span><?php echo stripslashes($metier[$g]); ?> </p>
                                <p><span class="text-bold">Expérience souhaitée dans ce métier : </span><?php echo $experience[$g]; ?> </p>
                                <p><span class="text-bold">Particularités sur l'exercice du métier : </span><?php echo stripslashes($description[$g]); ?> </p>
                                <p><span class="text-bold"><?php echo $label_taux; ?> (hors Cesu, hors ancienneté) : </span><?php echo $tauxhoraire[$g]; ?> </p>
                                <p><span class="text-bold">Date de prise de fonction : </span><?php echo $annoncedateprisefonction[$g]; ?> </p>
                                <p><span class="text-bold">Adresse : </span><?php echo $adresse[$g]; ?> </p>
                                <p><span class="text-bold">Code postal : </span><?php echo $cpo[$g]; ?> </p>
                                <p><span class="text-bold">Ville : </span><?php echo $ville[$g]; ?> </p>
                                <p><span class="text-bold">Horaires de travail souhaités : </span><?php echo $dureehebdo[$g]; ?> h/semaine</p>
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
</section>
