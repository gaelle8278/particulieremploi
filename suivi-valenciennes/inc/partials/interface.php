<?php
/** 
 * Html of Interface 
 */

?>
<div class="content-central-column">
    <section>
        <div class="block-stats">
            <h2>Nombre de connexions par utilisateur</h2>
            <form method="POST" action="output.php">
                <div>
                    <label>Du</label>
                    <input type="text" name="date-debut" class="input-style" data-toggle="datepicker">
                    <label>au</label>
                    <input type="text" name="date-fin" class="input-style" data-toggle="datepicker">
                </div>
                <?php wp_nonce_field('stats_value_token', 'stats_action_nonce'); ?>
                <div class="bar-button-stats">
                    <input type="submit" value="Générer fichier" name="connexion">
                </div>
            </form>
        </div>
        <div class="block-stats">
            <h2>Nombre d'inscription effectués par utilisateur</h2>
            <form method="POST" action="output.php">
                <div>
                    <label>Du</label>
                    <input type="text" name="date-debut" class="input-style" data-toggle="datepicker">
                    <label>au</label>
                    <input type="text" name="date-fin" class="input-style" data-toggle="datepicker">
                </div>
                <?php wp_nonce_field('stats_value_token', 'stats_action_nonce'); ?>
                <div class="bar-button-stats">
                    <input type="submit" value="Générer fichier" name="inscription">
                </div>
            </form>
        </div>
        
        <div class="block-stats">
            <h2>Nombre d'inscription validées effectuées par utilisateur</h2>
            <form method="POST" action="output.php">
                <div>
                    <label>Du</label>
                    <input type="text" name="date-debut" class="input-style" data-toggle="datepicker">
                    <label>au</label>
                    <input type="text" name="date-fin" class="input-style" data-toggle="datepicker">
                </div>
                <?php wp_nonce_field('stats_value_token', 'stats_action_nonce'); ?>
                <div class="bar-button-stats">
                    <input type="submit" value="Générer fichier" name="inscription-val">
                </div>
            </form>
        </div>
    </section>
    <script>
    jQuery(document).ready( function($) {
        //jquery ui datepicker
        $('[data-toggle="datepicker"]').datepicker({
            dateFormat: "dd/mm/yy"
        });
    });
    </script>
</div>
