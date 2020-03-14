		<img src="layout/images/line_body.gif" align="center" height="7" width="100%">
		<b><center><font face="martel" color="black" size="18">Latest News</font></center></b>
		<img src="layout/images/line_body.gif" align="center" height="7" width="100%">
<?php
// Load the data from SQL or cache
$cache = new Cache('engine/cache/serverstats');
if ($cache->hasExpired()) {
    $stats = array(
        'newPlayer' => mysql_select_single("SELECT `id`, `name` FROM `players` ORDER BY `id` DESC LIMIT 1"),
        'playerCount' => mysql_select_single("SELECT COUNT(`id`) as `value` FROM `players`"),
        'bestPlayer' => mysql_select_single("SELECT `name`, `level` FROM `players` ORDER BY `level` DESC LIMIT 1"),
        'accountCount' => mysql_select_single("SELECT COUNT(`id`) as `value` FROM `accounts`"),
        'guildCount' => mysql_select_single("SELECT COUNT(`id`) as `value` FROM `guilds`")
    );
    $cache->setContent($stats);
    $cache->save();
} else {
    $stats = $cache->load();
}
 
// Present the data:
?>
 
<table border="0" cellspacing="0">
    <tr class="yellow">
        <td><center>Server Information</center></td>
    </tr>
    <tr>
        <td>
            <center><?php
                echo 'Welcome to our newest player: <a href="characterprofile.php?name='.$stats['newPlayer']['name'].'">'.$stats['newPlayer']['name'].'</a>';
            ?></center>
        </td>
    </tr>
    <tr>
        <td>
            <center><?php
                echo 'The best player is: <a href="characterprofile.php?name='.$stats['bestPlayer']['name'].'">'.$stats['bestPlayer']['name'].'</a> level: '.$stats['bestPlayer']['level'].' congratulations!';
            ?></center>
        </td>
    </tr>
    <tr>
        <td>
            <center><?php
                echo 'We have <b>'.$stats['accountCount']['value'].'</b> accounts in our database, <b>'.$stats['playerCount']['value'].'</b> players, and <b>'.$stats['guildCount']['value'].' </b>guilds';
            ?></center>
        </td>
    </tr>
</table>

<?php
		$cache = new Cache('engine/cache/news');
		if ($cache->hasExpired()) {
			$news = fetchAllNews();
			
			$cache->setContent($news);
			$cache->save();
		} else {
			$news = $cache->load();
		}

		if ($news) {
			
			$total_news = count($news);
			$row_news = $total_news / $config['news_per_page'];
			$page_amount = ceil($total_news / $config['news_per_page']);
			$current = $config['news_per_page'] * $page;

			function TransformToBBCode($string) {
				$tags = array(
					'[center]{$1}[/center]' => '<center>$1</center>',
					'[b]{$1}[/b]' => '<b>$1</b>',
					'[size={$1}]{$2}[/size]' => '<font size="$1">$2</font>',
					'[img]{$1}[/img]'    => '<a href="$1" target="_BLANK"><img src="$1" alt="image" style="width: 100%"></a>',
					'[link]{$1}[/link]'    => '<a href="$1">$1</a>',
					'[link={$1}]{$2}[/link]'   => '<a href="$1" target="_BLANK">$2</a>',
					'[color={$1}]{$2}[/color]' => '<font color="$1">$2</font>',
					'[*]{$1}[/*]' => '<li>$1</li>',
				);
				foreach ($tags as $tag => $value) {
					$code = preg_replace('/placeholder([0-9]+)/', '(.*?)', preg_quote(preg_replace('/\{\$([0-9]+)\}/', 'placeholder$1', $tag), '/'));
					$string = preg_replace('/'.$code.'/i', $value, $string);
				}
				return $string;
			}
			
			echo '<table><div id="news">';
			for ($i = $current; $i < $current + $config['news_per_page']; $i++) {
				if (isset($news[$i])) {
					?>
					<tr><td class="zheadline" colspan="2">&nbsp;&nbsp;<span class="znewsdate"><?php echo date('D, j M Y', $news[$i]['date']); ?> - </span><b><?php echo TransformToBBCode($news[$i]['title']); ?></td></tr>
					<tr><td class="znewsbody" colspan="2"><?php echo TransformToBBCode(nl2br($news[$i]['text'])); ?></td></tr>
					<tr><td class="znewsdate"><span style="color:#5a2800">&nbsp;&nbsp;by </span><a href="characterprofile.php?name=<?php echo $news[$i]['name']; ?>"><?php echo $news[$i]['name']; ?></a></td><td class="znewsdate"></td></tr>
					<tr><td class="znewsdate" colspan="2"></td></tr>
					<?php
				} 
			}
			echo '</div></table>';
			
			echo '<select name="newspage" onchange="location = this.options[this.selectedIndex].value;">';
			for ($i = 0; $i < $page_amount; $i++) {

				if ($i == $page) {

					echo '<option value="index.php?page='.$i.'" selected>Page '.$i.'</option>';

				} else {

					echo '<option value="index.php?page='.$i.'">Page '.$i.'</option>';
				}
			}
			echo '</select>';
			
		} else {
			echo '<p>No news exist.</p>';
		}
?>
