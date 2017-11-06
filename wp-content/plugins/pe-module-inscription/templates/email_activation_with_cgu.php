<?php
/**
 * Email contenant le lien d'activation du compte et le lien vers les CGU suite à l'inscription
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
?>

<body bgcolor="#d1d0d0">
    <table width="708" align="center" cellpadding="0" cellspacing="0" border="0">
 	<tr>
            <td width="708" valign="top" style="padding:0px;" bgcolor="#FFFFFF"><img src="<?php echo get_template_directory_uri(); ?>/images/email/img-top.jpg"
            style="display:block;" border="0" /></td>
        </tr>
    </table>
    <table width="708" align="center" cellpadding="0" cellspacing="0" border="0">
 	<tr>
            <td width="1" valign="top" style="padding:0px;" bgcolor="#cfcece"></td>
            <td width="1" valign="top" style="padding:0px;" bgcolor="#cbcaca"></td>
            <td width="1" valign="top" style="padding:0px;" bgcolor="#c6c5c5"></td>
            <td width="1" valign="top" style="padding:0px;" bgcolor="#bfbebe"></td>
            <td width="700" valign="top" style="padding:0px;" align="left" bgcolor="#FFFFFF">
                <table width="700" align="center" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td width="640" valign="top" style="padding:0 0 0 30px;" align="left" bgcolor="#FFFFFF">
                            <img src="<?php echo get_template_directory_uri() ?>/images/logo.png" style="display:block;" border="0" />
                        </td>
                    </tr>
                    <tr>
                        <td width="700" height="30" valign="top" style="padding:0px;" align="left" bgcolor="#FFFFFF"></td>
                    </tr>
                </table>
                <table width="700" align="center" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td width="30"></td>
                        <td width="640" valign="top" style="padding:0px; font-size:14px;
                            font-family:Verdana, sans-serif;" align="left" bgcolor="#FFFFFF">
                            Bonjour, <br>
                            <br>
                            Votre demande d'inscription comme
                            <span style="font-weight: bold;" >
                                <?php
                                if($type_compte=="emp") {
                                    ?>
                                    employeur à Particulier emploi
                                    <?php
                                } else {
                                    ?>
                                    comme salari&eacute; à Particulier emploi
                                    <?php
                                }
                                ?>
                            </span> a bien été prise en compte.<br>
                            <br>
                            Pour confirmer votre inscription, veuillez activer votre compte en cliquant sur le lien ci-après : <br>
                            <a href="<?php echo $linkActivation; ?>">
                                <?php echo $linkActivation; ?>
                            </a><br>
                            <br>
                            En cliquant sur le lien ci-dessus vous acceptez
                            <a style="font-weight:bold;color:#040089;text-decoration: none;" href="<?php echo get_permalink( ID_PAGE_CGU_PE ); ?>">les conditions générales de d'utilisation</a>
                            de Particulier emploi.<br>
                            <br>
                            L'activation de votre compte vous donnera un accès complet à votre espace de mise en relation grâce au code d'accès suivant :<br>
                            <br>
                            <strong>Adresse e-mail : </strong><?php echo $to; ?><br>
                            <strong>Mot de passe</strong> : <?php echo $pwd; ?><br>
                            <br>
                            Nous vous remercions de l'intérêt pour nos services.<br><br>
                            L'&eacute;quipe Particulier Emploi
                        </td>
                        <td width="30"></td>
                    </tr>
                </table>

                <table width="700" align="center" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td width="700" height="20" valign="top" style="padding:0px;" align="center" bgcolor="#FFFFFF"></td>
                    </tr>
                </table>

            </td>
            <td width="1" valign="top" style="padding:0px;" bgcolor="#bfbebe"></td>
            <td width="1" valign="top" style="padding:0px;" bgcolor="#c6c5c5"></td>
            <td width="1" valign="top" style="padding:0px;" bgcolor="#cbcaca"></td>
            <td width="1" valign="top" style="padding:0px;" bgcolor="#cfcece"></td>
        </tr>
    </table>
    <table width="708" align="center" cellpadding="0" cellspacing="0" border="0">
 	<tr>
            <td width="708" valign="top" style="padding:0px;" bgcolor="#FFFFFF">
                <img src="<?php echo get_template_directory_uri(); ?>/images/email/img-bottom.jpg" style="display:block;" border="0" />
            </td>
        </tr>
    </table>
</body>



