<?php

class ElectronicalDevice extends MaterialDataObject {
	static $db = array(
			'Name' => 'Varchar',
			'Description' => 'Text',
			'Barcode' => 'Varchar',
            'ExternalPowerSupply' => 'Boolean'
		);


	static $field_labels = array('Name' => 'Bezeichnung',
		'Description' => 'Bemerkungen');

	static $has_one = array(
			'Place' => 'Place'
		);

	static $singular_name = 'Gerät';
	static $plural_name = 'Geräte';

	public function getFrontendFields($params = null) {
		$fields = parent::getFrontendFields();

		$fields->removeByName('Active');
		$fields->replaceField('PlaceID', DropDownField::create('PlaceID', 'Standort')
				->setSource(Place::get()->filter('Active', '1')->sort('Name')->map('ID', 'Name'))
			);
        $fields->push(CheckboxField::create('ExternalPowerSupply', 'Externes Netzteil'));

		return $fields;
	}

    public function onBeforeWrite() {
        parent::onBeforeDelete();

        if($this->Active == '0') {
            $this->PlaceID = '';
        }
    }

    public function validate() {
        return parent::validate();
    }
}