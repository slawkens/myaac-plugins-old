<?php
defined('MYAAC') or die('Direct access not allowed!');

require PLUGINS . 'guild-wars/init.php';

$title = 'Guilds';

$guild_id = (int) $_REQUEST['guild'];

if(!$logged) {
	$errors[] = 'You are not logged.';
}

if(!empty($errors))
{
	$twig->display('error_box.html.twig', ['errors' => $errors]);
	$twig->display('guilds.back_button.html.twig');
	return;
}

$guild = new OTS_Guild($guild_id);
if(!$guild->isLoaded()) {
	$errors[] = "Guild with ID <b>$guild_id</b> doesn't exist.";
}

if(empty($errors))
{
	$guild_leader_char = $guild->getOwner();
	$guild_leader = FALSE;
	$account_players = $account_logged->getPlayers();

	foreach($account_players as $player) {
		if($guild_leader_char->getId() == $player->getId()) {
			$guild_leader = TRUE;
		}
	}

	if($guild_leader) {
		$currentWars = array();
		$wars = new OTS_GuildWars_List();
		foreach($wars as $war) {
			if($war->getStatus() == OTS_GuildWar::STATE_INVITED || $war->getStatus() == OTS_GuildWar::STATE_ON_WAR) {
				if($war->getGuild1ID() == $guild->getID()) {
					$currentWars[$war->getGuild2ID()] = $war->getStatus();
				}
				elseif($war->getGuild2ID() == $guild->getID()) {
					$currentWars[$war->getGuild1ID()] = $war->getStatus();
				}
			}
		}

		$guildsList = new OTS_Guild_List();
		$guildsList->orderBy(new OTS_SQLField('name'));

		$enemyGuilds = [];

		foreach($guildsList as $enemyGuild) {
			$guild_logo = $enemyGuild->getCustomField('logo_name');
			if(empty($guild_logo) || !file_exists(GUILD_IMAGES_DIR . $guild_logo)) {
				$guild_logo = 'default.gif';
			}

			if($enemyGuild->getID() != $guild->getID()) {
				if(isset($currentWars[$enemyGuild->getID()])) {
					// in war or invited
					if($currentWars[$enemyGuild->getID()] == OTS_GuildWar::STATE_INVITED) {
						// guild already invited you or you invited that guild
						$_status = 'There is already invitation between your and this guild.';
					}
					else {
						// you are on war with this guild
						$_status = 'There is already war between your and this guild.';
					}
				}
				else {
					// can invite
					$_status = $twig->render('guild-wars/templates/guild_wars.invite.html.twig', [
						'guild' => $guild,
						'enemyGuild' => $enemyGuild,
					]);
				}
			}
			else {
				// your own guild
				$_status = 'YOUR GUILD';
			}

			$enemyGuilds[] = [
				'guild' => $enemyGuild,
				'status' => $_status,
				'guild_logo_path' => GUILD_IMAGES_DIR . $guild_logo,
			];
		}

		$twig->display('guild-wars/templates/guild_wars.choose_enemy.html.twig', [
			'guild' => $guild,
			'enemyGuilds' => $enemyGuilds,
		]);

		$twig->display('guilds.back_button.html.twig', array(
			'new_line' => true,
			'action' => getGuildLink($guild->getName(), false),
		));
	}
	else
		$errors[] = 'You are not a leader of guild!';
}

if(!empty($errors))
{
	$twig->display('error_box.html.twig', ['errors' => $errors]);
	$twig->display('guilds.back_button.html.twig');
}
