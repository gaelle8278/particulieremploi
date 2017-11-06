<?php
/**
 * Envoi de l'email d'acivation du compte suite à l'inscription
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

$server= get_template_directory_uri();

$content = '
<body bgcolor="#d1d0d0">
    <table width="708" align="center" cellpadding="0" cellspacing="0" border="0">
 	<tr>
            <td width="708" valign="top" style="padding:0px;" bgcolor="#FFFFFF"><img src="'.$server.'/images/email/img-top.jpg"
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
                            <img src="'.$server.'/images/logo.png" style="display:block;" border="0" />
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
                            Votre demande d\'inscription comme ';
                            if($type_compte=="EMP") {
                                $content .= ' <span style="font-weight: bold;" >
                                               employeur à Particulier emploi';
                            } else {
                                $content.= '<span style="font-weight: bold;" >
                                                comme salari&eacute; à Particulier emploi';
                            }
                            $content .= '</span> a bien été prise en compte.<br>
                            <br>
                            Pour confirmer votre inscription, veuillez activer votre compte en cliquant sur le lien ci-après : <br>
                            <a href="https://'.$_SERVER['SERVER_NAME'].$linkActivation.'">
                                https://'.$_SERVER['SERVER_NAME'].$linkActivation.'
                            </a><br>
                            <br>
                            L\'activation de votre compte vous donne un accès complet à votre espace de mise en relation.<br>
                            <br>
                            Nous vous remercions de l\'intérêt pour nos services.<br><br>
                            L\'&eacute;quipe Particulier Emploi
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
                <img src="'.$server.'/images/email/img-bottom.jpg" style="display:block;" border="0" />
            </td>
        </tr>
    </table>
</body>
';


//envoi du mail
$headers = 'From: Particulieremploi.fr <contact@particulieremploi.fr>';
$subject = "Particulieremploi.fr - activation de votre compte";
    //set content-type
add_filter( 'wp_mail_content_type', 'set_html_content_type' );
$status = wp_mail($to, $subject, $content,$headers);
    // Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

function set_html_content_type() {
	return 'text/html';
}


