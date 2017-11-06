<?php

/**
 * Envoi de l'email suite à la perte du mot de passe
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */

$server= get_template_directory_uri();
// définition du contenu
$content='
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
                	<td width="700" valign="top" style="padding:0px;" align="left" bgcolor="#FFFFFF"><img src="'.$server.'/images/email/logo_PE.jpg" style="display:block;" border="0" /></td>
                </tr>
                <tr>
                	<td width="700" height="30" valign="top" style="padding:0px;" align="left" bgcolor="#FFFFFF"></td>
                </tr>
            </table>
            <table width="700" align="center" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="30"></td>
                    <td width="640" valign="top" style="padding:0px; font-size:16px;" align="left" bgcolor="#FFFFFF">';
if($type_compte=="EMP") {
    $content .= '<font face="Georgia, Times New Roman, Times, serif" color="#ed7e01"><strong>Vous êtes employeur';
} else {
    $content.= '<font face="Georgia, Times New Roman, Times, serif" color="#3e80af"><strong>Vous êtes salarié';
}
$content .='</strong></font></td>
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
                    <td width="640" valign="top" style="padding:0px; font-size:13px;" align="left" bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans serif" color="#000000"><strong>
                    Bonjour,</strong><br/><br/>Veuillez trouver vos paramètres de connexion, avec votre nouveau mot de passe :<br/><br/>
                    Compte d\'acc&egrave;s : <strong>'.$to.'</strong><br/>
Mot de passe : <strong>'.$password.'</strong><br/><br/>Vous pouvez d&eacute;sormais vous connecter en cliquant sur d&eacute;j&agrave; inscrit, acc&eacute;dez &agrave; votre compte et en saisissant vos param&egrave;tres.<br/><br/>Vous pouvez &eacute;galement personnaliser votre mot de passe depuis votre espace d&eacute;di&eacute;.<br/><br/>Merci de l\'int&eacute;r&ecirc;t que vous portez &agrave; notre site.<br/><br/></font></td>
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
                	<td width="30"></td>
                    <td width="640" valign="top" style="padding:0px; font-size:13px;" align="right" bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans serif" color="#000000">
                    &Agrave; bient&ocirc;t sur <strong><a href="www.particulieremploi.fr" target="_blank" style="text-decoration:none;"><font color="#000000">www.particulieremploi.fr</font></a></strong></font></td>
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
                	<td width="700" valign="top" style="padding:0px;" align="center" bgcolor="#FFFFFF">
                        <a  href="https://'.$_SERVER['SERVER_NAME'].'/pe/espace-pe/connexion.php" target="_blank">';
if($type_compte=="EMP") {
    $content .= '<img src="'.$server.'/images/email/btn-acces-compte_employeur.jpg" style="display:block;" border="0" />';
} else {
    $content.= '<img src="'.$server.'/images/email/btn-acces-compte_salarie.jpg" style="display:block;" border="0" />';
}

$content .= '
            </a></td>
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


// envoi du mail
$subject = "Particulieremploi.fr : récupération mot de passe";
$headers = 'From: Particulieremploi.fr <contact@particulieremploi.fr>';
    //set content-type
add_filter( 'wp_mail_content_type', 'set_html_content_type' );
$status = wp_mail($to, $subject, $content,$headers);
    // Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

function set_html_content_type() {
	return 'text/html';
}
