<?php

class CheckType extends MaterialDataObject {

	static $db = array(
			'Name' => 'Varchar',
			'Description' => 'Text'
		);

    static $has_one = array('HolderPage' => 'PruefdatenParentPage');
}