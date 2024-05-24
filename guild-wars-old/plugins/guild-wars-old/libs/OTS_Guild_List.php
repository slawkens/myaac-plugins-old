<?php
defined('MYAAC') or die('Direct access not allowed!');

class OTS_Guild_List extends OTS_Base_List
{
	public function init()
	{
		$this->table = 'guilds';
		$this->class = 'Guild';
	}
}
