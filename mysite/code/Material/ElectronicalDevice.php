<?php

class ElectronicalDevice extends DataObject {
	static $db = array(
			'Name' => 'Varchar',
			'Description' => 'Text',
			'Barcode' => 'Varchar',
			'Active' => 'Boolean'

		);

	public static $defaults = array('Active' => '1');

	static $has_one = array(
			'Place' => 'Place'
		);

	static $singular_name = 'Gerät';
	static $plural_name = 'Geräte';

	public function getFrontendFields($params = null) {
		$fields = parent::getFrontendFields();

		$fields->removeByName('Active');
		$fields->replaceField('PlaceID', DropDownField::create('PlaceID', 'Standort')
				->setSource(Place::get()->filter('Active', '1')->map('ID', 'Name'))
			);

		return $fields;
	}
}