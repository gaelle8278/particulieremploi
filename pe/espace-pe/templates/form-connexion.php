<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<form action="/pe/espace-pe/login.php" method="post">
    <?php
    if (isset($insConnexion['idAnnonce'])) {
        ?>
        <input type="hidden" name="idAnnonce" value="<?php echo $insConnexion['idAnnonce']; ?>" />
        <?php
    }
    if (isset($validateGetParam['erreurForm'])) {
        echo "<p class='error-input'>".$validateGetParam['erreurForm']."</p>";
    }
    ?>
    <div class="bloc-field-form">
        <label class="field-label" for="form-email">Adresse e-mail <span class="field-required">*</span></label>
        <div class="field-value">
            <input type="text" placeholder="" name="email" id="form-email" class="input-style" size="50" />
            <?php
            if (isset($validateGetParam['erreurEmail'])) {
                echo "<p  class='error-input'>".$validateGetParam['erreurEmail']."</p>";
            }
            ?>
        </div>
    </div>
    <div class="bloc-field-form">
        <label class="field-label" for="form-mdp">Mot de passe <span class="field-required">*</span></label>
        <div class="field-value">
            <input type="password" placeholder="" name="password" id="form-mdp" class="input-style" size="20" />
            <a href="/pe/espace-pe/motdepasse.php" class="content-link text-smaller">Mot de passe oublié ?</a>
            <?php
            if (isset($validateGetParam['erreurPassword'])) {
                echo "<p  class='error-input'>".$validateGetParam['erreurPassword']."</p>";
            }
            ?>
        </div>
    </div>
    <div class="bloc-submit-form">
        <input type="submit" value="Se connecter">
    </div>
</form>

       

