<?php

class BookingPage extends Page{

}

class BookingPage_Controller extends Page_Controller {
	
	static $allowed_actions = array(
			'index',
			'newbooking',
			'editbooking'
		);

	/*
	 * Template Functions
	*/
	public function BookedBookings() {
		return Booking::get()->filter(array('Active' => '1', 
			'Booked' => '1'));
	}

	public function OpenBookings() {
		return Booking::get()->filter(array('Active' => '1', 
			'Booked' => '0'));
	}
}