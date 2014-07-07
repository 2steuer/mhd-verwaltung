<?php

class Place extends DataObject {
	static $db = array(
			'Name' => 'Varchar',
			'Description' => 'Text',
			'Active' => 'Boolean'
		);

	public static $defaults = array('Active' => '1');

	static $singular_name = 'Ort';
	static $plural_name = 'Orte';


	public function getFrontendFields($params = null) {
		$fields = parent::getFrontendFields();

		$fields->removeByName('Active');

		return $fields;
	}

}