<?php

class DevicePage extends Page {

}

class DevicePage_Controller extends Page_Controller {

	static $allowed_actions = array(
		'detail', 
		'index', 
		'edit', 
		'delete', 
		'addcheck',
		'editcheck', 
		'deletecheck',
		'addcheckrecord',
		'deletecheckrecord',
		'adddevice', 
		'DeviceForm',
		'DeleteForm',
		'NewCheckForm',
		'DeleteCheckForm',
		'NewCheckRecordForm',
		'DeleteCheckRecordForm',
		'BarcodeSearchForm');

	public function Devices() {
		$dev = $this->Parent()->Devices()->filter(array('Active' => '1'));

		return $dev;
	}

	public function Categories() {

		return $this->Parent()->DeviceCategories()->filter(array('Active' => '1'))->sort('Name');
	}

	public function init() {
		parent::init();
	}

	public function index($request) {
		return $this->render();
	}

	public function detail($request) {
		$dev = $this->Parent()->Devices()->byID($request->param('ID'));

		if(!is_object($dev))
			return $this->httpError(404, 'Device not found.');

		return $this->render(array('Title' => $dev->Name, 'Device'=>$dev));
	}

	public function addcheckrecord($request) {
		$id = $request->param('ID');
		Session::set('device_id', $id);

		Session::set('check_id', $request->param('OtherID'));

		return $this->renderWith(array('DevicePage_form', 'DevicePage', 'Page'), 
			array('Title'=>'Prüfung eintragen', 'Form'=>$this->NewCheckRecordForm()));
	}

	public function deletecheckrecord($request) {
		$id = $request->param('ID');
		Session::set('record_id', $id);

		return $this->renderWith(array('DevicePage_form', 'DevicePage', 'Page'),
			array('Title'=>'Eintrag löschen', 'Form'=>$this->DeleteCheckRecordForm()));


	}

	public function addcheck($request) {
		Session::set('device_id', $request->param('ID'));
		Session::clear('check_id');

		return $this->renderWith(array('DevicePage_form', 'DevicePage', 'Page'),
			array('Title'=>'Prüfung eintragen', 'Form'=>$this->NewCheckForm()));
	}

	public function edit($request) {
		$id = $request->param('ID');
		Session::set('device_id', $id);

		return $this->renderWith(array('DevicePage_edit', 'DevicePage', 'Page'), 
			array('Title'=>'Gerät bearbeiten', 'Device'=>$this->Parent()->Devices()->byID($id), 'Form'=>$this->DeviceForm()));
	}

	public function editcheck($request) {
		Session::set('check_id', $request->param('ID'));

		return $this->renderWith(array('DevicePage_form', 'DevicePage', 'Page'),
			array('Title'=>'Prüfung bearbeiten', 'Form'=>$this->NewCheckForm()));
	}

	public function deletecheck($request) {
		Session::set('check_id', $request->param('ID'));

		return $this->renderWith(array('DevicePage_form', 'DevicePage', 'Page'),
			array('Title'=>'Prüfung löschen', 'Form'=>$this->DeleteCheckForm()));
	}

	public function delete($request) {
		Session::set('device_id', $request->param('ID'));

		return $this->renderWith(array('DevicePage_form', 'DevicePage', 'Page'),
			array('Title' => 'Gerät löschen', 'Form'=>$this->DeleteForm()));
	} 

	public function adddevice($request) {
		Session::clear('device_id');
		Session::set('category_id', $request->param('ID'));
		return $this->renderWith(array('DevicePage_form', 'DevicePage', 'Page'), 
			array('Title'=>'Gerät hinzufügen', 'Form'=>$this->DeviceForm()));
	}

	/*
	** New Check Forms / Actions
	*/

	function NewCheckRecordForm() {
		$member = Member::currentUser();
		$device = $this->Parent()->Devices()->byID(Session::get('device_id'));

		$fields = new FieldList(
			HiddenField::create('MemberID', '', $member->ID),
			ReadonlyField::create('dev_name', 'Gerät', $device->Name),
			ReadonlyField::create('usr_name', 'Benutzer', $member->Surname.', '.$member->FirstName),
			DropDownField::create('CheckID', 'Prüfungstyp')
				->setSource($device->Checks()->map('ID', 'TypeName'))
				->setValue(Session::get('check_id')),
			DateField::create('Date', 'Datum der Prüfung')
				->setConfig('showcalendar', true),
			DateField::create('NextCheckDate', 'Nächste Prüfung')
				->setConfig('showcalendar', true),
			TextAreaField::create('Comment', 'Bemerkungen'),
			MultiUploadField::create('CheckDocument', 'Prüfbericht hochladen')
				->setFolderName('Uploads/dev_'.$device->ID)
				->setAllowedMaxFileNumber(1)
				->setAllowedMaxUpload('1GB')
			);

		$actions = new FieldList(
			CancelFormAction::create(Session::get('back-url'), 'Abbrechen'),
			FormAction::create('add_checkrecord_action', 'Eintragen')
		);

		return new Form($this, 'NewCheckRecordForm', $fields, $actions, new RequiredFields(
			array('Date', 'NextCheckDate')
			)
		);
	}

	function DeleteCheckRecordForm() {
		$record = CheckRecord::get()->byID(Session::get('record_id'));

		$fields = new FieldList(
				HiddenField::create('RecordID', '', $record->ID),
				CheckboxField::create('DeleteCheck', 'Ja, den Eintrag aus Gerät entfernen!')
			);

		$actions = new FieldList(
				CancelFormAction::create(Session::get('back-url'), 'Abbrechen'),
				FormAction::create('delete_checkrecord_action', 'Löschen')
			);

		return new Form($this, 'DeleteCheckRecordForm', $fields, $actions, new RequiredFields(array('DeleteCheck')));		
	}

	function add_checkrecord_action($data, $form) {
		$newrec = new CheckRecord();
		$form->saveInto($newrec);
		$newrec->write();

		$check = Check::get()->byID($data["CheckID"]);
		$check->CheckRecords()->add($newrec);
		$check->NextCheck = $data["NextCheckDate"];
		$check->write();

		$this->resetNotificationNotes($check->ID);


		return $this->redirect($this->Link().'detail/'.$check->DeviceID);
	}

	function delete_checkrecord_action($data, $form) {
		$record = CheckRecord::get()->byID($data['RecordID']);
		$record->Active = '0';
		$record->write();

		return $this->redirect($this->Link()."detail/".$record->Check()->DeviceID);
	}

	function NewCheckForm() {
		$check_id = Session::get('check_id');
		$check = null;
		$edit = false;

		if(!empty($check_id)) {
			$check = Check::get()->byID($check_id);
			$edit = true;
			$device = $this->Parent()->Devices()->byID($check->DeviceID);

		}
		else {
			$device = $this->Parent()->Devices()->byID(Session::get('device_id'));
		}

		$fields = new FieldList(
			HiddenField::create('DeviceID', '', $device->ID),
			ReadonlyField::create('dev_name', 'Gerät', $device->Name),
			DropDownField::create('TypeID', 'Prüfungstyp')
				->setSource(CheckType::get()->filter(array('Active'=>'1'))->map('ID', 'Name')),
			DropDownField::create('SupplierID', 'Dienstleister')
				->setSource(Supplier::get()->filter(array('Active'=>'1'))->map('ID', 'DropDownName'))
				->setEmptyString('Keiner'),
			DateField::create('NextCheck', 'Nächste Prüfung')
				->setConfig('showcalendar', true),
			TextAreaField::create('Comment', 'Bemerkungen')
		);

		if($edit) {
			$actions = new FieldList(
				CancelFormAction::create(Session::get('back-url'), 'Abbrechen'),
				FormAction::create('edit_check_action', 'Speichern')
			);
		}
		else {
			$actions = new FieldList(
			CancelFormAction::create($this->Link().'edit/'.$device->ID, 'Abbrechen'),
			FormAction::create('add_check_action', 'Hinzufügen')
			);
		}

		$required = new RequiredFields(array('NextCheck'));

		$form = new Form($this, 'NewCheckForm', $fields, $actions, $required);

		if($edit) {
			$form->loadDataFrom($check);
		}

		return $form;
	}


	function DeleteCheckForm() {
		$dev = Check::get()->byID(Session::get('check_id'));

		$fields = new FieldList(
				HiddenField::create('CheckID', '', $dev->ID),
				CheckboxField::create('DeleteCheck', 'Ja, '.$dev->Type()->Name.' als Prüfung aus Gerät entfernen!')
			);

		$actions = new FieldList(
				CancelFormAction::create(Session::get('back-url'), 'Abbrechen'),
				FormAction::create('delete_check_action', 'Löschen')
			);

		return new Form($this, 'DeleteCheckForm', $fields, $actions, new RequiredFields(array('DeleteCheck')));

	}

	function add_check_action($data, $form) {
		$check = new Check();
		$form->saveInto($check);
		$check->write();

		$dev = $this->Parent()->Devices()->byID($check->DeviceID);
		$dev->Checks()->add($check);
		$dev->write();

        return $this->redirect($this->Link().'edit/'.$check->DeviceID);
	}

	function edit_check_action($data, $form) {
		$check = Check::get()->byID(Session::get('check_id'));
		$form->saveInto($check);
		$check->write();

		$this->resetNotificationNotes($check->ID);

		return $this->redirect($this->Link().'edit/'.$check->DeviceID);
	}

	function delete_check_action($data, $form) {
		$check = Check::get()->byID($data["CheckID"]);
		$check->Active = '0';
		$check->write();

		$device = $this->Parent()->Devices()->byID($check->DeviceID);
		$device->Checks()->remove($check);
		$device->write();

		return $this->redirect($this->Link().'edit/'.$device->ID);
	}

	/*
	** Device CRUD Forms and Actions
	*/

	function DeleteForm() {
		$dev = $this->Parent()->Devices()->byID(Session::get('device_id'));

		$fields = new FieldList(
				HiddenField::create('DeviceID', '', $dev->ID),
				CheckboxField::create('DeleteCheck', 'Ja, '.$dev->Name.' löschen!')
			);

		$actions = new FieldList(
				CancelFormAction::create(Session::get('back-url'), 'Abbrechen'),
				FormAction::create('delete_device_action', 'Löschen')
			);

		return new Form($this, 'DeleteForm', $fields, $actions, new RequiredFields(array('DeleteCheck')));
	}

	function DeviceForm() {
		$id = Session::get('device_id');
		$dev = $this->Parent()->Devices()->byID($id);
		$edit = false;

		$fields = new FieldList(
			DropDownField::create('CategoryID', 'Kategorie')
				->setSource(DeviceCategory::get()->filter(array('Active' => '1'))->map('ID', 'Name'))
				->setValue(Session::get('category_id')), 
			TextField::create("Name")->setTitle('Gerätebezeichnung'),
			TextAreaField::create("Description")->setTitle('Bemerkungen'),
			TextField::create('Serial', 'Seriennummer'),
			TextField::create('Barcode', 'Barcode')
		);

		if(is_object($dev)) {
			$actions = new FieldList(
				CancelFormAction::create(Session::get('back-url'), 'Zurück'),
				FormAction::create('edit_device_action')->setTitle('Speichern')
				);

			$edit = true;
		}
		else {
			$actions = new FieldList(
					CancelFormAction::create(Session::get('back-url'), 'Zurück'),
					FormAction::create('add_device_action')->setTitle('Erstellen')
				);
		}

		$form = new Form($this, 'DeviceForm', $fields, $actions, new RequiredFields(array('Name', 'NextCheck')));

		if($edit) {
			$form->loadDataFrom($dev);
		}

		return $form;		
	}

	public function add_device_action($data, Form $form) {
		$dev = new Device();

		$form->saveInto($dev);

		$dev->write();

        $this->Parent()->Devices()->add($dev);

		Session::clear('category_id');

		return $this->redirect($this->Link().'edit/'.$dev->ID);
	}

	public function edit_device_action($data, Form $form) {
		$dev = $this->Parent()->Devices()->byID(Session::get('device_id'));
		Session::clear('device_id');
		$form->saveInto($dev);

		$dev->write();


		return $this->redirect('index');
	}

	function delete_device_action($data, $form) {
		Session::clear('device_id');
		$dev = $this->Parent()->Devices()->byID($data['DeviceID']);

		$dev->Active = '0';

		$dev->write();

		return $this->redirect('index');
	}

	function resetNotificationNotes($checkID) {
		$notes = NotificationNote::get()->filter(array('CheckID' => $checkID));

		foreach($notes as $note) {
			$note->delete();
		}
	}

	/*
	** Barcode search Form
	*/
	public function BarcodeSearchForm() {
		$fields = new FieldList(TextField::create('Barcode'));

		$actions = new FieldList(FormAction::create('barcode_search_action', 'Suchen'));
	
		return new Form($this, 'BarcodeSearchForm', $fields, $actions);
	}

	public function barcode_search_action($data, $form) {
		$barcode = $data['Barcode'];

		$result = $this->Parent()->Devices()->filter(array('Active' => '1', 'Barcode'=>$barcode));

		if($result->count() == 1) {
			$dev = $result[0];

			return $this->redirect($this->Link()."detail/".$dev->ID);
		}
		else {
			return $this->redirect('index');
		}

	}
}