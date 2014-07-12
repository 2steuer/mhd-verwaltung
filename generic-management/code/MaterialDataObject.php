<?php

class MaterialDataObject extends DataObject {
	private static $db = array('Active' => 'Boolean');

	private static $defaults = array('Active' => '1');

	private static $sort_field = true;
	private static $join_table = null;
	private static $join_field = null;

	public function sort_field() {
		return $this->stat('sort_by_name');
	}

	public function join_table() {
		return $this->stat('join_table');
	}

	public function join_field() {
		return $this->stat('join_field');
	}

}