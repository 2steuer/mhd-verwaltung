<?php

class DeviceCategory extends MaterialDataObject {
	static $db = array(
		'Name' => 'Varchar',
		'Description' => 'Text'
	);

	static $has_many = array('Devices' => 'Device');

	static $belongs_many_many = array('Subscribers' => 'Member');
}