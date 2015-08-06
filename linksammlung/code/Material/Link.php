<?php

class Link extends MaterialDataObject {
	static $db = array(
		'Name' => 'Varchar(200)',
		'Link' => 'Varchar(200)'
	);

	static $has_many = array(
		'Clothings' => 'Clothing'
	);

	static $singular_name = 'Link';
	static $plural_name = 'Links';

    static $sort_field = 'ID DESC';

	static $field_labels = array('Name' => 'Bezeichnung', 'Link' => 'Link');

	public function getFrontendFields($params = null) {
		$fields = parent::getFrontendFields($params);

		$fields->removeByName('Active');

		return $fields;
	}
}