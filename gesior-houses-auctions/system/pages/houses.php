<?php
defined('MYAAC') or die('Direct access not allowed!');

$title = 'Houses';

$auctionDaysDefault = 3;

$badInfoStart = '';
$badInfoEnd = '<br />';
$goodInfoStart = '';
$goodInfoEnd = '';

function timeToEndString($end)
{
	$timeLeft = $end - time();
	if($timeLeft <= 0)
		return 'auction finished';
	elseif($timeLeft >= 86400)
		return floor($timeLeft / 86400) . ' days left';
	elseif($timeLeft >= 3600)
		return floor($timeLeft / 3600) . ' hours left';
	elseif($timeLeft >= 60)
		return floor($timeLeft / 60) . ' minutes left';
	else
		return $timeLeft . ' seconds left!';
}

$towns_list = $config['towns'];
if($action == '')
{
	##-- town --##
	$houses_town = isset($_REQUEST['town']) ? (int)$_REQUEST['town'] : 0;
	if(count($towns_list) > 0)
	{
		foreach($towns_list as $town_ids => $town_names)
		{
			if($town_ids == $houses_town)
			{
				$town_id = $town_ids;
				$town_name = $town_names;
			}
		}
	}
	##-- owner --##
	$houses_owner = isset($_REQUEST['owner']) ? (int)$_REQUEST['owner'] : 0;
	if($houses_owner == 0)
	{
		$owner_sql = '';
	}
	elseif($houses_owner == 1)
	{
		$owner_sql = ' AND owner = 0';
	}
	elseif($houses_owner == 2)
	{
		$owner_sql = ' AND owner > 0';
	}
	##-- order --##
	$houses_order = isset($_REQUEST['order']) ? (int) $_REQUEST['order'] : 0;
	if($houses_order == 0)
	{
		$order_sql = 'name';
	}
	elseif($houses_order == 1)
	{
		$order_sql = 'size';
	}
	elseif($houses_order == 2)
	{
		$order_sql = 'rent';
	}
	##-- status --##
	$houses_status = isset($_REQUEST['status']) ? (int) $_REQUEST['status'] : 0;

		$status_name = 'Houses and Flats';

	##-- List Houses --##
	$id = isset( $_GET['show']) ? (int) $_GET['show'] : 0;
	if(empty($id))
	{
		echo 'Here you can see the list of all available houses, flats or guildhalls. Please select the game world of your choice. Click on any view button to get more information about a house or adjust the search criteria and start a new search.<br><br>';
		if($houses_town > 0)
		{
			echo '<table border=0 cellspacing=1 cellpadding=4 width=100%>
				<tr bgcolor="'.$config['site']['vdarkborder'].'" class=white>
					<td colspan=5 style="color:white;"><b>Available '.$status_name.' in '.$town_name.' on '.$config['lua']['serverName'].'</b></td>
				</tr>
				<tr bgcolor="'.$config['darkborder'].'">
					<td width=24%><b>Name</b></td><td width=11%><b>Size</b></td><td width=15%><b>Rent</b></td><td width=30%><b>Status</b></td><td width=20%></td>
				</tr>';
				$houses_sql = $db->query('SELECT * FROM houses WHERE town_id = '.$town_id.''.$owner_sql.' ORDER BY '.$order_sql.' DESC')->fetchAll();
				$counter = 0;
				foreach($houses_sql as $house)
				{
					if(is_int($counter / 2))
						$bgcolor = $config['lightborder'];
					else
						$bgcolor = $config['darkborder'];
					$counter++;
					if($house['owner'] == 0)
					{
						if($house['highest_bidder'] > 0)
						{
							$owner = 'auctioned (' . $house['last_bid'] . ' gold, ' . timeToEndString($house['bid_end']) . ')';
						}
						else
						{
							$owner = 'auctioned (no bid yet)';
						}
					}
					elseif($house['owner'] > 0)
					{
						$player = new OTS_Player();
						$player->load($house['owner']);
						$owner = 'owned by ' . getPlayerLink($player->getName());
					}
					echo '<tr bgcolor="'.$bgcolor.'">
						<td>'.$house['name'].'</td>
						<td>'.$house['size'].' sqm</td>
						<td>'.$house['rent'].' gold</td>
						<td>'.$owner.'</td>
						<td><a href="?subtopic=houses&show='.$house['id'].'"><img src="'.$template_path.'/images/buttons/sbutton_view.gif" border="0"></a></td>
					</tr>';
				}
			echo '</table><br>';
		}
		echo '<form action="?subtopic=houses" method="post">
			<table border=0 cellspacing=1 cellpadding=4 width=100%>
				<tr bgcolor="'.$config['site']['vdarkborder'].'" class=white>
					<td colspan="3" style="color:white;"><b>Search House</b></td>
				</tr>
				<tr bgcolor="'.$config['darkborder'].'">';
					echo '<td width=25%><b>Town</b></td>
					<td width=25%><b>Status</b>
					</td><td width=25%><b>Sort</b></td>
				</tr>
				<tr bgcolor="'.$config['darkborder'].'">';
					echo '<td valign=top rowspan=2>';
						foreach($towns_list as $id => $town_n)
						{
							echo '<label><input type="radio" name="town" value="'.$id.'" ';
							if($houses_town == $id || ($houses_town == 0 && $id == 1))
								echo 'checked="checked" ';
							echo '>'.$town_n.'</label><br>';
						}
					echo '</td>
					<td valign=top>
						<label><input type="radio" name="owner" value="0" ';
						if($houses_owner == 0)
							echo 'checked="checked" ';
						echo '>all states</label><br>
						<label><input type="radio" name="owner" value="1" ';
						if($houses_owner == 1)
							echo 'checked="checked" ';
						echo '>auctioned</label><br>
						<label><input type="radio" name="owner" value="2" ';
						if($houses_owner == 2)
							echo 'checked="checked" ';
						echo '>rented</label><br>
					</td>
					<td valign=top rowspan=2>
						<label><input type="radio" name="order" value="0" ';
						if($houses_order == 0)
							echo 'checked="checked" ';
						echo '>by name</label><br>
						<label><input type="radio" name="order" value="1" ';
						if($houses_order == 1)
							echo 'checked="checked" ';
						echo '>by size</label><br>
						<label><input type="radio" name="order" value="2" ';
						if($houses_order == 2)
							echo 'checked="checked" ';
						echo '>by rent</label><br>
					</td>
				</tr>
				<tr bgcolor="'.$config['darkborder'].'">
					<td valign=top>
						<input type="radio" name="status" value="0" ';
						if($houses_status == 0)
							echo 'checked="checked" ';
						echo '>houses and flats<br>';
						if(isset($config['lua']['guildHalls']) && $config['lua']['guildHalls'] == true)
						{
							echo '<input type="radio" name="status" value="1" ';
							if($houses_status == 1)
								echo 'checked="checked" ';
							echo '>guildhalls<br>';
						}
						echo '
					</td>
				</tr>
				<tr>
					<td><br><center><input type=image name="Submit" alt="Submit" src="'.$template_path.'/images/buttons/sbutton_submit.gif" border="0" WIDTH=120 HEIGHT=18></center></td>
				</tr>
			</table>
		</form>';
	}
	##-- Show House --##
	else
	{
		$house = $db->query('SELECT * FROM houses WHERE id = '.$id.'')->fetch();
		if(isset($house['doors'])) {
			if($house['doors'] < 2)
				$door = '1 door';
			else
				$door = $house['doors'] + 1 .' doors';
		}

		if($house['beds'] < 2)
			$bed = '1 bed';
		else
			$bed = $house['beds'].' beds';
		if($house['owner'] > 0)
		{
			$player = new OTS_Player();
			$player->load($house['owner']);
			if($house['paid'] > 0)
				$paid = ' and paid until <b>'.date("M j Y, H:i:s", $house['paid']).' CET</b>';
			$owner = '<br>The house is currently rented by ' . getPlayerLink($player->getName()) . $paid.'.';
		}
		else
		{
			if($house['highest_bidder'] > 0)
			{
				if($house['bid_end'] > time())
				{
					$bidder = new OTS_Player();
					$bidder->load($house['highest_bidder']);
					$owner = '<br />The house is currently being auctioned. The highest bid so far is <b>' . $house['last_bid'] . ' gold</b> and has been submitted by ' . getPlayerLink($bidder->getName()). '. Auction will end at <b>' . date("M j Y, H:i:s", $house['bid_end']) . '</b>.';
				}
				else
				{
					$bidder = new OTS_Player();
					$bidder->load($house['highest_bidder']);
					$owner = '<br />This house auction is finished. ' . getPlayerLink($bidder->getName()) . ' won this auction with bid <b>' . $house['last_bid'] . ' gold</b>. Auction finished on ' . date("M j Y, H:i:s", $house['bid_end']) . '.';
				}
			}
			else
			{
				$owner = 'The house is currently being auctioned. No bid has been submitted so far.';
			}
		}
		$house_image = 'images/houses/' . $house['id'] . '.png';
		if(!file_exists(BASE . $house_image)) {
			$house_image = 'images/houses/default.jpg';
		}
		echo '<table border=0 cellspacing=1 cellpadding=4 width=100%><tr><td><img src="' . $house_image . '" alt="house image" /></td><td><table border=0 cellspacing=1 cellpadding=4 width=100%>
			<tr>
				<td></td>
				<td>
					<b>'.$house['name'].'</b><br>
					This house has ' . (isset($door) ? '<b>'.$door.'</b> and ' : '') . '<b>'.$bed.'</b> and it is placed in <b>'.$towns_list[$house['town_id']].'</b>.<br><br>
					The house has a size of <b>'.$house['size'].' square meters</b>.
					The monthly rent is <b>'.$house['rent'].' gold</b> and will be debited to the bank account on <b>' . $config['lua']['serverName'] . '</b><br>
					'.$owner;
				   
		if($logged)
		{
			$houseBidded = $db->query('SELECT `houses`.`id` house_id, `players`.`id` bidder_id FROM `houses`, `players` WHERE `players`.`id` = `houses`.`highest_bidder` AND `players`.`account_id` = ' . $account_logged->getId())->fetch();
		}
		if($logged && isset($houseBidded['house_id']) && $houseBidded['house_id'] == $house['id'])
		{
			echo '<br /><br /><b>YOUR MAXIMUM OFFER IS NOW HIGHEST ON THAT AUCTION, IT IS <span style="color:red">' . $house['bid'] . '</span> GOLD COINS.';
		}
		echo '
				</td>
			</tr>
			<tr>
				<td colspan=2></td>
			</tr>
		</table></td></tr></table><br />';

		if($house['owner'] == 0 && ($house['bid_end'] > time() || $house['bid_end'] == 0))
		{
			// bid button
			echo '<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><TR><TD><center><a href="?subtopic=houses&action=bid&house=' . $house['id'] . '"><img src="images/buttons/sbutton_bid.gif" BORDER=0 /></a></center></TD><TD><center><a href="?subtopic=houses&town=' . (int) $house['town_id'] . '&owner=' . (($house['owner'] > 0) ? 1 : 0) . '&order=0&status=0"><img src="'.$template_path.'/images/buttons/sbutton_back.gif" BORDER=0 /></a></center></TD></TR></TABLE>';
		}
		else
		{
			echo '<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><TR><TD><center><a href="?subtopic=houses&town=' . (int) $house['town_id'] . '&owner=' . (($house['owner'] > 0) ? 1 : 0) . '&order=0&status=0"><img src="'.$template_path.'/images/buttons/sbutton_back.gif" BORDER=0 /></a></center></TD></TR></TABLE>';
		}
	}
}
elseif($action == 'bid')
{
	if($logged)
	{
		$houseOwned = $db->query('SELECT `houses`.`id` house_id, `players`.`id` owner_id FROM `houses`, `players` WHERE `players`.`id` = `houses`.`owner` AND `players`.`account_id` = ' . $account_logged->getId() . ' LIMIT 1')->fetch();
		if($houseOwned === false)
		{
			if(isset($_REQUEST['house']))
			{
				$house = new OTS_House();
				$house->load((int)$_REQUEST['house']);
				if($house->isLoaded())
				{
					if($house->getOwnerId() == 0)
					{
						if($house->getBidEnd() == 0 || $house->getBidEnd() > time())
						{
							$houseBidded = $db->query('SELECT `houses`.`id` house_id, `players`.`id` bidder_id FROM `houses`, `players` WHERE `players`.`id` = `houses`.`highest_bidder` AND `players`.`account_id` = ' . $account_logged->getId())->fetch();
							if($houseBidded === false || $houseBidded['house_id'] == $house->getId())
							{
							   
									$bidded = false;
									if(isset($_REQUEST['do_bid']))
									{
										if(isset($_REQUEST['bid']) && isset($_REQUEST['bidder']))
										{
											$bidder = new OTS_Player();
											$bidder->load($_REQUEST['bidder']);
											$bid = (int) $_REQUEST['bid'];
											if($bidder->isLoaded() && $bidder->getAccountId() == $account_logged->getId())
											{
												if($bidder->getBalance() >= $bid)
												{
													// jesli przebija swoja oferte to nie musi dawac wiecej
													// moze tylko zmieniac postac ktora zostanie, a nawet obnizac maksymalna
													if($bid > 0 && ($bid > $house->getBid() || $houseBidded !== false))
													{
														// jesli przebija sam siebie to nie podnosi ceny aktualnej
														if($houseBidded === false)
														{
															// ustawia cene na cene przed przebiciem + 1 gold
															// moze to podniesc z 0 do 1 gold przy nowym domku
															// lub ustawic wartosc maksymalna osoby co licytowala wczesniej + 1
															$house->setLastBid($house->getBid()+1);
														}
														// ustawic najwyzsza oferowana kwote na podana
														// jesli przebija swoja aukcje kwota mniejsza niz aktualna to nie zmieniaj!
														// jak ktos inny przebija to i tak bid bedzie wiekszy-rowny od aktualnego
														// (nawet jak o 1 gp przebija - 6 linijek wyzej ustawia ...
														// na kwote mniejsza niz bid + 1, wiec bedzie rowny)
														if($bid >= $house->getLastBid())
														{
															$house->setBid($bid);
														}
														// ustawic postac ktora zostanie wlascicielem na podana
														$house->setHighestBidder($bidder->getId());
														if($house->getBidEnd() == 0)
														{
															$auctionEnd = time() + $auctionDaysDefault * 86400;
															if(isset($config['lua']['serverSaveEnabled']) && $config['lua']['serverSaveEnabled'] == 'yes')
															{
																$serverSaveHour = $config['lua']['serverSaveHour'];
																if($serverSaveHour >= 0 && $serverSaveHour <= 24)
																{
																	$timeNow = time();
																	$timeInfo = localtime($timeNow, true); // current time, associative = true
																	if ($serverSaveHour == 0)
																	{
																		$serverSaveHour = 23;
																	}
																	else
																	{
																		$serverSaveHour--;
																	}

																	$timeInfo['tm_hour'] = $serverSaveHour;
																	$timeInfo['tm_min'] = 55;
																	$timeInfo['tm_sec'] = 0;
																	$difference = mktime($timeInfo['tm_hour'], $timeInfo['tm_min'], $timeInfo['tm_sec'], (int) $timeInfo['tm_mon'] + 1, $timeInfo['tm_mday'], (int) $timeInfo['tm_year'] + 1900) - $timeNow;

																	if($difference < 0)
																	{
																		$difference += 86400;
																	}
																	$auctionEnd = time() + $difference + ($auctionDaysDefault-1) * 86400;
																}
															}
															$house->setBidEnd($auctionEnd);
														}
														$house->save();
														echo $goodInfoStart . 'Your offer is now highest on auction. Current price for house is <b>' . $house->getLastBid() . ' gold</b>, your maximum price is <b>' . $house->getBid() . ' gold</b>. Character <b>' . htmlspecialchars($bidder->getName()) . '</b> from your account will get house, if you win.' . $goodInfoEnd;
														// udalo sie przebic, wiec nie pokazuje formularza
														$bidded = true;
													}
													else
													{
														if($bid >= $house->getLastBid())
														{
															$house->setLastBid($bid);
															$house->save();
														}
														echo $badInfoStart . 'Your offer of ' . $bid . ' gold is too low.' . $badInfoEnd;
													}
												}
												else
													echo $badInfoStart . 'Character <b>' . htmlspecialchars($bidder->getName()) . '</b> does not have enough money on bank account.' . $badInfoEnd;
											}
											else
												echo 'Selected player is not on your account?! Hax?';
										}
										else
											echo 'Missing one of bid parameters?! Hax?';
									}
									if(!$bidded)
									{
										// show bid form
										echo '<form action="' . getLink('houses') . '" method="post">
										<input type="hidden" name="action" value="bid" />
										<input type="hidden" name="house" value="' . $house->getId() . '" />
										<input type="hidden" name="do_bid" value="1" />
										<table border=0 cellspacing=1 cellpadding=4 width=100%>
											<tr bgcolor="'.$config['site']['vdarkborder'].'" class=white>
												<td colspan="2" style="color:white;"><b>Bid at auction of house ' . $house->getName() . ' placed in ' . $towns_list[$house->getTownId()] . '</b></td>
											</tr>
											<tr bgcolor="'.$config['darkborder'].'">
												<td><b>Owner:</b></td>
												<td><select name="bidder">';
												foreach($account_logged->getPlayers() as $accountPlayer)
												{
													echo '<option value="' . $accountPlayer->getId() . '"';
													if($accountPlayer->getId() == $house->getHighestBidder())
														echo 'selected="selected"';
													echo '>' . htmlspecialchars($accountPlayer->getName()) . '</option>';
												}
										echo '</select></td>
											</tr>
											<tr bgcolor="'.$config['lightborder'].'">
												<td width="200px"><b>Your maximum offer:</b></td>
												<td><input type="text" size="9" name="bid" value="' . (($houseBidded['house_id'] == $house->getId()) ? $house->getBid() : $house->getLastBid()+1) . '" /> gold coins</td>
											</tr>
											<tr bgcolor="'.$config['darkborder'].'">
												<td><b>Current bid:</b></td>
												<td>' . $house->getLastBid() . ' gold coins</td>
											</tr>
											<tr bgcolor="'.$config['lightborder'].'">
												<td><b>Owner</b></td>
												<td><input type=image name="Submit" alt="Submit" src="images/buttons/sbutton_bid.gif" border="0" WIDTH=120 HEIGHT=18></td>
											</tr>
										</table>
									</form><br />If your offer is now highest on auction you can bid to make your maximum offer lower (cannot be lower then current "bid") or higher.<br />You can also bid you change character that will own house, if you win auction.';
									}
							}
							else
								echo 'You are already bidding on other house auction.';
						}
						else
							echo 'This auction is finished.';
					}
					else
						echo 'This house is not on auction!';
				}
				else
					echo 'This house does not exist!';
			}
			else
				echo 'Choose house!';
		}
		else
			echo 'You already own one house. You can\'t buy more.';
	}
	else
		echo 'You must login to bid on auction!';
	echo '<br /><br /><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><TR><TD><center><a href="?subtopic=houses&show=' . (int) $_REQUEST['house'] . '"><img src="'.$template_path.'/images/buttons/sbutton_back.gif" BORDER=0 /></a></center></TD></TR></TABLE>';
}
