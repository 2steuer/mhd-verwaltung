<?php
class Device extends MaterialDataObject {
	public static $db = array(
			'Name' => 'Text',
			'Description' => 'Text',
			'Barcode' => 'Varchar',
			'Serial' => 'Varchar'
		);

	static $has_many = array(
			'Checks' => 'Check'
		);

	static $has_one = array(
			'Category' => 'DeviceCategory'
		);
	
	
	static $singular_name = "Gerät";
	static $plural_name = "Geräte";

	public static $summary_fields = array(
		'Name' => 'Bezeichnung');

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->removeByName('Active');
		$fields->replaceField("Name", new TextField('Name'));

		return $fields;
	}

	public function onBeforeWrite() {
		parent::onBeforeWrite();
	}
}