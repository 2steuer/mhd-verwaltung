<?php

class ResourceCategory extends MaterialDataObject {

	static $db = array(
			'Name' => 'Varchar',
			'Description' => 'Text'
		);

	static $has_many = array('Resources' => 'Resource');

	static $field_labels = array('Description' => 'Beschreibung');

	static $singular_name = "Artikelkategorie";
	static $plural_name = "Artikelkategorien";

	public function getFrontendFields($params = null) {
		$fields = parent::getFrontendFields($params);

		$fields->removeByName('Active');

		return $fields;
	}
}