<?php
/* 
 * Page de redirection du module d'inscription lorsque la page n'est pas accessible
 */

include_once(__DIR__ . '/../templates/header.php');
?>
<div class="content-central-column">
    <section>
        <?php
        while (have_posts()) :
            the_post();
            the_content();
        endwhile;

        ?>
    </section>
</div>
<?php

include_once(__DIR__ . '/../templates/footer.php');

