<?php

class CheckRecord extends DataObject {
	public static $db = array(
			'Date' => 'Date',
			'Comment'=>'Text',
			'Active'=>'Boolean'
		);

	static $defaults = array('Active'=>'1');

	public static $has_one = array('Check' => 'Check',
		'CheckDocument' => 'File',
		'Member'=>'Member');

	static $summary_fields = array(
		'Device.Name' => 'Gerät',
		'Date.Nice' => 'Datum',
		'Comment' => 'Bemerkung',
		);

	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName('Active');
		$fields->dataFieldByName('Date')->setConfig('showcalendar', true);

		return $fields;
	}
}