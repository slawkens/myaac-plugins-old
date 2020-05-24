						<ul>
							<li><a href="<?php echo getLink('news'); ?>">Latest News</a></li>
							<li><a href="<?php echo getLink('news/archive'); ?>">News Archive</a></li>
							<li><a href="<?php echo getLink('changelog'); ?>">Changelog</a></li>
							<?php if (!$logged) { ?>
								<li><a href="<?php echo getLink('account/manage'); ?>">Login</a></li>
								<li><a href="<?php echo getLink('account/create'); ?>">Register</a></li>
							<?php } else { ?>
							<li><a href="<?php echo getLink('account/manage'); ?>">My Account</a></li>
							<?php } ?>
							<li><a href="<?php echo getLink('account/lost'); ?>">Lost Account</a></li>
							<li><a href="<?php echo getLink('rules'); ?>">Server Rules</a></li>
							<li><a href="<?php echo getLink('downloads'); ?>">Downloads</a></li>
							<li><a href="<?php echo getLink('bugtracker'); ?>">Report Bug</a></li>
							<li><a href="<?php echo getLink('characters'); ?>">Characters</a></li>
							<li><a href="<?php echo getLink('highscores'); ?>">Highscores</a></li>
							<li><a href="<?php echo getLink('lastkills'); ?>">Latest Deaths</a></li>
							<li><a href="<?php echo getLink('houses'); ?>">Houses</a></li>
							<li><a href="<?php echo getLink('bans'); ?>">Bans</a></li>
							<li><a href="<?php echo getLink('forum'); ?>">Forum</a></li>
							<li><a href="<?php echo getLink('creatures'); ?>">Monsters</a></li>
							<li><a href="<?php echo getLink('spells'); ?>">Spells</a></li>
							<li><a href="<?php echo getLink('commands'); ?>">Commands</a></li>
							<li><a href="<?php echo getLink('gallery'); ?>">Gallery</a></li>
							<li><a href="<?php echo getLink('experienceTable'); ?>">Experience Table</a></li>
							<li><a href="<?php echo getLink('faq'); ?>">FAQ</a></li>
							<?php if($config['gifts_system']) { ?>
							<li><a href="<?php echo getLink('points'); ?>">Buy Points</a></li>
							<li><a href="<?php echo getLink('gifts'); ?>">Shop Offers</a></li>
							<?php } ?>
						</ul>