<?php
/**
* Page de l'étape 2 du module de génération de contrat.
 * 
 * Formulaire pour indiquer les informations nécessaires à l'établissement du contrat.
*/
require_once 'configuration.php';

?>
<!doctype html>
<html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Choix du type de contrat à générer</title>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css" media="all">
        <link rel="stylesheet" href="contrats.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
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
                <?php
                //Récupération et filtrage du paramètre get type
                if(!isset($_GET['type'])) {
                     echo "<p>Aucun contrat ne peut être généré car aucun type n'a été choisi.</p>";
                } else {
                    $typeContrat=  htmlspecialchars($_GET['type']);
                }
                //on vérifie que la valeur type transmise est valide
                if($typeContrat !="cdipe" && $typeContrat!="cdigp" && $typeContrat!="cddtp" && $typeContrat!="cddti") {
                    echo "<p>Le type de contrat demandé ne peut pas être généré.</p>";
                } else {
                ?>
                    <h1>Générateur de contrat de travail</h1>
                    <p>Vous avez choisi le contrat : <?php echo constant(strtoupper($typeContrat)); ?>.</p>
                    <p>Nous vous remercions de remplir le formulaire ci-après pour générer le modèle contrat de travail du salarié.</p>
                    
                    <div class="bloc-form-infos">
                        <form method="post" id="form-contrat" action="<?php echo 'http://'.$_SERVER['SERVER_NAME'].'/contrats/validation-contrat.php'; ?>" >
                            <input type="hidden" name="type" value="<?php echo $typeContrat; ?>" />
                            <div class="bloc-section">
                                <h2>Vos coordonnées</h2>
                                <div class="bloc-form-field">
                                    <div class="bloc-label bloc-label-common">Civilité  <span class='field-required'>*</span></div>
                                    <div class="bloc-reponse bloc-reponse-common">
                                        <div id="champsCiviliteEmp">
                                            <input type="radio" name="civiliteEmp" id="optCVMmeEmp" value="2" />
                                            <label for="optCVMmeEmp">Madame</label>
                                            <input type="radio" name="civiliteEmp" id="optCVMrEmp" value="1" />
                                            <label for="optCVMrEmp">Monsieur</label>
                                        </div>
                                        <div class="error-msg"></div>
                                    </div>
                                </div>
                                <div class="bloc-form-field">
                                    <div class="bloc-label bloc-label-common"> <label for="champsNomEmp">Nom <span class='field-required'>*</span></label></div>
                                    <div class="bloc-reponse bloc-reponse-common">
                                        <input type="text" name="nomEmp" id="champsNomEmp"  />
                                        <div class="error-msg"></div>
                                    </div>
                                </div>
                                <div class="bloc-form-field">
                                    <div class="bloc-label bloc-label-common"> <label for="champsPrenomEmp">Prénom <span class='field-required'>*</span></label></div>
                                    <div class="bloc-reponse bloc-reponse-common">
                                        <input type="text" name="prenomEmp" id="champsPrenomEmp"  />
                                        <div class="error-msg"></div>
                                    </div>
                                </div>
                                <div class="bloc-form-field">
                                    <div class="bloc-label bloc-label-common"> <label for="champsAdresseEmp">Adresse  <span class='field-required'>*</span></label></div>
                                    <div class="bloc-reponse bloc-reponse-common">
                                        <input type="text" name="adresseEmp" id="champsAdresseEmp" />
                                        <div class="error-msg"></div>
                                    </div>
                                </div>
                                <div class="bloc-form-field">
                                    <div class="bloc-label bloc-label-common"> <label for="champsCpoEmp">Code postal <span class='field-required'>*</span></label></div>
                                    <div class="bloc-reponse bloc-reponse-common">
                                        <input type="text" name="cpoEmp" id="champsCpoEmp" maxlength="5" />
                                        <div class="error-msg"></div>
                                    </div>
                                </div>
                                <div class="bloc-form-field">
                                    <div class="bloc-label bloc-label-common"> <label for="champsVilleEmp">Ville <span class='field-required'>*</span></label></div>
                                    <div class="bloc-reponse bloc-reponse-common">
                                        <input type="text" name="villeEmp" id="champsVilleEmp"  />
                                        <div class="error-msg"></div>
                                    </div>
                                </div>
                                <div><span class='field-required'>*</span> champs obligatoires</div>
                            </div>
                            <div class="bloc-section">
                                <h2>Les coordonnées de votre salarié</h2>
                                <div class="bloc-form-field">
                                    <div class="bloc-label bloc-label-common">Civilité  <span class='field-required'>*</span></div>
                                    <div class="bloc-reponse bloc-reponse-common">
                                        <div id="champsCiviliteSal">
                                            <input type="radio" name="civiliteSal" id="optCVMmeSal" value="2" class="radioUI validate-one-required"  />
                                            <label for="optCVMmeSal" class="radioStyle">Madame</label>
                                            <input type="radio" name="civiliteSal" id="optCVMrSal" value="1" class="radioUI" />
                                            <label for="optCVMrSal" class="radioStyle">Monsieur</label>
                                        </div>
                                        <div class="error-msg"></div>
                                    </div>
                                </div>
                                <div class="bloc-form-field">
                                    <div class="bloc-label bloc-label-common"> <label for="champsNomSal">Nom <span class='field-required'>*</span></label></div>
                                    <div class="bloc-reponse bloc-reponse-common">
                                        <input type="text" name="nomSal" id="champsNomSal"  />
                                        <div class="error-msg"></div>
                                    </div>
                                </div>
                                <div class="bloc-form-field">
                                    <div class="bloc-label bloc-label-common"> <label for="champsPrenomSal">Prénom <span class='field-required'>*</span></label></div>
                                    <div class="bloc-reponse bloc-reponse-common">
                                        <input type="text" name="prenomSal" id="champsPrenomSal"  />
                                        <div class="error-msg"></div>
                                    </div>
                                </div>
                                <div class="bloc-form-field">
                                    <div class="bloc-label bloc-label-common"> <label for="champsAdresseSal">Adresse  <span class='field-required'>*</span></label></div>
                                    <div class="bloc-reponse bloc-reponse-common">
                                        <input type="text" name="adresseSal" id="champsAdresseSal" />
                                        <div class="error-msg"></div>
                                    </div>
                                </div>
                                <div class="bloc-form-field">
                                    <div class="bloc-label bloc-label-common"> <label for="champsCpoSal">Code postal <span class='field-required'>*</span></label></div>
                                    <div class="bloc-reponse bloc-reponse-common">
                                        <input type="text" name="cpoSal" id="champsCpoSal" maxlength="5" />
                                        <div class="error-msg"></div>
                                    </div>
                                </div>
                                <div class="bloc-form-field">
                                    <div class="bloc-label bloc-label-common"> <label for="champsVilleSal">Ville <span class='field-required'>*</span></label></div>
                                    <div class="bloc-reponse bloc-reponse-common">
                                        <input type="text" name="villeSal" id="champsVilleSal"  />
                                        <div class="error-msg"></div>
                                    </div>
                                </div>
                                <div><span class='field-required'>*</span> champs obligatoires</div>
                            </div>
                            <div class="bloc-section">
                                <h2>L'emploi de votre salarié</h2>
                                <p>Avant de sélectionner votre emploi-repère dans la liste ci-après, nous vous suggérons de déterminer l'emploi-repère du salarié
                                sur le simulateur de la branche accessible à cette adresse : <br/>
                                <a href='http://simulateur-emploisalarieduparticulieremployeur.fr' title='lien simulateur emploi salarié du particulier employeur' target='_blank'>
                                    www.simulateur-emploisalarieduparticulieremployeur.fr</a>
                                </p>
                                <!-- domaines activites -->
                                <div class="bloc-label bloc-label-select" id="bloc-domaines-activites"> <label>Sélectionner le domaine d'activités</label>
                                </div>
                                <div class="bloc-reponse bloc-reponse-select" id="champsDomainesA">
                                    <div class="select-style">
                                        <select name="domaineActivite" id="domaineActivite">
                                                <option value="0">Liste des domaines d'activités</option>
                                                <?php

                                                    foreach ($tabDomaineActivite as $idDomaine=>$nomdomaine) {

                                                        //echo "<optgroup label='".$domainER."'>";
                                                        //foreach ($listER as $idER=>$nameER) {
                                                            echo '<option value="'.$idDomaine.'">';
                                                            echo $nomdomaine.' </option>';
                                                        //}

                                                       //echo "<optgroup>";
                                                    }
                                               ?>
                                        </select>
                                    </div>
                                    <div class="error-msg"></div>
                                </div>
                                
                                <!-- emplois-reperes -->
                                <div id="bloc-select-ER">
                                    <div class="bloc-label bloc-label-select" > 
                                        <label>Choisir votre emploi-repère dans la liste</label>
                                    </div>
                                    <div class="bloc-reponse bloc-reponse-select">
                                            <?php
                                            foreach ($tabDomaineActivite as $idDomaine=>$nomDomaine) {
                                                echo '<div class="bloc-choix-ER" id="domaine_'.$idDomaine.'">';
                                                    foreach ($tabER[$nomDomaine] as $idER=>$nomER){
                                                        echo "<p>
                                                            <input id='er_".$idER."' name='emploiRepere[]' type='checkbox' value='".$idER."' class='checkBoxUI' /> 
                                                            <label for='er_".$idER."'class='checkBoxStyle'>$nomER</label>
                                                            </p>";
                                                    }
                                                echo "</div>"; 
                                            }
                                            ?>
                                        <div class="error-msg"></div>
                                    </div>
                                </div>
                                 
                                
                                
                                <div><span class='field-required'>*</span> champs obligatoires</div>
                            </div> 
                            <div class="bar-button">
                                <div class="button-valid">
                                    <input class='btn-valider' type="submit" value="Valider" id="envoyer">
                                </div>
                            </div>
                        </form>
                    </div>
                <?php
                }
                ?>
                  
            </div>
        </div>
        <script>
            $(function() {
                $(".btn-valider").button();
                
                // au chargement les emplois-repères sont masqués
                $('#bloc-select-ER').hide();
                
                
                $('#domaineActivite').change(function () {
                    //récupération du domaine sélectionné
                    selectedDomaine =  $("#domaineActivite option:selected").val(); 
                    //tous les emplois-repères sont décochés : on ne peut sélectionner que des ER d'un meme domaine
                    $("input[type=checkbox]").each(function () {
                            $(this).prop('checked',false);
                            $(this).next("label").removeClass("checkBoxUIActive");
                    });
                    //les bloc emplois-repère son masqués
                    $(".bloc-choix-ER").each(function () {
                            $(this).hide();
                        });
                    //on affiche les ER du domaine sélectionné
                    $('#domaine_'+selectedDomaine).show();
                    
                    /*if(selectedDomaine==0){
                        $(".bloc-choix-ER").each(function () {
                            $(this).show();
                        });
                    }
                    else {
                        $(".bloc-choix-ER").each(function () {
                            $(this).hide();
                        });
                        $('#domaine_'+selectedDomaine).show();
                    }*/
                    $('#bloc-select-ER').show();
 
                });
                
                $("#envoyer").click(function() {
                    valide=true;
                    verifnum= /^[0-9]+$/;
                    nbSelectER=$("input[type=checkbox]:checked").length;
                    //alert(nbSelectER);
                    
                    if($('input[name=civiliteEmp]:checked').length==0) {
                        $('#champsCiviliteEmp').next(".error-msg").show().text("Merci d'indiquer votre civilité"); 
                        valide=false;
                    } else {
                        $('#champsCiviliteEmp').next(".error-msg").hide().text("");
                    }
                    if($('#champsNomEmp').val() =="") {
                        $('#champsNomEmp').next(".error-msg").show().text("Merci de renseigner votre nom"); 
                        valide=false;
                    } else {
                        $('#champsNomEmp').next(".error-msg").hide().text("");
                    }
                    if($('#champsPrenomEmp').val() =="") {
                        $('#champsPrenomEmp').next(".error-msg").show().text("Merci de renseigner votre prénom"); 
                        valide=false;
                    } else {
                        $('#champsPrenomEmp').next(".error-msg").hide().text("");
                    }
                    if($('#champsAdresseEmp').val() =="") {
                        $('#champsAdresseEmp').next(".error-msg").show().text("Merci de renseigner votre adresse"); 
                        valide=false;
                    } else {
                        $('#champsAdresseEmp').next(".error-msg").hide().text("");
                    }
                    if($('#champsCpoEmp').val() =="") {
                        $('#champsCpoEmp').next(".error-msg").show().text("Merci de renseigner votre code postal"); 
                        valide=false;
                    } else if(!verifnum.test($('#champsCpoEmp').val())) {
                        $('#champsCpoEmp').next(".error-msg").show().text("Le code postal doit être un chiffre"); 
                        valide=false;
                    } else if($('#champsCpoEmp').val().length != 5) {
                        $('#champsCpoEmp').next(".error-msg").show().text("Le code postal doit comporter 5 chiffres"); 
                        valide=false;
                    } else {
                        $('#champsCpoEmp').next(".error-msg").hide().text("");
                    }
                    if($('#champsVilleEmp').val() =="") {
                        $('#champsVilleEmp').next(".error-msg").show().text("Merci de renseigner votre ville"); 
                        valide=false;
                    } else {
                        $('#champsVilleEmp').next(".error-msg").hide().text("");
                    }
                    
                    if($('input[name=civiliteSal]:checked').length==0) {
                        $('#champsCiviliteSal').next(".error-msg").show().text("Merci d'indiquer la civilité du salarié"); 
                        valide=false;
                    } else {
                        $('#champsCiviliteSal').next(".error-msg").hide().text("");
                    }
                    if($('#champsNomSal').val() =="") {
                        $('#champsNomSal').next(".error-msg").show().text("Merci de renseigner le nom du salarié"); 
                        valide=false;
                    } else {
                        $('#champsNomSal').next(".error-msg").hide().text("");
                    }
                    if($('#champsPrenomSal').val() =="") {
                        $('#champsPrenomSal').next(".error-msg").show().text("Merci de renseigner le prénom de votre salarié"); 
                        valide=false;
                    } else {
                        $('#champsPrenomSal').next(".error-msg").hide().text("");
                    }
                    if($('#champsAdresseSal').val() =="") {
                        $('#champsAdresseSal').next(".error-msg").show().text("Merci de renseigner l'adresse de votre salarié"); 
                        valide=false;
                    } else {
                        $('#champsAdresseSal').next(".error-msg").hide().text("");
                    }
                    if($('#champsCpoSal').val() =="") {
                        $('#champsCpoSal').next(".error-msg").show().text("Merci de renseigner le code postal de votre salrié"); 
                        valide=false;
                    } else if(!verifnum.test($('#champsCpoSal').val())) {
                        $('#champsCpoSal').next(".error-msg").show().text("Le code postal doit être un chiffre"); 
                        valide=false;
                    } else if($('#champsCpoSal').val().length != 5) {
                        $('#champsCpoSal').next(".error-msg").show().text("Le code postal doit comporter 5 chiffres"); 
                        valide=false;
                    } else {
                        $('#champsCpoSal').next(".error-msg").hide().text("");
                    }
                    if($('#champsVilleSal').val() =="") {
                        $('#champsVilleSal').next(".error-msg").show().text("Merci de renseigner la ville de votre salarié"); 
                        valide=false;
                    } else {
                        $('#champsVilleSal').next(".error-msg").hide().text("");
                    }
                    
                    
                    /*if($('#emploiRepere option:selected').val()==0) {
                        $('#champsEmploiRepere').children(".error-msg").show().text("Merci de choisir un emploi-repère"); 
                        valide=false;
                    } else {
                        $('#champsEmploiRepere').children(".error-msg").hide().text("");
                    }*/
        
                    if($('#domaineActivite option:selected').val()==0) {
                        $('#champsDomainesA').children(".error-msg").show().text("Merci de choisir un domaine d'activité"); 
                        valide=false;
                    } else {
                        $('#champsDomainesA').children(".error-msg").hide().text("");
                    }
                    
                    if  (nbSelectER > 3) {
                        $('#bloc-select-ER').children('.bloc-reponse').children(".error-msg").show().text("Merci de choisir au maximum 3 emplois-repères");
                       valide=false;
                    } else if (nbSelectER  < 1) {
                        $('#bloc-select-ER').children('.bloc-reponse').children(".error-msg").show().text("Merci de choisir au moins 1 emploi-repère");
                       valide=false;
                    } else {
                        $('#bloc-select-ER').children('.bloc-reponse').children(".error-msg").hide().text("");
                    }
                    
                    
        
                   
                    return valide;
                });
                 
            });
            
           
        </script>
    </body>
</html>
