<?php

require('../common.php');
require_once(SYSTEM . 'functions.php');
require_once(SYSTEM . 'init.php');
require_once(SYSTEM . 'status.php');

setSession('user_landed', true);

$base_url = str_replace('landing/', '', BASE_URL);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<title><?php echo $config['lua']['serverName']; ?></title>
	<meta name="description" content="<?php echo $config['meta_description']; ?>">
	<meta name="keywords" content="<?php echo $config['meta_keywords']; ?>, myaac, wodzaac">
	<meta name="author" content="Jesse">
	<meta name="generator" content="CSS">
	<link rel="stylesheet" href="basic.css" type="text/css">
</head>
<body>
	<div id="container">
		<div id="wb_Text1" style="margin:0;padding:0;position:absolute;left:50%;top:25%;width:218px;height:30px;text-align:left;z-index:15;">
		<font style="font-size:19px" color="FFCC00" = face="BRUSH SCRIPT MT"><b>Name:<?php echo $config['lua']['serverName']; ?></b></font></div>
		<div id="wb_Text2" style="margin:0;padding:0;position:absolute;left:50%;top:30%;width:253px;height:30px;text-align:left;z-index:16;">
		<font style="font-size:19px" color="#FFCC00" face="BRUSH SCRIPT MT"><b>Version: <?php echo $config['client'] / 100; ?></b></font></div>
		<div id="wb_Text3" style="margin:0;padding:0;position:absolute;left:50%;top:35%;width:245px;height:30px;text-align:left;z-index:17;">
		<font style="font-size:19px" color="#FFCC00" face="BRUSH SCRIPT MT"><b>Ip: <?php echo str_replace('/', '', str_replace(array('http://', 'https://'), '', $config['lua']['url'])); ?></b></font></div>
		<div id="wb_Text4" style="margin:0;padding:0;position:absolute;left:50%;top:40%;width:177px;height:30px;text-align:left;z-index:18;">
		<font style="font-size:19px" color="#FFCC00" face="BRUSH SCRIPT MT"><b>Port: <?php echo $config['lua']['loginPort']; ?></b></font></div>
		<div id="wb_Text5" style="margin:0;padding:0;position:absolute;left:50%;top:45%;width:239px;height:30px;text-align:left;z-index:19;">
		<font style="font-size:19px" color="#FFCC00" face="BRUSH SCRIPT MT"><b>Server Status: </b></font><?php echo ($status['online'] ? '<font style="font-size:19px; color:#00FF00" face="Arial"><b>Online</b></font>' : '<font style="font-size:19px; color: red;"><b>Offline</b></font>'); ?></div>
		<div id="wb_Text5" style="margin:0;padding:0;position:absolute;left:50%;top:53%;width:180px;height:30px;text-align:left;z-index:19;">
		<font style="font-size:10px" color="#FF9900" face="Arial"><b>By clicking "Play Now" I agree to the Server Agreements</a>, the <a href="<?php echo $base_url; ?>?subtopic=rules" target="_blank" >Tibia Rules</a> and the Tibia Privacy Policy</a>.</b></font>
		</div>
		<div id="playnow"
		style="margin:0;padding:0;position:absolute;left:47.5%;top:63%;width:158px;height:44px;text-align:left;z-index:20;">
		<a href="<?php echo $base_url . ($config['friendly_urls'] ? '' : '?') . 'news'; ?>"><img src="images/playnow.png"></a></div>
	</div>
</body>
</html>