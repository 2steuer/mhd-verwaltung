<?php

class Booking extends MaterialDataObject {

	static $db = array(
		'Comment' => 'Text',
		'BookingDate' => 'Date',
		'CreationDate' => 'Date',
		'Direction' => 'Enum("in, out")',
		'Booked' => 'Boolean'
	);

	static $has_one = array('Member' => 'Member',
		'Attachment' => 'File');

	static $has_many = array('Entries' => 'BookingEntry');

	static $singular_name = "Vorgang";
	static $plural_name = "Vorgänge";
}