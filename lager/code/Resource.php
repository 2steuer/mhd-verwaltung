<?php

class Resource extends MaterialDataObject {
	static $db = array(
			'Name' => 'Varchar',
			'Description' => 'Text',
			'Quantity' => 'Int'
		);

	static $has_one = array('Category' => 'ResourceCategory');
}