<?php
defined('MYAAC') or die('Direct access not allowed!');

require PLUGINS . 'guild-wars/init.php';

$guild_id = (int) $_REQUEST['guild'];
$enemy_id = (int) $_REQUEST['enemy'];

if(!$logged) {
	$errors[] = 'You are not logged.';
}

if(!empty($errors)) {
	$twig->display('error_box.html.twig', ['errors' => $errors]);
	$twig->display('guilds.back_button.html.twig');
	return;
}

$guild = new OTS_Guild($guild_id);
$enemyGuild = new OTS_Guild($enemy_id);
if(!$guild->isLoaded() || !$enemyGuild->isLoaded()) {
	$errors[] = 'Guild with ID <b>' . $guild_id . '</b> or ID<b>' . $enemy_id . '</b> doesn\'t exist.';
}

if(empty($errors)) {
	$fragLimitPost = $_REQUEST['frag_limit'] ? (int)$_REQUEST['frag_limit'] : 0;
	$bountyPost = $_REQUEST['bounty'] ? (int)$_REQUEST['bounty'] : 0;

	if ($hasGuildWarsFragLimitColumn && $hasGuildWarsBountyColumn) {
		if ($fragLimitPost <= 0 || $bountyPost <= 0) {
			$errors[] = 'Frag limit and bounty needs to be higher than 0.';
		}
		else {
			if ($guild->getCustomField('balance') < $bountyPost) {
				$errors[] = "Your guild does not have that much money in the bank account balance to invite with the
					bounty of $bountyPost gold.";
			}
		}
	}

	if(!empty($errors)) {
		$twig->display('error_box.html.twig', ['errors' => $errors]);
		$twig->display('guilds.back_button.html.twig');
		return;
	}

	$guild_leader_char = $guild->getOwner();
	$guild_leader = false;
	$account_players = $account_logged->getPlayers();

	foreach($account_players as $player) {
		if($guild_leader_char->getId() == $player->getId()) {
			$guild_leader = true;
		}
	}

	if ($guild_leader) {
		if ($enemyGuild->getId() != $guild->getId()) {
			$currentWars = [];
			$wars = new OTS_GuildWars_List();
			foreach ($wars as $war) {
				if ($war->getStatus() == OTS_GuildWar::STATE_INVITED || $war->getStatus() == OTS_GuildWar::STATE_ON_WAR) {
					if ($war->getGuild1Id() == $guild->getId())
						$currentWars[$war->getGuild2Id()] = $war->getStatus();
					elseif ($war->getGuild2Id() == $guild->getId())
						$currentWars[$war->getGuild1Id()] = $war->getStatus();
				}
			}

			if (isset($currentWars[$enemyGuild->getID()])) {
				// in war or invited
				if ($currentWars[$enemyGuild->getID()] == OTS_GuildWar::STATE_INVITED) {
					// guild already invited you or you invited that guild
					$errors[] = 'There is already invitation between your and this guild.';
				} else {
					// you are on war with this guild
					$errors[] = 'There is already war between your and this guild.';
				}
			} else {
				// can invite
				$war = new OTS_GuildWar();
				$war->setGuild1Id($guild->getID());
				$war->setGuild2Id($enemyGuild->getID());
				$war->setStatus(OTS_GuildWar::STATE_INVITED);

				if ($hasGuildWarsNameColumn) {
					$war->setName1('name1', $guild->getName());
					$war->setName2('name2', $enemyGuild->getName());
				}

				$war->save();

				if ($hasGuildWarsStartedColumn) {
					$war->setCustomField('started', time());
					$war->setCustomField('ended', 0);
				}

				if ($hasGuildWarsNameColumn) {
					$war->setCustomField('name1', $guild->getName());
					$war->setCustomField('name2', $enemyGuild->getName());
				}

				if ($hasGuildWarsFragLimitColumn) {
					$war->setCustomField('frag_limit', $fragLimitPost);
					$war->setCustomField('declaration_date', date('Y-m-d H:i:s', time()));
					$war->setCustomField('bounty', $bountyPost);

					// reduce bounty from guild balance
					$guild->setCustomField('balance', $guild->getCustomField('balance') - $bountyPost);
				}

				header('Location: ' . getGuildLink($guild->getName(), false));
				echo 'War invitation sent. Redirecting...';
			}
		} else {
			$errors[] = 'You cannot invite same guild!';
		}
	}
	else {
		$errors[] = 'You are not a leader of guild!';
	}
}

if(!empty($errors)) {
	$twig->display('error_box.html.twig', ['errors' => $errors]);
	$twig->display('guilds.back_button.html.twig');
}
