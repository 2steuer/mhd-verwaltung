<?php

class Resource extends MaterialDataObject {
	static $db = array(
			'Name' => 'Varchar',
			'Description' => 'Text',
			'Barcode' => 'Varchar',
			'Quantity' => 'Int',
			'WarningQuantity' => 'Int',
			'MinimumQuantity' => 'Int'
		);

	static $has_one = array('Category' => 'ResourceCategory',
		'Picture' => 'Image');

	static $singular_name = "Artikel";
	static $plural_name = "Artikel";

	static $field_labels = array(
			'Name' => 'Bezeichnung',
			'Description' => 'Beschreibung',
			'Barcode' => 'Barcode',
			'Quantity' => 'Bestand',
			'WarningQuantity' => 'Bestand Warnung',
			'MinimumQuantity' => 'Minimalbestand',
			'Category' => 'Kategorie'
    );

	public function getFrontendFields($params = null) {

		$fields = new FieldList(
			DropDownField::create('CategoryID', 'Kategorie')
				->setSource(ResourceCategory::get()->filter(array('Active'=>'1'))->map('ID', 'Name')),
			TextField::create('Name', 'Bezeichnung'),
			TextAreaField::create('Description', 'Beschreibung'),
			TextField::create('Barcode', 'Barcode'),
			NumericField::create('Quantity', 'Bestand'),
			NumericField::create('WarningQuantity', 'Bestand Warnung'),
			NumericField::create('MinimumQuantity', 'Mindestbestand')

		);

		return $fields;
	}

    public function validate() {
        $result = new ValidationResult();

        if(!empty($this->ID)) {
            $qry = Resource::get()->filter(array('Active'=> '1', 'Barcode'=>$this->Barcode))->exclude(array('ID' => $this->ID));
            if($qry->Count() > 0) {
                $result->error('Barcode ist bereits in Benutzung!');
            }
        }
        else {
            $qry = Resource::get()->filter(array('Active'=> '1', 'Barcode'=> $this->Barcode));
            if($qry->Count() > 0) {
                $result->error('Barcode ist bereits in Benutzung!');
            }
        }

        return $result;
    }

	public function WarningLevel() {
		if($this->Quantity > $this->MinimumQuantity && $this->Quantity > $this->WarningQuantity) {
			return 0;
		}
		else if ($this->Quantity > $this->MinimumQuantity && $this->Quantity <= $this->WarningQuantity) {
			return 1;
		}
		else {
			return 2;
		}
	}

	public function WarningClass() {
		$classes = array('qty-ok', 'qty-warning', 'qty-alert');

		return $classes[$this->WarningLevel()];
	}
}