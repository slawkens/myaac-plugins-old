<div class="sidebar">
	<h2>Login / Register</h2>
	<div class="inner">
		<form action="<?php echo getLink('account/manage'); ?>" method="post">
		<ul id="login">
			<li>
				Account: <br>
				<input type="text" name="account_login">
			</li>
			<li>
				Password: <br>
				<input type="password" name="password_login">
			</li>
			<li>
				<input type="submit" value="Log in">
			</li>
		<center>	<h3><a href="<?php echo getLink('account/create'); ?>">New account</a></h3>
		<font size="1">- <a href="<?php echo getLink('account/lost'); ?>">Account Recovery</a></font></center>
		</ul>
		</form>
	</div>
</div>