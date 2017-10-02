<?php
/* 
 * Message afficher si compte non activé
 */
?>
<div class="content-central-column">
    <section>
        <div class="bloc-content">
            <h1>Validation du compte</h1>
            </div>
        <div class='bloc-content-effect'></div>

        <div class="bloc-content">
            <?php
            if(isset($params['demande']) && $params['demande'] == 1) {
                ?>
                    <p>Un email de validation vous indiquant la procédure pour activer
                        votre compte vient de vous être envoyé. Veuillez vérifier votre boite mail.</p>
                    <?php
                    
            } else {
                ?>
                    <p>Le compte associé à l'adresse mail <?php echo $params['login']; ?> n'est pas validé.<br>
                    Veuillez vérifier votre boîte mail ou cliquer sur le lien ci-dessous pour recevoir un nouveau mail de validation
                    si vous ne l'avez pas reçu :
                </p>
                <div class="bar_call_buttons">
                    <a class="call_button" href='/pe/inscription/validation.php?login=<?php echo $params['login']; ?>&demande=1' >
                        Envoyez-moi un e-mail de validation</a>
                </div>
                <?php
            }
            ?>
        </div>
    </section><!--@whitespace
    --><aside>
        <?php
         include_once('sidebar-inscription.php');
        ?>
    </aside>
</div>

