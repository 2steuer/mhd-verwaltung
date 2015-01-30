<?php

class SupplierPage extends Page {

}

class SupplierPage_Controller extends Page_Controller {

	static $allowed_actions = array(
		'index', 
		'add', 
		'edit',
		'delete',
		'SupplierForm',
		'DeleteForm');

	public function Suppliers() {
		return Supplier::get()->filter(array('Active'=>'1'));
	}

	public function add($request) {
		Session::clear('supplier_id');

		return $this->renderWith(array('SupplierPage_form', 'Page'),
			array('Title' => 'Dienstleister hinzufügen', 'Form' => $this->SupplierForm()));

	}

	public function edit($request) {
		Session::set('supplier_id', $request->param('ID'));
		return $this->renderWith(array('SupplierPage_form', 'Page'),
			array('Title' => 'Dienstleister bearbeiten', 'Form' => $this->SupplierForm()));
	}

	public function delete($request) {
		Session::set('supplier_id', $request->param('ID'));

		return $this->renderWith(array('SupplierPage_form', 'Page'),
			array('Title' => 'Dienstleister löschen', 'Form' => $this->DeleteForm()));

	}

	function SupplierForm() {
		$id = Session::get('supplier_id');

		$sup = null;
		$edit = false;

		if(!empty($id)) {
			$sup = Supplier::get()->byID($id);
			$edit = true;
		}

		$fields = new FieldList(
			TextField::create('Name', 'Firma'),
			TextField::create('ContactName', 'Ansprechpartner'),
			TextField::create('Street', 'Straße, Hausnummer'),
			NumericField::create('PLZ', 'PLZ'),
			TextField::create('City', 'Ort'),
			TextField::create('Phone', 'Telefon'),
			TextField::create('Fax', 'Fax'),
			TextField::create('Email', 'E-Mail'),
			TextField::create('Web', 'Homepage'),
			TextField::create('CustomerNumber', 'Kundennummer')
		);

		if($edit) {
			$actions = new FieldList(
					CancelFormAction::create($this->Link(), 'Abbrechen'),
					FormAction::create('edit_supplier_action', 'Speichern')
				);
		}
		else {
			$actions = new FieldList(
					CancelFormAction::create($this->Link(), 'Abbrechen'),
					FormAction::create('new_supplier_action', 'Speichern')
				);
		}

		$validator = new RequiredFields(array(
				'Name',
				'Street',
				'PLZ',
				'City'
			)
		);

		$form = new Form($this, 'SupplierForm', $fields, $actions, $validator);

		if($edit) {
			$form->loadDataFrom($sup);
		}

		return $form;
	}

	function DeleteForm() {
		$sup = Supplier::get()->byID(Session::get('supplier_id'));

		$fields = new FieldList(
				HiddenField::create('SupplierID', '', $sup->ID),
				CheckboxField::create('DeleteCheck', 'Ja, '.$sup->Name.' löschen!')
			);

		$actions = new FieldList(
				CancelFormAction::create($this->Link(), 'Abbrechen'),
				FormAction::create('delete_supplier_action', 'Löschen')
			);

		return new Form($this, 'DeleteForm', $fields, $actions, new RequiredFields(array('DeleteCheck')));
	}

	function edit_supplier_action($data, $form) {
		$sup = Supplier::get()->byID(Session::get('supplier_id'));

		$form->saveInto($sup);

		$sup->write();
		Session::clear('supplier_id');
		return $this->redirect('index');
	}

	function new_supplier_action($data, $form) {
		$sup = new Supplier();

		$form->saveInto($sup);

		$sup->write();

		return $this->redirect('index');
	}

	function delete_supplier_action($data, $form) {
		Session::clear('supplier_id');
		$sup = Supplier::get()->byID($data["SupplierID"]);

		$sup->Active = '0';

		$sup->write();

		return $this->redirect('index');
	}
}