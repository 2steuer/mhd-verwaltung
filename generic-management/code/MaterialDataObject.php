<?php

class MaterialDataObject extends DataObject {
	private static $db = array('Active' => 'Boolean');

	private static $defaults = array('Active' => '1');

	public function sort_by_name() {
		if($ret = $this->stat('sort_by_name')) {
			return $ret;
			
		}
		else {
			return true;
		}
	}

}