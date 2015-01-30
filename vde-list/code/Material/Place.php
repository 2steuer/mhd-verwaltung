<?php

class Place extends MaterialDataObject {
	static $db = array(
			'Name' => 'Varchar',
			'Description' => 'Text'
		);

    static $has_many = array('Devices' => 'ElectronicalDevice');

	static $field_labels = array('Description' => 'Bemerkungen');

	static $singular_name = 'Ort';
	static $plural_name = 'Orte';


	public function getFrontendFields($params = null) {
		$fields = parent::getFrontendFields();

		$fields->removeByName('Active');

		return $fields;
	}

}