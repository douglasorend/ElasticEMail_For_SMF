<?php
/********************************************************************************
* Subs-ElasticEMail.spanish_latin-utf8.php - Subs of the Important Topics mod
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
$txt['elasticemail_title_section'] = 'Elastic EMail configuración';
$txt['elasticemail_no_ssl_support'] = '<strong>ERROR:</strong> ¡Esta instalación de PHP no tiene habilitada la compatibilidad con OpenSSL!<br /><br />Puede activar la opción "No usar SSL para la comunicación" para evitar este error. De lo contrario, debe habilitarlo en su servidor u obtener su host para habilitar la compatibilidad con OpenSSL. ¡Gracias!';
$txt['elasticemail_enable'] = '¿Elastic EMail habilitado?';
$txt['elasticemail_no_ssl'] = '¿No use SSL para la comunicación?';
$txt['elasticemail_key'] = 'Elastic EMail clave API:';
$txt['elasticemail_test_api'] = 'Pruebe la clave API';
$txt['elasticemail_test_success'] = '¡La clave API es válida!';
$txt['elasticemail_test_failure'] = '¡La clave API no es válida!';
$txt['elasticemail_test_invalid'] = 'Incapaz de comunicarse con el servidor.';
$txt['elasticemail_test_results'] = 'Configuración del dominio (según lo informado por ElasticEMail.com)';
$txt['elasticemail_results_domain'] = 'Dominio utilizado para Elastic EMail:';
$txt['elasticemail_results_spf'] = '¿Registro de SPF válido?';
$txt['elasticemail_results_dkim'] = '¿Registro DKIM válido?';
$txt['elasticemail_results_mx'] = '¿Registro MX válido?';
$txt['elasticemail_results_dmarc'] = '¿Registro válido de DMARC?';
$txt['elasticemail_results_tracking'] = '¿Se verifica el seguimiento del registro CNAME?';
$txt['elasticemail_no_domain_found'] = '<strong>ADVERTENCIA:</strong> No se ha encontrado ningún dominio para el dominio "%s". Aunque esto no significa que este mod no funcionará...';
?>