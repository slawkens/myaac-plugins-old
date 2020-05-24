			<?php
			if($status['online']) {
				echo "<span style='color:green;font-weight:bold;'><center>Server Online!</center></span><br />";
			}
			else {
				echo "<span style='color:red;font-weight:bold;'>Offline!</span><br/>";
			}
			?>
			<div class="line"></div>
			<a href="<?php echo getLink('online'); ?>">Players online</a>
			<div class="line"></div>
			<a href="<?php echo getLink('online'); ?>">
				<?php if ($status['online']) {
					echo $status['players'].' players';
				} else {
					echo '0 players';
				}
				?>
			</a>
			<div class="line"></div>
			<?php
			if($config['template_allow_change'])
				echo '<font color="white">Template:</font><br/>' . template_form();
				?>
		</ul>