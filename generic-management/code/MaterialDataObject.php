<?php

class MaterialDataObject extends DataObject {
	private static $db = array('Active' => 'Boolean');

	private static $defaults = array('Active' => '1');

	private static $sort_field = true;
	private static $join_table = null;
	private static $join_field = null;
	private static $quick_search_field = '';
	private static $quick_search_label = 'Name';

	public function sort_field() {
		return $this->stat('sort_by_name');
	}

	public function join_table() {
		return $this->stat('join_table');
	}

	public function join_field() {
		return $this->stat('join_field');
	}

	public function quick_search_field() {
		return $this->stat('quick_search_field');
	}

	public function quick_search_label() {
		return $this->stat('quick_search_label');
	}
}