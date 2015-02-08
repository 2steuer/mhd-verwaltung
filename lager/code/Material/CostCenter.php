<?php

class CostCenter extends MaterialDataObject {
	static $db = array(
			'Name' => 'Varchar',
			'Description' => 'Text',
			'Contact' => 'Varchar',
			'Adress' => 'Text'
		);

    static $has_one = array('HolderPage' => 'LagerParentPage');

	static $field_labels = array(
			'Description' => 'Beschreibung',
			'Contact' => 'Ansprechpartner',
			'Adress' => 'Adresse'
		);

	static $singular_name = 'Kostenstelle';
	static $plural_name = 'Kostenstellen';

	public function getFrontendFields($params = null) {
		$fields = parent::getFrontendFields($params);

		$fields->removeByName('Active');
        $fields->removeByName('HolderPageID');

		return $fields;
	}

    public function validate() {
        return parent::validate();
    }
}