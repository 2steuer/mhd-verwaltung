<?php

class CheckType extends DataObject {

	static $db = array(
			'Name' => 'Varchar',
			'Description' => 'Text',
			'Active' => 'Boolean'
		);

	static $defaults = array('Active' => '1');
}