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
	global $txt, $scripturl, $context, $settings, $modSettings, $sourcedir, $boardurl, $forum_version;

	// Make sure we can have permission to adminstrate the forum!
	isAllowedTo('admin_forum');
	loadLanguage('ElasticEMail');

	// Our mod configuration variables:
	$config_vars = array(
		array('check', 'elasticemail_enable'),
		array('check', 'elasticemail_no_ssl'),
		array('text', 'elasticemail_key', 37, 'postinput' => '<br /><input type="submit" value="' . $txt['elasticemail_test_api'] . '" onclick="ElasticEMail_Test_API(); return false;" class="button_submit" />'),
		
	);
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

		// If OpenSSL support doesn't exist, notify user:
		if (empty($temp))
			$context['settings_insert_above'] = '<div class="errorbox">' . $txt['elasticemail_no_ssl_support'] . '</div>';
		else
		// Otherwise, get information about this domain from ElasticEMail:
		{
			$domains = json_decode($temp, true);
			if (!empty($domains['success']))
			{
				$this_domain = ElasticEMail_domain($boardurl);
				foreach ($domains['data'] as $domain)
				{
					if (!empty($domain['domain']) && strpos($domain['domain'], $this_domain) !== false)
						$context['elasticemail_domain'] = $domain;
				}
			}
			if (empty($context['elasticemail_domain']))
				$context['settings_insert_above'] = '<div class="errorbox">' . sprintf($txt['elasticemail_no_domain_found'], $this_domain) . '</div>';
		}
	}
	if (!empty($context['elasticemail_domain']))
	{
		$config_vars[] = array('title', 'elasticemail_test_results');
		$config_vars[] = array('callback', 'domain_configuration');
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

/********************************************************************************
* Subfunction that determines domain name of passed URL:
* Solution copied & modified for SMF from: https://stackoverflow.com/a/7573307
********************************************************************************/
function ElasticEMail_domain($url)
{
	// Get sub-TLDs if not already fetched:
	if (($subtlds = cache_get_data('ElasticEMail_subtlds', 360)) == null)
	{
		$subtlds = array(
			'co.uk', 'me.uk', 'net.uk', 'org.uk', 'sch.uk', 'ac.uk', 
			'gov.uk', 'nhs.uk', 'police.uk', 'mod.uk', 'asn.au', 'com.au',
			'net.au', 'id.au', 'org.au', 'edu.au', 'gov.au', 'csiro.au'
		);
		foreach (file('http://mxr.mozilla.org/mozilla-central/source/netwerk/dns/effective_tld_names.dat?raw=1') as $num => $line)
		{
			$line = trim($line);
			if($line == '' || substr($line[0], 0, 2) == '/')
				continue;
			$line = @preg_replace("/[^a-zA-Z0-9\.]/", '', $line);
			if($line == '' || (isset($line[0]) && $line[0] == '.') || !strstr($line, '.')) 
				continue;
			$subtlds[] = $line;
		}
		$subtlds = array_unique($subtlds);
		cache_put_data('ElasticEMail_subtlds', $subtlds, 360);
	}
	
	// Let's try to figure out the domain name:
    $slds = "";
    $url = str_replace('http://', '', str_replace('https://', '', strtolower($url)));
	$host = parse_url('http://' . $url, PHP_URL_HOST);
    preg_match('/[^\.\/]+\.[^\.\/]+$/', $host, $matches);
    foreach($subtlds as $sub)
    {
        if (preg_match('/\.' . preg_quote($sub) . '$/', $host, $xyz))
            preg_match('/[^\.\/]+\.[^\.\/]+\.[^\.\/]+$/', $host, $matches);
    }

	// Either return the matched domain, or the host as determined by "parse_url":
    return isset($matches[0]) ? $matches[0] : $host;
}

/********************************************************************************
* Template callback function dealing with display the domain configuration:
********************************************************************************/
function template_callback_domain_configuration()
{
	global $context, $txt, $forum_version, $settings;

	// Check to see if everything is right to omit restriction message:
	if (!empty($context['elasticemail_domain']))
		$r = &$context['elasticemail_domain'];
	if (isset($_REQUEST['debug'])) { echo '<pre>';  print_r($r); echo '</pre>'; }

	// Decide what HTML to use for valid and invalid fields:
	$smf20 = substr($forum_version, 0, 7) == 'SMF 2.0';
	$valid = $smf20 ? '<img src="' . $settings['images_url'] . '/icons/field_valid.gif" />' : '<span class="generic_icons valid"></span>';
	$invalid = $smf20 ? '<img src="' . $settings['images_url'] . '/icons/quick_remove.gif" />' : '<span class="generic_icons delete"></span>';

	// The user needs to know what has been verified:
	echo '
						<dt>', $txt['elasticemail_results_domain'], '</dt>
						<dd>', !empty($r['domain']) ? $r['domain'] : '', '</dd>
						<dt>', $txt['elasticemail_results_spf'], '</dt>
						<dd>', !empty($r['spf']) ? $valid : $invalid, '</dd>
						<dt>', $txt['elasticemail_results_dkim'], '</dt>
						<dd>', !empty($r['dkim']) ? $valid : $invalid, '</dd>
						<dt>', $txt['elasticemail_results_mx'], '</dt>
						<dd>', !empty($r['mx']) ? $valid : $invalid, '</dd>
						<dt>', $txt['elasticemail_results_dmarc'], '</dt>
						<dd>', !empty($r['dmarc']) ? $valid : $invalid, '</dd>
						<dt>', $txt['elasticemail_results_tracking'], '</dt>
						<dd>', !empty($r['isrewritedomainvalid']) ? $valid : $invalid, '</dd>';
}

?>
