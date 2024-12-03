<?php

namespace MyAAC\Plugin;

class WelcomeBox
{
	private $db;

	/**
	 * @param \OTS_DB_MySQL $db
	 */
	public function __construct($db) {
		$this->db = $db;
	}

	public function getTotal()
	{
		$total = [];
		$query = $this->db->query('SELECT count(*) as `how_much` FROM `accounts`;')->fetch(\PDO::FETCH_ASSOC);
		$total['accounts'] = $query['how_much'];

		$total['bannedAccounts'] = $this->getBannedPlayers();

		$query = $this->db->query('SELECT count(*) as `how_much` FROM `players`;')->fetch(\PDO::FETCH_ASSOC);
		$total['players'] = $query['how_much'];

		$query = $this->db->query('SELECT count(*) as `how_much` FROM `guilds`;')->fetch(\PDO::FETCH_ASSOC);
		$total['guilds'] = $query['how_much'];

		$query = $this->db->query('SELECT count(*) as `how_much` FROM `houses`;')->fetch(\PDO::FETCH_ASSOC);
		$total['houses'] = $query['how_much'];

		$query = $this->db->query('SELECT count(*) as `how_much` FROM `houses` WHERE `owner` = 0;')->fetch(\PDO::FETCH_ASSOC);
		$total['freeHouses'] = $query['how_much'];

		$query = $this->db->query('SELECT count(*) as `how_much` FROM `houses` WHERE `owner` != 0;')->fetch(\PDO::FETCH_ASSOC);
		$total['rentedHouses'] = $query['how_much'];

		return $total;
	}

	public function getLastJoinedPlayer() {
		return $this->getPlayer('id');
	}

	public function getBestPlayer() {
		return $this->getPlayer('experience');
	}

	public function getPlayer($orderBy)
	{
		$query = $this->db->query('SELECT `id`, `name`, `level` FROM `players` ORDER BY ' . $this->db->fieldName($orderBy) . ' DESC LIMIT 1;');
		if($query->rowCount() === 0) {
			return $this->notFoundPlayer();
		}

		$player = $query->fetch(\PDO::FETCH_ASSOC);
		$player['link'] = getPlayerLink($player['name'], false);

		return $player;
	}

	private function notFoundPlayer()
	{
		$player = [];

		$player['id'] = 1;
		$player['name'] = 'Not found';
		$player['level'] = 1;
		$player['link'] = BASE_URL;

		return $player;
	}

	private function getBannedPlayers()
	{
		if(tableExist('account_bans')) {
			$query = $this->db->query('SELECT count(*) as `how_much` FROM `account_bans` WHERE `expires_at` > ' . time() .' OR `expires_at` = -1;')->fetch();
			return $query['how_much'];
		}
		elseif(tableExist('bans')) {
			if (fieldExist('bans', 'active')) {
				$query = $this->db->query('SELECT count(*) as `how_much` FROM `bans` WHERE (`type` = 3 OR `type` = 5) AND `active` = 1 AND (`expires` > ' . time() . ' OR `expires` = -1);')->fetch();
				return $query['how_much'];
			} else { // tfs 0.2
				$query = $this->db->query('SELECT count(*) as `how_much` FROM `bans` WHERE (`type` = 3 OR `type` = 5) AND (`expires` > ' . time() . ' OR `expires` = -1);')->fetch();
				return $query['how_much'];
			}
		}

		return 'Unknown';
	}
}
