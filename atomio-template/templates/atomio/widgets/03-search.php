<?php
defined('MYAAC') or die('Direct access not allowed!');
?>
<div class="well widget">
	<div class="header">
		<a href="<?= getLink('characters') ?>">Search</a>
	</div>
	<div class="body">
		<form class="searchForm" action="<?= getLink('characters') ?>" method="post">
			<div class="well">
				<input type="text" name="name" placeholder="e.g: John Sheppard">
				<input type="submit" value="Search">
			</div>
		</form>
	</div>
</div>
