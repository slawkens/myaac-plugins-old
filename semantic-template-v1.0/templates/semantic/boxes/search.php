<div class="column box">
	<div class="ui top attached message">
		<h4 class="ui header">
			<i class="user icon"></i>
			<div class="content">
				<a href="<?= getLink('characters') ?>">Characters</a>
			</div>
		</h4>
	</div>
	<div class="ui bottom attached segment">
		<form class="ui form" method="post" action="<?= getLink('characters') ?>">
			<div class="two fields">
				<input class="ui input" type="text" name="name" placeholder="Name.."/>&nbsp;
				<input class="ui button" type="submit" value="Search"/>
			</div>
		</form>
	</div>
</div>
