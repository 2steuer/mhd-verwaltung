<?php

class Supplier extends MaterialDataObject {
	static $db = array(
			'Name' => 'Varchar',
			'ContactName' => 'Varchar',
			'Street' => 'Varchar',
			'PLZ' => 'Varchar',
			'City' => 'Varchar',
			'Phone' => 'Varchar',
			'Web' => 'Varchar',
			'Email' => 'Varchar',
			'Fax' => 'Varchar',
			'CustomerNumber' => 'Varchar'
		);


	static $has_many = array('Devices' => 'Device');

	public function DropDownName() {
		$str = $this->Name;

		if(!empty($this->ContactName)) {
			$str .= " (".$this->ContactName."), ";
		}
		else {
			$str .= ", ";
		}

		$str .= $this->City;

		return $str;
	}

	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName('Active');
		return $fields;
	}
}