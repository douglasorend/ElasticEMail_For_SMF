<?php
/********************************************************************************
* Subs-ElasticEMail.spanish_latin.php - Subs of the Important Topics mod
*********************************************************************************
* This program is distributed in the hope that it is and will be useful, but
* WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY
* or FITNESS FOR A PARTICULAR PURPOSE,
***********************************************************************************
* Spanish translation by Rock Lee (https://www.bombercode.org) Copyright 2014-2018*
***********************************************************************************/

if (!defined('SMF'))
	die('Hacking attempt...');

$txt['elasticemail_title'] = 'Elastic EMail';
$txt['elasticemail_title_section'] = 'Elastic EMail configuraci&oacute;n';
$txt['elasticemail_no_ssl_support'] = '<strong>ERROR:</strong> &iexcl;Esta instalaci&oacute;n de PHP no tiene habilitada la compatibilidad con OpenSSL!<br /><br />Puede activar la opci&oacute;n &quot;No usar SSL para la comunicaci&oacute;n&quot; para evitar este error. De lo contrario, debe habilitarlo en su servidor u obtener su host para habilitar la compatibilidad con OpenSSL. &iexcl;Gracias!';
$txt['elasticemail_enable'] = '&iquest;Elastic EMail habilitado?';
$txt['elasticemail_no_ssl'] = '&iquest;No use SSL para la comunicaci&oacute;n?';
$txt['elasticemail_key'] = 'Elastic EMail clave API:';
$txt['elasticemail_test_api'] = 'Pruebe la clave API';
$txt['elasticemail_test_success'] = '&iexcl;La clave API es v&aacute;lida!';
$txt['elasticemail_test_failure'] = '&iexcl;La clave API no es v&aacute;lida!';
$txt['elasticemail_test_invalid'] = 'Incapaz de comunicarse con el servidor.';
$txt['elasticemail_test_results'] = 'Configuraci&oacute;n del dominio (seg&uacute;n lo informado por ElasticEMail.com)';
$txt['elasticemail_results_domain'] = 'Dominio utilizado para Elastic EMail:';
$txt['elasticemail_results_spf'] = '&iquest;Registro de SPF v&aacute;lido?';
$txt['elasticemail_results_dkim'] = '&iquest;Registro DKIM v&aacute;lido?';
$txt['elasticemail_results_mx'] = '&iquest;Registro MX v&aacute;lido?';
$txt['elasticemail_results_dmarc'] = '&iquest;Registro v&aacute;lido de DMARC?';
$txt['elasticemail_results_tracking'] = '&iquest;Se verifica el seguimiento del registro CNAME?';
$txt['elasticemail_no_domain_found'] = '<strong>ADVERTENCIA:</strong> No se ha encontrado ning&uacute;n dominio para el dominio &quot;%s&quot;. Aunque esto no significa que este mod no funcionar&aacute;...';
?>