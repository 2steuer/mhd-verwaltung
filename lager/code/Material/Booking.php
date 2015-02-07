<?php

class Booking extends MaterialDataObject {

	static $db = array(
		'Comment' => 'Text',
		'Date' => 'Date',
		'Direction' => 'Enum("in, out")',
		'Booked' => 'Boolean'
	);

	static $defaults = array('Booked' => '0', 'Direction' => 'out');

	static $has_one = array('Member' => 'Member',
		'Attachment' => 'File',
		'CostCenter' => 'CostCenter',
        'HolderPage' => 'LagerParentPage'
    );

	static $has_many = array('Entries' => 'BookingEntry');

	static $singular_name = "Vorgang";
	static $plural_name = "Vorgänge";

	static $sort_field = 'Date DESC';

	public function getFrontendFields($params = null) {
		$fields = new FieldList(
			DateField::create('Date', 'Datum')
				->setConfig('showcalendar', true),
			TextAreaField::create('Comment', 'Bemerkungen'),
			MultiUploadField::create('Attachment', 'Anhang')
				->setFolderName('Uploads/bookings')
				->setAllowedMaxFileNumber(1)
				->setAllowedMaxUpload('1GB')
		);

		return $fields;
	}
}