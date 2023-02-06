<?php

namespace MyAAC\Plugin;

class Census
{
	private $db;
	public function __construct(\OTS_DB_MySQL $db)
	{
		$this->db = $db;
	}

	public function getVocationStats()
	{
		$vocations = array();
		$vocations_db = $this->db->query('SELECT vocation, count( `vocation` ) AS amount FROM `players` WHERE `vocation` <= ' . config('vocations_amount') . ' GROUP BY vocation');
		foreach($vocations_db as $v) {
			$vocations[$v['vocation']] = $v['amount'];
		}

		$vocations_db = $this->db->query('SELECT vocation, count( `vocation` ) AS amount FROM `players` WHERE `vocation` > ' . config('vocations_amount') . ' GROUP BY vocation');
		foreach($vocations_db as $v) {
			$vocations[$v['vocation'] - config('vocations_amount')] += $v['amount'];
		}

		return $vocations;
	}

	public function getGenderStats()
	{
		$query = $this->db->query('SELECT sex as gender, count( `sex` ) AS amount FROM `players` GROUP BY sex');
		return $query->fetchAll();
	}

	public function getCountriesStats()
	{
		$query = $this->db->query('SELECT country, count( `country` ) AS amount FROM `accounts` GROUP BY country ORDER BY amount DESC LIMIT ' . config('census_countries'));
		return $query->fetchAll();
	}

	public function getCountriesOther()
	{
		$query = $this->db->query("SELECT SUM(amount) as other FROM (
		SELECT country, count( `country` ) AS amount FROM `accounts` WHERE country NOT IN 
		(select * from (SELECT country FROM `accounts` GROUP BY country ORDER BY count( `country` ) DESC LIMIT " .
			config('census_countries') . ") temp_tab) AND country<>''
		GROUP BY country) AS t");

		$query = $query->fetch(\PDO::FETCH_ASSOC);
		return $query['other'] === null ? 0 : $query['other'];
	}
}
