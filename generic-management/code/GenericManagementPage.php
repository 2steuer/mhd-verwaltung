<?php

class GenericManagementPage extends Page {
	static $db = array(
			'ModelName' => 'Varchar',
			'ShowView' => 'Boolean',
			'ShowEdit' => 'Boolean',
			'ShowDelete' => 'Boolean',
			'ShowAdd' => 'Boolean'
			);

	public function getCMSFields() {
		$classes = ClassInfo::subclassesFor('MaterialDataObject');
		asort($classes);
		$map = array_combine($classes, $classes);


		$fields = parent::getCMSFields();

		$fields->addFieldsToTab('Root.Management',array(
			DropDownField::create('ModelName', 'Zu verwaltende Klasse')
					->setSource($map),
			CheckBoxField::create('ShowAdd', 'Hinzufügen'),
			CheckBoxField::create('ShowView', 'Details anzeigen'),
			CheckBoxField::create('ShowEdit', 'Editieren'),
			CheckBoxField::create('ShowDelete', 'Löschen'),
			)
			);

		return $fields;
	}
}

class GenericManagementPage_Controller extends Page_Controller {

	static $allowed_actions = array(
		'index',
		'view',
		'add',
		'delete',
		'edit',
		'print',
		'RecordForm',
		'DeleteForm'
	);

	public function init() {
		parent::init();

		if(!$this->ModelName || !(singleton($this->ModelName) instanceof MaterialDataObject)) {
			return $this->httpError(500, 'Interner Fehler. ModelName nicht korrekt.');
		}
	}

	/*
	 * Get all active Records
	*/

	public function ActiveRecords() {
		$sing = singleton($this->ModelName);

		$sort_field = $sing->sort_field();

		$objects = DataObject::get($this->ModelName)->filter(array('Active' => '1'));

		if($tbl = $sing->join_table()) {
			$objects->leftJoin($tbl, $sing->join_field()." = ".$tbl.".ID");
		}

		if($sort_field) {
			$objects = $objects->sort(array($sort_field => 'ASC'));
		}

		return $objects;
	}

	/*
	** Displaying the List of the Records
	*/

	public function index($request) {
		return $this->renderWith(array($this->ModelName.'_list', 'GenericManagement_list', 'Page'));
	}


	/*
	** Adding Record
	*/
	public function add($request) {
		Session::set('form_action', 'add');

		return $this->renderWith(array($this->ModelName.'_add', 'GenericManagement_form', 'Page'), array('Form' => $this->RecordForm()));
	}


	function doAdd($data, $form) {
		$record = new $this->ModelName();
		$form->saveInto($record);
		$record->write();

		return $this->redirect('index');
	}

	/*
	** Editing 
	*/

	public function edit($request) {
		Session::set('form_action', 'edit');

		$id = $request->param('ID');

		if(!$id) {
			return $this->httpError(404, 'ID failure');
		}

		Session::set('record_id', $id);
	
		return $this->renderWith(
				array(
					$this->ModelName.'_edit',
					'GenericManagement_form',
					'Page'
				),
				array(
					'Form'=>$this->RecordForm()
				)
			);
	}

	function doEdit($data, $form) {
		$record = DataObject::get($this->ModelName)->byID(Session::get('record_id'));
		$form->saveInto($record);
		$record->write();

		return $this->redirect('index');
	}

	/*
	** Deleting
	*/

	public function delete($request) {
		$id = $request->param('ID');

		if(!$id) {
			return $this->httpError(404, 'ID failure');
		}

		Session::set('record_id', $id);


		return $this->renderWith(array($this->ModelName.'_delete', 'GenericManagement_form', 'Page'), array('Form' => $this->DeleteForm()));
	}

	function doDelete($data, $form) {
		$record = DataObject::get($this->ModelName)->byID(Session::get('record_id'));
		$record->Active = '0';

		$record->write();

		return $this->redirect('index');
	}

	/*
	 * View
	*/
	public function view($request) {
		$id = $request->param('ID');

		$record = DataObject::get($this->ModelName)->byID($id);

		if(!$record) {
			return $this->httpError(404, 'Object not found.');
		}

		if($record->hasMethod('Name')) {
			$name = $record->Name();
			print("Juhu");
		}
		else {
			$name = $record->Name;
		}

		return $this->renderWith(array($this->ModelName.'_view', 'GenericManagement_view', 'Page'), array('Record' => $record, 'Title'=>'Details: '.$name));
	}

	/*
	** Forms
	*/

	public function RecordForm() {
		$fields = null;
		$record = null;

		$action = Session::get('form_action');

		$submitField = null;

		if($action == 'add') {
			$fields = singleton($this->ModelName)->getFrontendFields();

			$submitField = FormAction::create('doAdd', 'Hinzufügen');
		}
		else if($action == 'edit') {
			$record = DataObject::get($this->ModelName)->byID(Session::get('record_id'));
			$fields = $record->getFrontendFields();

			$submitField = FormAction::create('doEdit', 'Speichern');
		}


		$actions = new FieldList(
				CancelFormAction::create($this->Link(), 'Abbrechen'),
				$submitField
			);

		$form = new Form($this, 'RecordForm', $fields, $actions);

		if($action == 'edit')  {
			$form->loadDataFrom($record);
		}

		return new Form($this, 'RecordForm', $fields, $actions);
	}

	public function DeleteForm() {
		$record = DataObject::get($this->ModelName)->byID(Session::get('record_id'));

		$fields = new FieldList(
				CheckBoxField::create('DeleteCheck', 'Ja, '.$record->Name.' löschen.')
			);

		$actions = new FieldList(
				CancelFormAction::create($this->Link(), 'Abbrechen'),
				FormAction::create('doDelete', 'Löschen')
			);

		return new Form($this, 'DeleteForm', $fields, $actions, new RequiredFields(array('DeleteCheck')));		
	}

	/*
	 * Helper Functions
	*/

	public function SingularName() {
		return singleton($this->ModelName)->singular_name();
	}

	public function PluralName() {
		return singleton($this->ModelName)->plural_name();
	}
}