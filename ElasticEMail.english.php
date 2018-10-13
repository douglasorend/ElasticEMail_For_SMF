<?php
/********************************************************************************
* Subs-ElasticEMail.php - Subs of the Important Topics mod
*********************************************************************************
* This program is distributed in the hope that it is and will be useful, but
* WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY
* or FITNESS FOR A PARTICULAR PURPOSE,
**********************************************************************************/
if (!defined('SMF'))
	die('Hacking attempt...');

$txt['elasticemail_title'] = 'Elastic EMail';
$txt['elasticemail_title_section'] = 'Elastic EMail settings';
$txt['elasticeamil_no_ssl_support'] = '<strong>ERROR:</strong> This PHP installation does not have OpenSSL support enabled, which is required by the Elastic EMail mod!<br /><br />You can enable the "Do not use SSL for communication" option to get around this error.  Otherwise, you need enable it on your server or get your host to enable support for OpenSSL!  Thank you!';
$txt['elasticemail_enable'] = 'Elastic EMail enabled?';
$txt['elasticemail_no_ssl'] = 'Do not use SSL for communication?';
$txt['elasticemail_key'] = 'Elastic EMail API key:';
$txt['elasticemail_test_api'] = 'Test API key';
$txt['elasticemail_test_success'] = 'API key is valid!';
$txt['elasticemail_test_failure'] = 'API key is not valid!';
$txt['elasticemail_test_invalid'] = 'Unable to communicate with the server.';
$txt['elasticemail_test_results'] = 'Domain Configuration Results';
$txt['elasticemail_results_domain'] = 'Domain used for Elastic EMail:';
$txt['elasticemail_results_spf'] = 'Valid SPF record?';
$txt['elasticemail_results_dkim'] = 'Valid DKIM record?';
$txt['elasticemail_results_mx'] = 'Valid MX record?';
$txt['elasticemail_results_dmarc'] = 'Valid DMARC record?';
$txt['elasticemail_results_tracking'] = 'Tracking CNAME record is verified?';
$txt['elasticemail_results_verify'] = 'Verification is available?';

?>