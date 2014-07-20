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

	static $join_table = 'ClothingType';
	static $join_field = 'TypeID';

	static $sort_field = 'ClothingType.Name';

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
							->sort('Name')
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
		parent::onBeforeWrite();
		
		if($this->Active == '0') {
			$this->OwnerID = '';
		}
	}

	public function validate() {
		$val = parent::validate();

		$qry = Clothing::get();

		$filter = array();
		if(strtolower($this->IDCode) != "neu")
		{
			$filter['IDCode'] = $this->IDCode;
			$qry->filter($filter);

			if(!empty($this->ID)) {
				$qry->exclude('ID', $this->ID);
			}

			if($qry->Count() > 0) {
				$val->error('Ein Kleidungsstück mit dieser ID existiert bereits!');
			}
		}		

		return $val;
	}
}