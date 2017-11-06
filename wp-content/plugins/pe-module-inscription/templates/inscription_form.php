<?php
/* 
 * Formulaire d'inscription
 */
?>
<main>
    <div class="content-central-column">
        <section>
            <?php
            if(isset($_SESSION['officer-inscription']['form-error']) && !empty($_SESSION['officer-inscription']['form-error'])) {
                    ?>
                    <div class="bloc-content">
                        <p id="form-error" class="msg-error">Le formulaire contient des erreurs.</p>
                    </div>
                    <?php
            }
            ?>
            <div class="bloc-content">
                <form id="form-module-inscription" action="<?php echo plugins_url( 'inscription_registration.php', __FILE__ ); ?>" method="POST" >
                    <input type="hidden" value="<?php echo $type_compte ; ?>" name="type_compte" id="type_compte"/>
                    <h1 class="form-header">Etape 1 : Création de compte</h1>
                    <?php include_once(__DIR__ . '/../templates/inscription_form_compte.php'); ?>
                    <h1 class="form-header">Etape 2 : Choix du métier</h1>
                    <?php include_once(__DIR__ . '/../templates/inscription_form_metier.php'); ?>
                    <h1 class="form-header">Etape 3 : Rédaction de l'annonce</h1>
                    <?php include_once(__DIR__ . '/../templates/inscription_form_qualification.php'); ?>
                </form>
            </div>
            <?php $key = getKey(); ?>
            <script src="https://maps.google.com/maps?file=api&amp;v=2.x&amp;key=<?php echo $key;?>" type="text/javascript"></script>
            <script>
                <?php
                if ($type_compte=="sal") {
                    ?>
                    var type_compte= "sal";
                   <?php
                } elseif ($type_compte == "emp") {
                    ?>
                    var type_compte= "emp";
                    <?php
                }
                ?>
                    
            </script>
            <script src="<?php echo plugins_url('js/plugin.js', __DIR__ . "/../../"); ?>" type="text/javascript"></script>

            
        </section>
    </div>
</main>

