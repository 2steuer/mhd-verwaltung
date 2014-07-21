<?php

class BookingPage extends Page{

}

class BookingPage_Controller extends Page_Controller {
	
	static $allowed_actions = array(
			'index',
			'newbooking',
			'edit',
			'confirm',
			'delete',
			'NewBookingForm'
		);

	/*
	 * Creating a new Booking
	*/
	public function newbooking($request) {
		return $this->renderWith(
				array('BookingPage_form', 'BookingPage', 'Page'),
				array('Title' => 'Vorgang erstellen',
					'Form' => $this->NewBookingForm())
			);
	}

	public function NewBookingForm() {
		$fields = new FieldList(
			DropDownField::create('Direction', 'Buchungsrichtung')
				->setSource(array('in' => 'Wareneingang', 'out' => 'Warenausgang'))
				->setValue('out'),
			DropDownField::create('CostCenterID', 'Kostenstelle')
				->setSource(CostCenter::get()->filter('Active', '1')->map('ID', 'Name')),
			DateField::create('Date', 'Datum des Vorgangs')
				->setConfig('showcalendar', true)
				->setValue(date('d.m.Y')),
			TextAreaField::create('Comment', 'Bemerkungen')
		);

		$actions = new FieldList(
				CancelFormAction::create($this->Link(), 'Abbrechen'),
				FormAction::create('doCreate', 'Erstellen')
			);

		return new Form($this, 'NewBookingForm', $fields, $actions);
	}

	public function doCreate($data, $form) {
		$record = new Booking();
		$form->saveInto($record);
		$record->MemberID = Member::currentUserID();
		$record->write();

		return $this->redirect($this->Link().'edit/'.$record->ID);
	}

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