<?php

class DeviceCategory extends DataObject {
	static $db = array(
		'Name' => 'Varchar',
		'Description' => 'Text',
		'Active' => 'Boolean'
	);

	static $defaults = array('Active' => '1');

	static $has_many = array('Devices' => 'Device');

	static $belongs_many_many = array('Subscribers' => 'Member');
}