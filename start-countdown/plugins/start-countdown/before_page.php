<?php
/**
 * Start Countdown for MyAAC.
 *
 * @name      start-countdown
 * Written by Keith Wood (kbwood{at}iinet.com.au) January 2008.
 * Made for MyAAC by Slawkens <slawkens@gmail.com>
 * @version   1.2
 */

if(!isset($config['start-countdown']))
{
	$config['start-countdown'] = array(
		'date' => '30.03.2021 18:00:00' // just an example
	);
}

global $template_place_holders;
if(!isset($template_place_holders['head_end']))
	$template_place_holders['head_end'] = array();
if(!isset($template_place_holders['center_top']))
	$template_place_holders['center_top'] = array();

$template_place_holders['head_end'][] = '
<style type="text/css">
#defaultCountdownParent { width: 240px; margin: auto; text-align: center; }
#defaultCountdown { width: 240px; height: 45px; }
.highlight { color: #f00; }
</style>
<link rel="stylesheet" href="' . BASE_URL . 'tools/plugins/start-countdown/jquery.countdown.css">
<script type="text/javascript" src="' . BASE_URL . 'tools/plugins/start-countdown/jquery.plugin.min.js"></script>
<script type="text/javascript" src="' . BASE_URL . 'tools/plugins/start-countdown/jquery.countdown.min.js"></script>

<noscript>
	Server starting at ' . $config['start-countdown']['date'] . '
</noscript>
';

$tmp = explode(' ', $config['start-countdown']['date']);
$date = explode('.', trim($tmp[0]));
$time = explode(':', trim($tmp[1]));

ob_start();
?>

<div id="defaultCountdownParent">Server starts in: <div id="defaultCountdown"></div></div><br/>
<script type="text/javascript">
function startAlert()
{
	alert('Server just started!');
}

function highlightLast(periods)
{
	if ($.countdown.periodsToSeconds(periods) === 10) {
		$(this).addClass('highlight');
	}
}
$(function () {
	let countUntil = <?= mktime($time[0], $time[1], $time[2], $date[1], $date[0], $date[2]) - time(); ?>;
	const $defaultCountdown = $('#defaultCountdown');

	$defaultCountdown.countdown(
		{
			until: countUntil,
			expiryText: 'Server just started!',
			onExpiry: startAlert,
			onTick: highlightLast
		}
	);

	if(countUntil <= 0) {
		$defaultCountdown.html('Server already started!');
	}
});
</script>

<?php
$template_place_holders['center_top'][] = ob_get_contents();
ob_end_clean();
