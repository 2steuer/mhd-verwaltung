<?php

class MaterialDataObject extends DataObject {
	private static $db = array('Active' => 'Boolean');

	private static $defaults = array('Active' => '1');
}