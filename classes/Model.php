<?php

class Model {

	protected $db = null;
	protected $errors = array();
	protected $records = array();

	public function __construct($db) {
		$this->db = $db;
	}

	public function __get($prop) {
		if (property_exists($this, $prop))
			return $this->$prop;
		else
			return null;
	}

	protected function process($q) {
		$r = $this->db->query($q);
		if ($this->db->errno) {
			$this->errors[] = 'MySQLi Error: '.$this->db->error."\n\n".$q;
		} elseif ($this->db->insert_id) { // Insert or update
			$this->records[$this->db->insert_id] = array();
        } elseif (is_object($r) && $r->num_rows) { // Select with data, if not select it may just return 1 on success
        	while ($row = $r->fetch_assoc())
				$this->records[] = $row;
		} else { // Select with no data or delete
			$this->records = array();
		}
	}

}

?>