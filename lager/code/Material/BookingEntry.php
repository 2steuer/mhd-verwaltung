<?php

class BookingEntry extends MaterialDataObject {
	static $db = array('Count' => 'Int');

	static $has_one = array('Resource' => 'Resource', 'Booking' => 'Booking');

    public function onBeforeWrite() {
        parent::onBeforeWrite();
        if($this->Active == '0') {
            $this->BookingID = '';
        }
    }
}