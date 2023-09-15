<?php
defined('MYAAC') or die('Direct access not allowed!');

class OTS_GuildWar extends OTS_Row_DAO
{
	const STATE_INVITED = 0;
	const STATE_ON_WAR = 1;
	const STATE_REJECTED = 2;
	const STATE_CANCELED = 3;
	const STATE_WAR_ENDED = 4;

	public static $table = 'guild_wars';
	public $data = array('guild_id' => null, 'name1' => null, 'name2' => null, 'level' => null,);
	public static $fields = array('id', 'guild1', 'guild2', 'status');

	public function load($id){
		$this->data = $this->db->select(self::$table, ['id' => $id]);
	}

	public function find($name) {
		throw new RuntimeException('Method ' . __CLASS__ . '::' . __METHOD__ . ' is not implemented.');
	}

	public function save()
	{
		if ($this->db->hasColumn(self::$table, 'name1')) {
			self::$fields[] = 'name1';
			self::$fields[] = 'name2';
		}

		$data = [];
		foreach(self::$fields as $key) {
			if ($key != 'id') {
				$data[$key] = $this->data[$key];
			}
		}

		// insert new
		if (!isset($this->data['id'])) {
			$this->db->insert(self::$table, $data);
			$this->setId($this->db->lastInsertId());
		}
		else {
			$this->db->update(self::$table, $data, ['id' => $this->data['id']]);
		}
	}

	public function delete()
	{
		if (!$this->isLoaded())
		{
			throw new E_OTS_NotLoaded();
		}

		$this->db->exec('DELETE FROM `' . self::$table . '` WHERE `id` = ' . $this->db->quote($this->data['id']));
		$_tmp = new self();
		$this->data = $_tmp->data;
		unset($_tmp);
	}

	public function getCustomField($field)
	{
		if( !isset($this->data['id']) )
		{
			throw new E_OTS_NotLoaded();
		}

		$value = $this->db->query('SELECT `' . $field . '` FROM `guild_wars` WHERE `id` = ' . $this->data['id'])->fetch();
		return $value[$field];
	}

	public function setCustomField($field, $value)
	{
		if( !isset($this->data['id']) ) {
			throw new E_OTS_NotLoaded();
		}

		// quotes value for SQL query
		if(!( is_int($value) || is_float($value) )) {
			$value = $this->db->quote($value);
		}

		$this->db->query('UPDATE `guild_wars` SET `' . $field . '` = ' . $value . ' WHERE `id` = ' . $this->data['id']);
	}

	public function isLoaded() {return isset($this->data['id']);}
	public function getId() {return $this->data['id'];}
	public function setId($value) {$this->data['id'] = $value;}
	public function getGuild1Id() {return $this->data['guild1'];}
	public function setGuild1Id($value) {$this->data['guild1'] = $value;}
	public function getGuild2Id() {return $this->data['guild2'];}
	public function setGuild2Id($value) {$this->data['guild2'] = $value;}
	public function getStatus() {return $this->data['status'];}
	public function setStatus($value) {$this->data['status'] = $value;}
	public function setName1($value) {$this->data['name1'] = $value;}
	public function setName2($value) {$this->data['name2'] = $value;}
}
