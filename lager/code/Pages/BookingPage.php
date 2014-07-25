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
            'view',
            'addentry',
            'deleteentry',
            'updateCounts',
			'BookingForm',
            'NewEntryForm',
            'QuickEntryForm',
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
            'Form' => $form,
            'Title' => 'Vorgang löschen'
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
     * Adding Entry to Bookings
     */
    public function addentry($request) {
        $booking = $request->param('ID');
        Session::set('booking_id', $booking);

        return $this->renderWith(array('BookingPage_form', 'BookingPage', 'Page'),
            array('Form' => $this->NewEntryForm(),
            'Title' => 'Artikel hinzufügen'));
    }

    public function doAddEntry($data, $form) {
        $booking = Booking::get()->byID(Session::get('booking_id'));

        if($entry = $booking->Entries()->find('ResourceID', $data['ResourceID'])) {
            $entry->Count += $data['Count'];
            $entry->write();
        }
        else {
            $entry = new BookingEntry();
            $form->saveInto($entry);
            $entry->write();
        }
        return $this->redirect($this->Link().'edit/'.Session::get('booking_id'));
    }
    /*
     * Deleting Entries
     */

    public function deleteentry($request) {
        $entryID = $request->param('ID');

        $entry = BookingEntry::get()->byID($entryID);

        $bookingID = $entry->BookingID;
        $entry->Active = '0';
        $entry->write();

        Session::set('resource_message', $entry->Resource()->Name.' entfernt.');

        return $this->redirect($this->Link().'edit/'.$bookingID);
    }

    /*
     * Updating Counts
     */
    public function updateCounts($request) {
        $counts = $request->postVar('counts');
        $booking = $request->param('ID');

        foreach($counts as $id=>$count) {
            $entry = BookingEntry::get()->byID($id);
            if($entry->BookingID != $booking) {
                return $this->httpError(500, 'Fehler, Angriff erkannt!');
            }
            $entry->Count = $count;
            $entry->write();
        }

        Session::set('resource_message', 'Artikelmengen gespeichert.');

        return $this->redirect($this->Link().'edit/'.$booking);
    }

    /*
     * Quick Add Entry
     */
    public function quickAdd($data, $form) {
        $booking = Booking::get()->byID($data['BookingID']);

        $resource = Resource::get()->filter(array('Active' => '1', 'Barcode' => $data['Barcode']))->First();

        if($resource) {
            if($entry = $booking->Entries()->find('ResourceID', $resource->ID)) {
                $entry->Count++;
                $entry->write();
            }
            else {
                $entry = new BookingEntry();
                $entry->ResourceID = $resource->ID;
                $entry->Count = 1;

                $booking->Entries()->add($entry);

                $entry->write();
            }

            $booking->write();

            Session::set('resource_message', 'Artikel hinzugefügt.');
            return $this->redirect($this->Link().'edit/'.$booking->ID);
        }
        else {
            Session::set('resource_message', 'Artikel nicht gefunden!');
            return $this->redirect($this->Link().'edit/'.$booking->ID);
        }
    }

	/*
	 * Forms
	*/
	public function BookingForm() {
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

    public function NewEntryForm() {
        $fields = new FieldList(
            HiddenField::create('BookingID')
                ->setValue(Session::get('booking_id')),
            DropDownField::create('ResourceID', 'Artikel')
                ->setSource(Resource::get()
                    ->filter('Active', '1')
                    ->sort('Name')
                    ->map('ID', 'Name')),
            NumericField::create('Count', 'Anzahl')
        );

        $booking_id = Session::get('booking_id');

        $actions = new FieldList(
            CancelFormAction::create($this->Link().'edit/'.$booking_id, 'Abbrechen'),
            FormAction::create('doAddEntry', 'Hinzufügen')
        );

        return new Form($this, 'NewEntryForm', $fields, $actions);
    }

    public function QuickEntryForm() {
        $fields = new FieldList(
            TextField::create('Barcode', 'Barcode'),
            HiddenField::create('BookingID')
                ->setValue(Session::get('booking_id'))
        );

        $actions = new FieldList(
            FormAction::create('quickAdd', 'Hinzufügen')
        );

        return new Form($this, 'QuickEntryForm', $fields, $actions);
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

    public function ResourceMessage() {
        $msg = Session::get('resource_message');
        Session::clear('resource_message');

        return $msg;
    }
}