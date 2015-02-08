<?php

class CheckTypePage extends Page {

}

class CheckTypePage_Controller extends Page_Controller {

	static $allowed_actions = array(
		'index', 
		'add', 
		'edit',
		'delete',
		'CheckTypeForm',
		'DeleteForm');

	public function CheckTypes() {
		return $this->Parent()->CheckTypes()->filter(array('Active'=>'1'));
	}

	public function add($request) {
		Session::clear('type_id');

		return $this->renderWith(array('SupplierPage_form', 'Page'),
			array('Title' => 'Prüfungstyp hinzufügen', 'Form' => $this->CheckTypeForm()));

	}

	public function edit($request) {
		Session::set('type_id', $request->param('ID'));
		return $this->renderWith(array('SupplierPage_form', 'Page'),
			array('Title' => 'Prüfungstyp bearbeiten', 'Form' => $this->CheckTypeForm()));
	}

	public function delete($request) {
		Session::set('type_id', $request->param('ID'));

		return $this->renderWith(array('SupplierPage_form', 'Page'),
			array('Title' => 'Prüfungstyp löschen', 'Form' => $this->DeleteForm()));

	}

	function CheckTypeForm() {
		$id = Session::get('type_id');

		$sup = null;
		$edit = false;

		if(!empty($id)) {
			$sup = $this->Parent()->CheckTypes()->byID($id);
			$edit = true;
		}

		$fields = new FieldList(
			TextField::create('Name', 'Bezeichnung'),
			TextAreaField::create('Description', 'Beschreibung')
		);

		if($edit) {
			$actions = new FieldList(
					CancelFormAction::create($this->Link(), 'Abbrechen'),
					FormAction::create('edit_type_action', 'Speichern')
				);
		}
		else {
			$actions = new FieldList(
					CancelFormAction::create($this->Link(), 'Abbrechen'),
					FormAction::create('new_type_action', 'Erstellen')
				);
		}

		$validator = new RequiredFields(array(
				'Name'
			)
		);

		$form = new Form($this, 'CheckTypeForm', $fields, $actions, $validator);

		if($edit) {
			$form->loadDataFrom($sup);
		}

		return $form;
	}

	function DeleteForm() {
		$sup = $this->Parent()->CheckTypes()->byID(Session::get('type_id'));

		$fields = new FieldList(
				HiddenField::create('CheckTypeID', '', $sup->ID),
				CheckboxField::create('DeleteCheck', 'Ja, '.$sup->Name.' löschen!')
			);

		$actions = new FieldList(
				CancelFormAction::create($this->Link(), 'Abbrechen'),
				FormAction::create('delete_type_action', 'Löschen')
			);

		return new Form($this, 'DeleteForm', $fields, $actions, new RequiredFields(array('DeleteCheck')));
	}

	function edit_type_action($data, $form) {
		$sup = $this->Parent()->CheckTypes()->byID(Session::get('type_id'));

		$form->saveInto($sup);

		$sup->write();
		Session::clear('type_id');
		return $this->redirect('index');
	}

	function new_type_action($data, $form) {
		$sup = new CheckType();

		$form->saveInto($sup);

		$sup->write();

        $this->Parent()->CheckTypes()->add($sup);

		return $this->redirect('index');
	}

	function delete_type_action($data, $form) {
		Session::clear('type_id');
		$sup = $this->Parent()->CheckTypes()->byID($data["CheckTypeID"]);

		$sup->Active = '0';

		$sup->write();

		return $this->redirect('index');
	}
}