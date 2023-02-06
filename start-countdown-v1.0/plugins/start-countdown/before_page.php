<?php
/**
 * Start Countdown for MyAAC.
 *
 * @name      start-countdown
 * Written by Keith Wood (kbwood{at}iinet.com.au) January 2008.
 * Made for MyAAC by Slawkens <slawkens@gmail.com>
 * @version   1.0
 */

if(!isset($config['start-countdown']))
{
	$config['start-countdown'] = array(
		'date' => '12 31, 2020 17:00:00' // just an example
	);
}

global $template_place_holders;
if(!isset($template_place_holders['head_end']))
	$template_place_holders['head_end'] = array();
if(!isset($template_place_holders['center_top']))
	$template_place_holders['center_top'] = array();

$template_place_holders['head_end'][] = '
<style type="text/css">
#defaultCountdown { width: 240px; height: 45px; }
</style>
<link rel="stylesheet" href="' . BASE_URL . 'tools/jquery.countdown.css">
<script type="text/javascript" src="' . BASE_URL . 'tools/jquery.plugin.min.js"></script>
<script type="text/javascript" src="' . BASE_URL . 'tools/jquery.countdown.min.js"></script>

<noscript>
	Server starting at ' . $config['start-countdown']['date'] . '
</noscript>
';

$template_place_holders['center_top'][] = '<br/><center>Server starts in: <div id="defaultCountdown"></div></center>' . '
<script type="text/javascript">
function startAlert()
{
	alert("Server just started!");
}

$(function () {
	var serverStart = new Date("' . $config['start-countdown']['date'] . '");
	$(\'#defaultCountdown\').countdown({until: serverStart, onExpiry: startAlert});
});
</script>';
?>
