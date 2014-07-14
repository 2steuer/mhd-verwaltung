<?php

class Clothing extends MaterialDataObject {
	static $db = array(
		'IDCode' => 'Varchar',
		'Size' => 'Varchar',
		'Notes' => 'Text'
	);

	static $has_one = array(
		'Type' => 'ClothingType',
		'Owner' => 'StaffMember'
	);

	static $singular_name = 'Kleidungsstück';
	static $plural_name = 'Kleidungsstücke';

	//static $default_sort = 'ClothingType.Name';

	static $sort_field = "ClothingType.Name";
	static $join_table = 'ClothingType';
	static $join_field = 'TypeID';

	static $quick_search_field = 'IDCode';
	static $quick_search_label = 'ID';

	public function getFrontendFields($params = null) {
		$fields = new FieldList(
			DropDownField::create('TypeID', 'Kleidungstyp')
				->setSource(ClothingType::get()
					->filter('Active', '1')
					->map('ID', 'Name')
					),
			TextField::create('Size', 'Größe'),
			TextField::create('IDCode', 'ID-Nummer'),
			DropDownField::create('OwnerID', 'Helfer')
				->setSource(
						StaffMember::get()
							->filter('Active', '1')
							->map('ID', 'Name')
					)
				->setEmptyString('Lager'),
			TextAreaField::create('Notes', 'Bemerkungen')
		);

		return $fields;
	}

	public function Name() {
		return $this->Type()->Name . " (".$this->Size.")";
	}

	public function onBeforeWrite() {
		if($this->Active == '0') {
			$this->OwnerID = '';
		}
	}
}