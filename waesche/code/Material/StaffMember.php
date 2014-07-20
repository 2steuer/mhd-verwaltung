<?php

class StaffMember extends MaterialDataObject {
	static $db = array(
		'Name' => 'Varchar',
		'StaffNumber' => 'Varchar',
		'Notes' => 'Text'
	);

	static $has_many = array(
		'Clothings' => 'Clothing'
	);

	static $singular_name = 'Helfer';
	static $plural_name = 'Helfer';

	static $field_labels = array('Notes' => 'Bemerkungen', 'StaffNumber' => 'Mitarbeiternummer');

	public function getFrontendFields($params = null) {
		$fields = parent::getFrontendFields($params);

		$fields->removeByName('Active');

		return $fields;
	}
}