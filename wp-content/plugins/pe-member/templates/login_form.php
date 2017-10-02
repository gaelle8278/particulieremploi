<?php
/* 
 * Code du shortcode affichant un formulaire de connexion
 *
 */
?>
<div class="login-form-container">
    <!-- shortcode attribute to indicate if a title is displayed or not -->
    <?php if ( $attributes['show_title'] ) : ?>
        <h2><?php echo "Connexion" ?></h2>
    <?php endif; ?>

    <!-- Erreurs à la connexion -->
    <?php if ( count( $attributes['errors'] ) > 0 ) : ?>
        <?php foreach ( $attributes['errors'] as $error ) : ?>
            <p class="login-error">
                <?php echo $error; ?>
            </p>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Message après déconnexion -->
    <?php if ( $attributes['logged_out'] ) : ?>
        <p class="login-info">
            <?php echo "Vous êtes déconnecté."; ?>
        </p>
    <?php endif; ?>


    <div class="login-form-container">
        <form method="post" action="<?php echo wp_login_url(); ?>">
            <div class="bloc-field-form">
                <label for="user_login">Votre e-mail </label>
                <div  class="field-label"class="field-value">
                    <input type="text" name="log" id="user_login" class="input-style">
                </div>
            </div>
            <div class="bloc-field-form">
                <label class="field-label" for="user_pass">Votre mot de passe</label>
                <div class="field-value">
                    <input type="password" name="pwd" id="user_pass" class="input-style">
                </div>
            </div>
            <div class="bloc-submit-form">
                <input type="submit" value="Se connecter">
            </div>
        </form>
    </div>

</div>