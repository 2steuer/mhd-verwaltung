<?php
class Device extends DataObject {
	public static $db = array(
			'Name' => 'Text',
			'Description' => 'Text',
			'Barcode' => 'Varchar',
			'Serial' => 'Varchar',
			'Active' => 'Boolean'
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
	public static $defaults = array('Active' => '1');

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->removeByName('Active');
		$fields->replaceField("Name", new TextField('Name'));

		return $fields;
	}
}