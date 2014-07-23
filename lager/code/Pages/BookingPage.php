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
            'addentry',
            'deleteentry',
			'BookingForm',
            'EntryForm',
            'DeleteForm'
		);

	/*
	 * Creating a new Booking
	*/
	public function newbooking($request) {
		Session::set('booking_action', 'new');
		return $this->renderWith(
				array('BookingPage_form', 'BookingPage', 'Page'),
				array('Title' => 'Vorgang erstellen',
					'Form' => $this->BookingForm())
			);
	}

	public function doCreate($data, Form $form) {
		$record = new Booking();
		$form->saveInto($record);
		$record->MemberID = Member::currentUserID();
		$record->write();

		return $this->redirect($this->Link().'edit/'.$record->ID);
	}

	/*
	 * Editing Bookings
	*/
	public function edit($request) {
		$id = $request->param('ID');
		$book = Booking::get()->byID($id);

		Session::set('booking_action', 'edit');
		Session::set('booking_id', $id);

		$form = $this->BookingForm();

		return $this->customise(array('Form' => $form, 'Booking' => $book, 'Title'=>'Vorgang bearbeiten'));
	}

	public function doEdit($data, $form) {
		$id = Session::get('booking_id');
		$book = Booking::get()->byID($id);
		$form->saveInto($book);
		$book->write();

		return $this->redirectBack();
	}

    /*
     * Deleting Bookings
     */
    public function delete($request) {
        $id = $request->param('ID');
        Session::set('booking_id', $id);

        $form = $this->DeleteForm();

        return $this->renderWith(array('BookingPage_form', 'BookingPage', 'Page'), array(
            'Form' => $form
        ));
    }

    public function doDelete($data, $form) {
        $id = Session::get('booking_id');

        $book = Booking::get()->byID($id);
        $book->Active = '0';
        $book->write();

        Session::clear('booking_id');

        return $this->redirect('index');
    }

	/*
	 * Forms
	*/
	protected function BookingForm() {
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

		$action = Session::get('booking_action');

		if($action == 'new') {
			$submitAction = FormAction::create('doCreate', 'Erstellen');
		}
		else if($action == 'edit') {
			$submitAction = FormAction::create('doEdit', 'Speichern');
		}

		$actions = new FieldList(
				CancelFormAction::create($this->Link(), 'Abbrechen'),
				$submitAction
			);

		$form = new Form($this, 'BookingForm', $fields, $actions);

		if($action == 'edit') {
			$id = Session::get('booking_id');
			$book = Booking::get()->byID($id);
			$form->loadDataFrom($book);
		}

		return $form;
	}

    public function DeleteForm() {
        $id = Session::get('booking_id');
        $fields = new FieldList(
            CheckBoxField::create('confirmDelete', 'Ja, den Vorgang löschen.')
        );
        $actions = new FieldList(
            CancelFormAction::create($this->Link(), 'Abbrechen'),
            FormAction::create('doDelete', 'Löschen')
        );

        $required = new RequiredFields(array('confirmDelete'));

        return new Form($this, 'DeleteForm', $fields, $actions, $required);
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