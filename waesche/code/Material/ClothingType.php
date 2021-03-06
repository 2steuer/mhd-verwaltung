<?php

class ClothingType extends MaterialDataObject {
	static $db = array(
		'Name' => 'Varchar',
		'Description' => 'Text',
        'ArticleNumber' => 'Varchar'
	);

	static $has_many = array(
		'Clothings' => 'Clothing'
	);

	static $singular_name = 'Kleidungstyp';
	static $plural_name = 'Kleidungstypen';

	static $field_labels = array('Description' => 'Beschreibung', 'Name' => 'Bezeichnung', 'ArticleNumber' => 'Artikelnummer');

	public function getFrontendFields($params = null) {
		$fields = parent::getFrontendFields($params);

		$fields->removeByName('Active');

		return $fields;
	}
}