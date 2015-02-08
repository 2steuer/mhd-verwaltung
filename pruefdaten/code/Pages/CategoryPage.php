<?php

class CategoryPage extends Page {

}

class CategoryPage_Controller extends Page_Controller {

	static $allowed_actions = array(
		'index', 
		'add', 
		'edit',
		'delete',
		'SupplierForm',
		'DeleteForm');

	public function Categories() {
		return $this->Parent()->DeviceCategories()->filter(array('Active'=>'1'))->sort('Name');
	}

	public function add($request) {
		Session::clear('supplier_id');

		return $this->renderWith(array('SupplierPage_form', 'Page'),
			array('Title' => 'Kategorie hinzufügen', 'Form' => $this->SupplierForm()));

	}

	public function edit($request) {
		Session::set('supplier_id', $request->param('ID'));
		return $this->renderWith(array('SupplierPage_form', 'Page'),
			array('Title' => 'Kategorie bearbeiten', 'Form' => $this->SupplierForm()));
	}

	public function delete($request) {
		Session::set('supplier_id', $request->param('ID'));

		return $this->renderWith(array('SupplierPage_form', 'Page'),
			array('Title' => 'Kategorie löschen', 'Form' => $this->DeleteForm()));

	}

	function SupplierForm() {
		$id = Session::get('supplier_id');

		$sup = null;
		$edit = false;

		if(!empty($id)) {
			$sup = $this->Parent()->DeviceCategories()->byID($id);
			$edit = true;
		}

		$fields = new FieldList(
			TextField::create('Name', 'Name'),
			TextAreaField::create('Description', 'Beschreibung')
		);

		if($edit) {
			$actions = new FieldList(
					CancelFormAction::create(Session::get('back-url'), 'Abbrechen'),
					FormAction::create('edit_supplier_action', 'Speichern')
				);
		}
		else {
			$actions = new FieldList(
					CancelFormAction::create(Session::get('back-url'), 'Abbrechen'),
					FormAction::create('new_supplier_action', 'Speichern')
				);
		}

		$validator = new RequiredFields(array(
				'Name'
			)
		);

		$form = new Form($this, 'SupplierForm', $fields, $actions, $validator);

		if($edit) {
			$form->loadDataFrom($sup);
		}

		return $form;
	}

	function DeleteForm() {
		$sup = $this->Parent()->DeviceCategories()->byID(Session::get('supplier_id'));

		$fields = new FieldList(
				HiddenField::create('SupplierID', '', $sup->ID),
				CheckboxField::create('DeleteCheck', 'Ja, '.$sup->Name.' löschen!')
			);

		$actions = new FieldList(
				CancelFormAction::create(Session::get('back-url'), 'Abbrechen'),
				FormAction::create('delete_supplier_action', 'Löschen')
			);

		return new Form($this, 'DeleteForm', $fields, $actions, new RequiredFields(array('DeleteCheck')));
	}

	function edit_supplier_action($data, $form) {
		$sup = $this->Parent()->DeviceCategories()->byID(Session::get('supplier_id'));

		$form->saveInto($sup);

		$sup->write();
		Session::clear('supplier_id');
		return $this->redirect('index');
	}

	function new_supplier_action($data, $form) {
		$sup = new DeviceCategory();

		$form->saveInto($sup);

		$sup->write();

        $this->Parent()->DeviceCategories()->add($sup);

		return $this->redirect('index');
	}

	function delete_supplier_action($data, $form) {
		Session::clear('supplier_id');
		$sup = $this->Parent()->DeviceCategories()->byID($data["SupplierID"]);

		$sup->Active = '0';

		$sup->write();

		return $this->redirect('index');
	}
}