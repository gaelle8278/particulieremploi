<?php

/**
 * Envoi de l'email suite à l'inscription sur le site
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

$server= get_template_directory_uri();


$subject = "Confirmation de votre inscription à Particulieremploi.fr";

$content = '
<body bgcolor="#d1d0d0">
<table width="708" align="center" cellpadding="0" cellspacing="0" border="0">
 	<tr>
    	<td width="708" valign="top" style="padding:0px;" bgcolor="#FFFFFF"><img src="'.$server.'/images/email/img-top.jpg" style="display:block;" border="0" /></td>
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
                    <td width="640" valign="top" style="padding:0px; font-size:14px;" align="left" bgcolor="#FFFFFF">
                   ';
if($type_compte=="EMP") {
    $content .= ' <font face="Verdana, sans-serif" color="#ED7E01">
                    <strong>Vous &ecirc;tes inscrit comme employeur sur Particulier emploi';
} else {
    $content.= '<font face="Verdana, sans-serif" color="#3e80af">
                    <strong>Vous &ecirc;tes inscrit comme salari&eacute; sur Particulier emploi.';
}
$content .= '</strong>
                    </font>
                    </td>
                    <td width="30"></td>
                </tr>
            </table>
            <table width="700" align="center" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="700" height="40" valign="top" style="padding:0px; font-size:16px;" align="left" bgcolor="#FFFFFF"></td>
                </tr>
            </table>
            
            <table width="700" align="center" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="30"></td>
                    <td width="640" valign="top" style="padding:0px; font-size:14px;" align="left" bgcolor="#FFFFFF">
                        <font face="Verdana, sans-serif" color="#000000">
                        Vous trouverez ci-apr&egrave;s vos codes d\'acc&egrave;s pour vous connecter &agrave; votre compte et b&eacute;n&eacute;ficier de nos services de mise en relation.
                            <br/><br/><strong>Adresse e-mail : </strong>'.$email.'<br/>
                        <strong>Mot de passe</strong> : seul vous le connaissez<br/><br/>
                        </font>
                    </td>
                    <td width="30"></td>
                </tr>
            </table>
            <table width="700" align="center" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="700" height="20" valign="top" style="padding:0px;" align="center" bgcolor="#FFFFFF"></td>
                </tr>
            </table>
            
            <table width="700" align="center" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="700" valign="top" style="padding:0px;font-size:14px;font-family:Verdana, sans-serif;font-weight:bold;" align="center" bgcolor="#FFFFFF">
                        <a href="http://'.$_SERVER['SERVER_NAME'].'/pe/espace-pe/connexion.php" target="_blank">Acc&eacute;der &agrave; mon compte</a></td>
              </tr>
            </table>
            <table width="700" align="center" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="700" height="20" valign="top" style="padding:0px;" align="center" bgcolor="#FFFFFF"></td>
                </tr>
            </table>
            
            <table width="700" align="center" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                    <td width="30"></td>
                    <td width="640" valign="top" style="padding:0px; font-size:14px;" align="left" bgcolor="#FFFFFF">
                    <font face="Verdana, sans-serif" color="#000000">
                    Nous vous remercions de la confiance que vous nous accordez.<br>
                    &Agrave; bient&ocirc;t sur <strong><a href="http://www.particulieremploi.fr" target="_blank" style="text-decoration:none;">
                        <font color="#000000">www.particulieremploi.fr</font></a></strong><br><br>
                    L\'&eacute;quipe Particulier Emploi
                    </font></td>
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
    	<td width="708" valign="top" style="padding:0px;" bgcolor="#FFFFFF"><img src="'.$server.'/images/email/img-bottom.jpg" style="display:block;" border="0" /></td>
    </tr>
</table>
</body>
';


//envoi du mail
$headers = 'From: Particulieremploi.fr <contact@particulieremploi.fr>';
    //set content-type
add_filter( 'wp_mail_content_type', 'set_html_content_type' );
$status = wp_mail($to, $subject, $content,$headers);
    // Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

function set_html_content_type() {
	return 'text/html';
}