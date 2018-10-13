<?php
/********************************************************************************
* Subs-ElasticEMail.php - Subs of the Elastic EMail for SMF mod
*********************************************************************************
* This program is distributed in the hope that it is and will be useful, but
* WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY
* or FITNESS FOR A PARTICULAR PURPOSE,
**********************************************************************************/
if (!defined('SMF'))
	die('Hacking attempt...');

/********************************************************************************
* The primary workhorse of this mod: The mail sender!
********************************************************************************/
function ElasticEMail_send($recipients, $subject, $message, $from_name, $reply_to = null, $send_html = false)
{
	global $modSettings, $webmaster_email, $context, $sourcedir;

	// Are we setup to send mail through ElasticEMail.com?
	if (empty($modSettings['elasticemail_enable']) || empty($modSettings['elasticemail_key']))
		return false;
		
	// Get everything we need in order to send emails:
	if (!is_array($recipients))
		$recipients = array($recipients);
	$post_data = array(
		'api_key' => $modSettings['elasticemail_key'],
		'encodingtype' => 1,
		'isTransactional' => 1,
		'from_name' => $from_name,
		'from' => empty($modSettings['mail_from']) ? $webmaster_email : $modSettings['mail_from'],
		'to' => implode(';', $recipients),
		'subject' => $subject,
		($send_html ? 'body_html' : 'body_text') => $message,
	);
	if ($reply_to !== null)
		$post_data['reply_to'] = $reply_to;

	// Send our email now!
	require_once($sourcedir . '/Subs-Package.php');
	$posted_data = '';
	foreach ($post_data as $key => $val)
		$posted_data .= (empty($posted_data) ? '' : '&') . $key . '=' . urlencode($val);
	$protocol = !empty($modSettings['elasticemail_no_ssl']) ? 'http' : 'https';
	$temp = fetch_web_data($protocol . '://api.elasticemail.com/v2/email/send', $posted_data);
	$output = json_decode($context['elasticemail_response'] = $temp, true);
	return isset($output['success']) ? $output['success'] : false;
}

/********************************************************************************
* Admin functions for this mod:
********************************************************************************/
function ElasticEMail_Admin(&$areas)
{
	global $txt;
	loadLanguage('ElasticEMail');
	$areas['maintenance']['areas']['mailqueue']['subsections']['elastic'] = array($txt['elasticemail_title'], 'admin_forum');
}

function ElasticEMail_Manage_Mail(&$subActions)
{
	$subActions['elastic'] = 'ElasticEMail_Settings';
}	

/********************************************************************************
* Admin settings function for mod:
********************************************************************************/
function ElasticEMail_Settings($return_config = false)
{
	global $txt, $scripturl, $context, $settings, $modSettings, $sourcedir, $boardurl;

	// Make sure we can have permission to adminstrate the forum!
	isAllowedTo('admin_forum');
	loadLanguage('ElasticEMail');

	// Our mod configuration variables:
	$config_vars = array(
		array('check', 'elasticemail_enable'),
		array('check', 'elasticemail_no_ssl'),
		array('text', 'elasticemail_key', 37, 'postinput' => '<br /><input type="submit" value="' . $txt['elasticemail_test_api'] . '" onclick="ElasticEMail_Test_API(); return false;" class="button_submit" />'),
		
	);
	if (!empty($context['elasticemail_domain']))
	{
		$config_vars[] = array('title', 'elasticemail_test_results');
		$config_vars[] = array('callback', 'elasticemail_table');
	}
	if ($return_config)
		return $config_vars;

	// Check to see if we have PHP support for OpenSSL.  If we do, pull the domain list:
	require_once($sourcedir . '/Subs-Package.php');
	$protocol = !empty($modSettings['elasticemail_no_ssl']) ? 'http' : 'https';
	if (!empty($modSettings['elasticemail_key']))
	{
		while (empty($temp))
		{
			$temp = fetch_web_data($protocol . '://api.elasticemail.com/v2/domain/list?api_key=' . $modSettings['elasticemail_key']);
			$context['elasticemail_domain'] = array();
			if (!empty($temp) || $protocol == 'http')
				break;
			$protocol = 'http';
			$_POST['elasticemail_no_ssl'] = $modSettings['elasticemail_no_ssl'] = true;
			saveDBSettings($config_vars);
		}
	}

	// If OpenSSL support doesn't exist, notify user:
	if (!empty($modSettings['elasticemail_key']))
	{
		if (empty($temp))
			$context['settings_insert_above'] = '<div class="errorbox">' . $txt['elasticemail_no_ssl_support'] . '</div>';
		else
		// Otherwise, get information about this domain from ElasticEMail:
		{
			$domains = json_decode($temp, true);
			if (!empty($domains['success']))
			{
				$this_domain = parse_url($boardurl, PHP_URL_HOST);
				foreach ($domains['data'] as $domain)
				{
					if (!empty($domain['domain']) && strpos($this_domain, $domain['domain']) !== false)
						$context['elasticemail_domain'] = $domain;
				}
			}
			if (empty($context['elasticemail_domain']))
				$context['settings_insert_above'] = '<div class="errorbox">' . sprintf($txt['elasticemail_no_domain_found'], $this_domain) . '</div>';
		}
	}

	// Saving the settings?
	if (isset($_GET['save']))
	{
		checkSession();
		saveDBSettings($config_vars);
		redirectexit('action=admin;area=mailqueue;sa=elastic');
	}
	
	// Our javascript for testing whether the API key given is valid:
	$context['settings_post_javascript'] = '
		function ElasticEMail_Test_API()
		{
			var api_key = document.getElementById("elasticemail_key").value;
			if (!api_key)
			{
				alert(' . JavaScriptEscape($txt['elasticemail_test_failure']) . ');
				return;
			}
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() 
			{
				if (xmlhttp.readyState == XMLHttpRequest.DONE ) 
				{
					if (xmlhttp.status == 200) 
					{
						var obj = JSON.parse(xmlhttp.responseText);
						if (obj.error != "Incorrect apikey")
							alert(' . JavaScriptEscape($txt['elasticemail_test_success']) . ');
						else
							alert(' . JavaScriptEscape($txt['elasticemail_test_failure']) . ');
					}
					else
						alert(' . JavaScriptEscape($txt['elasticemail_test_invalid']) . ');
				}
			};
			xmlhttp.open("GET", "https://api.elasticemail.com/v2/email/send?apikey=" + api_key + "&subject=&from=&fromName=&sender=&senderName=&msgFrom=&msgFromName=&replyTo=&replyToName=&to=&msgTo=&msgCC=&msgBcc=&lists=&segments=&mergeSourceFilename=&channel=&bodyHtml=&bodyText=&charset=&charsetBodyHtml=&charsetBodyText=&encodingType=1&template=&headers_customheadername=&postBack=&merge=&timeOffSetMinutes=&poolName=My%20Custom%20Pool&isTransactional=false", true);
			xmlhttp.send();
		}';

	// Everything else that needs to be set up:
	$context['post_url'] = $scripturl . '?action=admin;area=mailqueue;sa=elastic;save';
	$context['settings_title'] = $txt['elasticemail_title_section'];
	prepareDBSettingContext($config_vars);
}

function template_callback_elasticemail_table()
{
	global $context, $txt, $forum_version, $settings;

	// Check to see if everything is right to omit restriction message:
	$r = array('domain' => '', 'spf' => 0, 'dkim' => 0, 'mx' => 0, 'dmarc' => 0, 'isrewritedomainvalid' => 0, 'verify' => 0);
	if (!empty($context['elasticemail_domain']))
		$r = &$context['elasticemail_domain'];
	if (isset($_REQUEST['debug'])) { echo '<pre>';  print_r($r); echo '</pre>'; }

	// The user needs to know what has been verified:
	$ext = substr($forum_version, 0, 7) == 'SMF 2.1' ? '.png' : '.gif';
	echo '
						<dt>', $txt['elasticemail_results_domain'], '</dt>
						<dd>', $r['domain'], '</dd>
						<dt>', $txt['elasticemail_results_spf'], '</dt>
						<dd><img src="', $settings['images_url'], '/icons/', !empty($r['spf']) ? 'field_valid' : 'quick_remove', $ext, '"></dd>
						<dt>', $txt['elasticemail_results_dkim'], '</dt>
						<dd><img src="', $settings['images_url'], '/icons/', !empty($r['dkim']) ? 'field_valid' : 'quick_remove', $ext, '"></dd>
						<dt>', $txt['elasticemail_results_mx'], '</dt>
						<dd><img src="', $settings['images_url'], '/icons/', !empty($r['mx']) ? 'field_valid' : 'quick_remove', $ext, '"></dd>
						<dt>', $txt['elasticemail_results_dmarc'], '</dt>
						<dd><img src="', $settings['images_url'], '/icons/', !empty($r['dmarc']) ? 'field_valid' : 'quick_remove', $ext, '"></dd>
						<dt>', $txt['elasticemail_results_tracking'], '</dt>
						<dd><img src="', $settings['images_url'], '/icons/', !empty($r['isrewritedomainvalid']) ? 'field_valid' : 'quick_remove', $ext, '"></dd>
						<dt>', $txt['elasticemail_results_verify'], '</dt>
						<dd><img src="', $settings['images_url'], '/icons/', !empty($r['verify']) ? 'field_valid' : 'quick_remove', $ext, '"></dd>';
}

?>