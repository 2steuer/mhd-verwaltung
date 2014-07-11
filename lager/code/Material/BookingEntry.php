<?php

class BookingEntry extends MaterialDataObject {
	static $db = array('Count' => 'Int');

	static $has_one = array('Resource' => 'Resource');
}