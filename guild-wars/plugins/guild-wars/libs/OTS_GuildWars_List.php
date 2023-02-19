<?php
defined('MYAAC') or die('Direct access not allowed!');

class OTS_GuildWars_List extends OTS_Base_List
{
	public function init()
	{
		$this->table = 'guild_wars';
		$this->class = 'GuildWar';
	}
}
