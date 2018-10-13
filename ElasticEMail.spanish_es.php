<?php
/********************************************************************************
* Subs-ElasticEMail.php - Subs of the Important Topics mod
*********************************************************************************
* Este programa se distribuye con la esperanza de que sea y será útil, pero
* SIN NINGUNA GARANTÍA; sin ninguna garantía implícita de COMERCIABILIDAD
* o APTITUD PARA UN PROPÓSITO PARTICULAR,
**********************************************************************************/
if (!defined('SMF'))
	die('Hacking attempt...');

$txt['elasticemail_title'] = 'Elastic EMail';
$txt['elasticemail_title_section'] = 'Opciones Elastic EMail';
$txt['elasticemail_no_ssl_support'] = '<strong>ERROR:</strong> ¡Esta instalación de PHP no tiene habilitada la compatibilidad con OpenSSL!<br /><br />Puede activar la opción "No usar SSL para la comunicación" para evitar este error. De lo contrario, debe habilitarlo en su servidor o pedir a su host habilitar la compatibilidad con OpenSSL. ¡Gracias!';
$txt['elasticemail_enable'] = 'Elastic EMail habilitado?';
$txt['elasticemail_no_ssl'] = 'No usar SSL para la comunicación';
$txt['elasticemail_key'] = 'Elastic EMail API key:';
$txt['elasticemail_test_api'] = 'Probar API key';
$txt['elasticemail_test_success'] = 'API key válida!';
$txt['elasticemail_test_failure'] = 'API key no válida!';
$txt['elasticemail_test_invalid'] = 'No se puede comunicar con el servidor.';
$txt['elasticemail_test_results'] = 'Configuración del Dominio (como se reporta por ElasticEMail.com)';
$txt['elasticemail_results_domain'] = 'Dominio usado por Elastic EMail:';
$txt['elasticemail_results_spf'] = '¿Registro SPF válido?';
$txt['elasticemail_results_dkim'] = '¿Registro DKIM válido?';
$txt['elasticemail_results_mx'] = '¿Registro MX válido?';
$txt['elasticemail_results_dmarc'] = '¿Registro DMARC válido?';
$txt['elasticemail_results_tracking'] = '¿Registro Tracking CNAME verificado?';
$txt['elasticemail_no_domain_found'] = '<strong>CUIDADO:</strong> No se ha encontrado ningún dominio para "%s".  Sin embargo, esto no significa que este mod no funcione.';

?>