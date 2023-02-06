<?php
defined('MYAAC') or die('Direct access not allowed!');
$title = 'Census';

if(!isset($config['census_countries']))
	$config['census_countries'] = 5; 

require(SYSTEM . 'countries.conf.php');
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

function drawChart() {
	var data_vocations = google.visualization.arrayToDataTable([
		['Vocation', 'Amount'],
<?php
		$vocations = array();
		$vocations_db = $db->query('SELECT vocation, count( `vocation` ) AS amount FROM `players` WHERE `vocation` <= ' . $config['vocations_amount'] . ' GROUP BY vocation');
		foreach($vocations_db as $v) {
			$vocations[$v['vocation']] = $v['amount'];
		}
		
		$vocations_db = $db->query('SELECT vocation, count( `vocation` ) AS amount FROM `players` WHERE `vocation` > ' . $config['vocations_amount'] . ' GROUP BY vocation');
		foreach($vocations_db as $v) {
			$vocations[$v['vocation'] - $config['vocations_amount']] += $v['amount'];
		}
		
		$row_count = count($vocations);
		$i = 0;
		foreach($vocations as $vocation => $amount) {
			echo "['" . $config['vocations'][$vocation] . "', " . $amount . "]" . (++$i < $row_count ? ',' : '');
		}
?>
	]);

	var chart_vocations = new google.visualization.PieChart(document.getElementById('vocations'));
	chart_vocations.draw(data_vocations, {
		title: 'Vocations',
		backgroundColor: { fill:'transparent' }
	});

	var data_sexs = google.visualization.arrayToDataTable([
		['Vocation', 'Amount'],
<?php
		$sexs = $db->query('SELECT sex, count( `sex` ) AS amount FROM `players` GROUP BY sex');
		$row_count = $sexs->rowCount();
		$i = 0;
		$genders = array(0 => 'Female', 1 => 'Male');
		foreach($sexs as $v) {
			echo "['" . $genders[$v['sex']] . "', " . $v['amount'] . "]" . (++$i < $row_count ? ',' : '');
		}
?>
	]);

<?php if($config['account_country']): ?>
	var chart_sexs = new google.visualization.PieChart(document.getElementById('sexs'));
	chart_sexs.draw(data_sexs, {
		title: 'Gender',
		backgroundColor: { fill:'transparent' }
	});

	var data_countries = google.visualization.arrayToDataTable([
		['Country', 'Amount'],
<?php
		$countries = $db->query('SELECT country, count( `country` ) AS amount FROM `accounts` GROUP BY country ORDER BY amount DESC LIMIT ' . $config['census_countries']);
		$row_count = $countries->rowCount();
		$i = 0;
		foreach($countries as $v) {
			echo "['" . $config['countries'][$v['country']] . "', " . $v['amount'] . "]" . ',';
		}
		
		$countries_other = $db->query("SELECT SUM(amount) as other FROM (
		SELECT country, count( `country` ) AS amount FROM `accounts` WHERE country NOT IN 
		(select * from (SELECT country FROM `accounts` GROUP BY country ORDER BY count( `country` ) DESC LIMIT " . $config['census_countries'] . ") temp_tab) AND country<>''
		GROUP BY country) AS t");
		$v = $countries_other->fetch();
		echo "['Other', " . $v['other'] . "]";
?>
	]);

	var chart_countries = new google.visualization.PieChart(document.getElementById('countries'));
	chart_countries.draw(data_countries, {
		title: 'Countries',
		backgroundColor: { fill:'transparent' }
	});
<?php endif; ?>
}
</script>
<div id="vocations" style="width: 100%; height: 200px;"></div>
<div id="sexs" style="width: 100%; height: 200px;"></div>
<?php if($config['account_country']): ?>
<div id="countries" style="width: 100%; height: 200px;"></div>
<?php endif; ?>