<?php
/**
* Page de l'étape 1 du module de génération du contrat.
 * 
 * Cette page contient un mode d'emploi et le choix de générer différents types de contrat.
*/
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Choix du type de contrat à générer</title>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
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
                <h1>Générateur de contrat de travail</h1>
                <p>Pour pouvoir générer un modèle de contrat de travail, nous vous remercions de sélectionner ci-après la nature du contrat de travail </p>
                <div class="bloc-2-buttons">
                    <div class="button-contrat">
                        <a href="http://<?php echo $_SERVER['SERVER_NAME'] ?>/contrats/informations-contrat.php?type=cdipe" title="lien pour générer un CDI du particulier employeur">
                            CDI <br /><span class="button-label">salarié du particulier employeur</span>
                        </a> 
                    </div>
                    <div class="button-contrat">
                        <a href="http://<?php echo $_SERVER['SERVER_NAME'] ?>/contrats/informations-contrat.php?type=cddtp" title="lien pour générer un CDD terme précis">
                            CDD<br /><span class="button-label">terme précis</span>
                        </a> 
                    </div>
                </div>
                <div class="bloc-2-buttons">
                    <div class="button-contrat">
                        <a href="http://<?php echo $_SERVER['SERVER_NAME'] ?>/contrats/informations-contrat.php?type=cdigp" title="lien pour générer un CDI de garde partagée">
                            CDI<br /><span class="button-label">garde partagée</span>
                        </a>
                    </div>
                    <div class="button-contrat">
                        <a href="http://<?php echo $_SERVER['SERVER_NAME'] ?>/contrats/informations-contrat.php?type=cddti" title="lien pour générer un CDD terme imprécis">
                            CDD <br /><span class="button-label">terme imprécis</span>
                        </a>
                    </div>
                </div>
                <div class="mentions-speciales">
                    <p>La conclusion d'un contrat à durée déterminée (CDD) n'est possible que pour l'exécution d'une tâche précise et temporaire 
                        et seulement dans les cas énumérées par la loi. A défaut, c'est bien un CDI qu'il convient de signer.</p>
                    <p>Si vous souhaitez être accompagné dans la rédaction de votre contrat de travail, vous pouvez 
                        <a href="" title="lien pour souscrire à une consultation">souscrire à une consultation</a> :
                        votre contrat de travail sera alors validé par le service juridique de la FEPEM.</p>
                    <p>A défaut de validation du contrat par le service juridique de la FEPEM, la FEPEM décline 
                        toute responsabilité en cas de contentieux liés à l'utilisation des modèles proposés.</p>
                </div>
            </div>
        </div>
    </body>
    <script>
        $(function() {
            $( ".button-contrat a" ).button();
        });
  </script>