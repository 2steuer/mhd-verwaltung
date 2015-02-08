<?php

class DeviceCategory extends MaterialDataObject {
	static $db = array(
		'Name' => 'Varchar',
		'Description' => 'Text'
	);

	static $has_many = array('Devices' => 'Device');

	static $belongs_many_many = array('Subscribers' => 'Member');

    static $has_one = array('HolderPage' => 'PruefdatenParentPage');

	public function ActiveDevices() {
		return Device::get()->filter(array('CategoryID' => $this->ID, 'Active' => '1'));
	}
}