<?php
/**
* Page de l'étape 3 du module de génération de contrat.
 * 
 * Page résumant les informations saisies et donnant accès à la validation à la volée du contrat au format pdf
*/

require_once 'configuration.php';

?>
<!doctype html>
<html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Choix du type de contrat à générer</title>
        <link rel="stylesheet" href="contrats.css">
    </head>
    <body>
        <div class="container">
            <div class="header">
                <div class="top_header">
                    <div class="div_header div_header_left"> 
                        <img src="/contrats/img/logo_fepem.JPG" alt="logo fepem.fr">
                    </div>
                    <div class="div_header div_header_right">
                        Mon Espace <span>Particulier Employeur  </span>  
                    </div>
                </div>
            </div>
            <div class="main">
                <div class="content">
                    <h1>Générateur de contrat de travail</h1>
                    <?php 
                    //echo "<pre>";print_r($_POST);echo "</pre>";
                    if(!isset($_POST['emploiRepere'])) {
                        echo "</p>Aucun emploi-repère n'a été sélectionné</p>";
                    } else {
                        $allSelectedER=array();
                        foreach ($_POST['emploiRepere'] as $idERSelected) {
                            //echo  $idERSelected;
                            if(in_array($idERSelected,array_keys($tabAllER))) {
                                $allSelectedER[]=$idERSelected;
                            }
                        }
                        //print_r($allSelectedER);
                        if (empty($allSelectedER)) {
                            echo "<p>L'emploi-repère sélectionné n'existe pas</p>";
                        } else {
                            echo "<p>Vous avez sélectionné l(e)s emploi(s)-repère(s) :</p>";

                            foreach ($allSelectedER as $idER) {
                                echo "<div><strong>".$tabAllER[$idER]."</strong></div>";
                                echo $tabDescER[$idER];
                            } 
                            ?>
                            <div class="section pdfSection">
                                <h2>Contrat au format PDF</h2>
                                <form method="post" id="form-contrat" action="<?php echo 'http://'.$_SERVER['SERVER_NAME'].'/contrats/generation-contrat-'.rawurlencode($_POST['type']).'.php'; ?>" target="_blank">
                                    <input type="hidden" name ="type" value="<?php echo htmlspecialchars($_POST['type']); ?>" />
                                    <input type="hidden" name ="civiliteEmp" value="<?php echo htmlspecialchars($_POST['civiliteEmp']); ?>" />
                                    <input type="hidden" name ="nomEmp" value="<?php echo htmlspecialchars($_POST['nomEmp']); ?>" />
                                    <input type="hidden" name ="prenomEmp" value="<?php echo htmlspecialchars($_POST['prenomEmp']); ?>" />
                                    <input type="hidden" name ="adresseEmp" value="<?php echo htmlspecialchars($_POST['adresseEmp']); ?>" />
                                    <input type="hidden" name ="cpoEmp" value="<?php echo htmlspecialchars($_POST['cpoEmp']); ?>" />
                                    <input type="hidden" name ="villeEmp" value="<?php echo htmlspecialchars($_POST['villeEmp']); ?>" />
                                    <input type="hidden" name ="civiliteSal" value="<?php echo htmlspecialchars($_POST['civiliteSal']); ?>" />
                                    <input type="hidden" name ="nomSal" value="<?php echo htmlspecialchars($_POST['nomSal']); ?>" />
                                    <input type="hidden" name ="prenomSal" value="<?php echo htmlspecialchars($_POST['prenomSal']); ?>" />
                                    <input type="hidden" name ="adresseSal" value="<?php echo htmlspecialchars($_POST['adresseSal']); ?>" />
                                    <input type="hidden" name ="cpoSal" value="<?php echo htmlspecialchars($_POST['cpoSal']); ?>" />
                                    <input type="hidden" name ="villeSal" value="<?php echo htmlspecialchars($_POST['villeSal']); ?>" />
                                    <input type="hidden" name ="domaineActivite" value="<?php echo htmlspecialchars($_POST['domaineActivite']); ?>" />
                                    <input type="hidden" name ="emploiRepere" value="<?php echo implode(',',$allSelectedER); ?>" />

                                    <div>
                                        <input class='submit' type="submit" value="Générer le contrat au format PDF">
                                    </div>
                                </form>
                            </div>
                            <div class="section wordSection">
                                <h2>Contrat au format Word</h2>
                                <form method="post" id="form-contrat" action="<?php echo 'http://'.$_SERVER['SERVER_NAME'].'/contrats/generation-contrat-word-'.rawurlencode($_POST['type']).'.php'; ?>" target="_blank">
                                    <input type="hidden" name ="type" value="<?php echo htmlspecialchars($_POST['type']); ?>" />
                                    <input type="hidden" name ="civiliteEmp" value="<?php echo htmlspecialchars($_POST['civiliteEmp']); ?>" />
                                    <input type="hidden" name ="nomEmp" value="<?php echo htmlspecialchars($_POST['nomEmp']); ?>" />
                                    <input type="hidden" name ="prenomEmp" value="<?php echo htmlspecialchars($_POST['prenomEmp']); ?>" />
                                    <input type="hidden" name ="adresseEmp" value="<?php echo htmlspecialchars($_POST['adresseEmp']); ?>" />
                                    <input type="hidden" name ="cpoEmp" value="<?php echo htmlspecialchars($_POST['cpoEmp']); ?>" />
                                    <input type="hidden" name ="villeEmp" value="<?php echo htmlspecialchars($_POST['villeEmp']); ?>" />
                                    <input type="hidden" name ="civiliteSal" value="<?php echo htmlspecialchars($_POST['civiliteSal']); ?>" />
                                    <input type="hidden" name ="nomSal" value="<?php echo htmlspecialchars($_POST['nomSal']); ?>" />
                                    <input type="hidden" name ="prenomSal" value="<?php echo htmlspecialchars($_POST['prenomSal']); ?>" />
                                    <input type="hidden" name ="adresseSal" value="<?php echo htmlspecialchars($_POST['adresseSal']); ?>" />
                                    <input type="hidden" name ="cpoSal" value="<?php echo htmlspecialchars($_POST['cpoSal']); ?>" />
                                    <input type="hidden" name ="villeSal" value="<?php echo htmlspecialchars($_POST['villeSal']); ?>" />
                                    <input type="hidden" name ="domaineActivite" value="<?php echo htmlspecialchars($_POST['domaineActivite']); ?>" />
                                    <input type="hidden" name ="emploiRepere" value="<?php echo implode(',',$allSelectedER); ?>" />

                                    <div>
                                        <input class='submit' type="submit" value="Générer le contrat au format Word">
                                    </div>
                                </form>
                                <div class="section">
                                    <div>Annexe(s) :</div>
                                    <?php
                                    foreach ($allSelectedER as $idER) {
                                        ?>
                                        <div>
                                            <a class="button-link"href="<?php echo 'http://'.$_SERVER['SERVER_NAME'].'/contrats/fiches-word/emploi-repere-'.$idER;?>" title="lien document word annexe emploi-repère <?php echo $tabAllER[$idER];?>">Annexe emploi-repère <?php echo $tabAllER[$idER];?></a>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>

                        <?php
                        }
                    }
                   ?>
                    
                </div>
            </div>
        </div>
    </body>
</html>
