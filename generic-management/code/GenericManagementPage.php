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
        'deleteall' => 'ADMIN',
		'edit',
		'print',
		'RecordForm',
		'DeleteForm',
		'QuickSearchForm',
		'CustomSearchForm'
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

		$tbl = $sing->join_table();
		$sort_field = $sing->sort_field();

		if($tbl != '') {
			$objects = DataObject::get($this->ModelName)
				->filter('Active', '1')
				->leftJoin($tbl, $sing->join_field()." = ".$tbl.".ID")
				->sort($sort_field);
		}
		else {
			$objects = DataObject::get($this->ModelName)
				->filter('Active', '1')
				->sort($sort_field);
		}
		return $objects;
	}

	/*
	** Displaying the List of the Records
	*/

	public function index($request) {
		if($request->getVar('filter') == '1') {
			$context = singleton($this->ModelName)->getCustomSearchContext();
			$results = $context->getResults($request->getVars())->filter('Active', '1');

			return $this->customise(array('ActiveRecords' => $results))->renderWith(array($this->ModelName.'_list', 'GenericManagement_list', 'Page'));
		}

		return $this->renderWith(array($this->ModelName.'_list', 'GenericManagement_list', 'Page'));
	}


	/*
	** Adding Record
	*/
	public function add($request) {
		Session::set('form_action', 'add');

		return $this->renderWith(array($this->ModelName.'_add',$this->ModelName.'_form', 'GenericManagement_form', 'Page'), array('Form' => $this->RecordForm()));
	}


	function doAdd($data, $form) {
		$record = new $this->ModelName();
		$form->saveInto($record);

		$val = $record->validate();

		if(!$val->valid()) {
			Session::set('form_error', $val->message());
			Session::set('form_data', $data);
			return $this->redirect('add');
		}

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
                    $this->ModelName.'_form',
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

		$val = $record->validate();

		if(!$val->valid()) {
			Session::set('form_error', $val->starredList());
			Session::set('form_data', $data);

			return $this->redirect($this->Link().'edit/'.$record->ID);
		}


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
     * Delete all
     */
    public function deleteall($request) {
        $records = DataObject::get($this->ModelName);

        foreach($records as $record) {
            print("Deleting ".$record->ID."...<br />");
            $record->delete();

        }
        print("Done.");
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

        $dat = Session::get('form_data');

		if($dat)
		{
			$form->loadDataFrom($dat);
			Session::clear('form_data');
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
	 *	QuickSearchForm
	*/

	public function QuickSearchForm() {
		$fields = new FieldList(TextField::create('SearchValue', singleton($this->ModelName)->quick_search_label()));
		$actions = new FieldList(FormAction::create('doQuickSearch', 'Suche'));

		return new Form($this, 'QuickSearchForm', $fields, $actions);
	}

	public function doQuickSearch($data, $form) {

		$value = $data['SearchValue'];

		$result = DataObject::get($this->ModelName)
				->filter(array(
						singleton($this->ModelName)->quick_search_field() => $value
					));
		
		if($result->Count() == 1) {
			return $this->redirect($this->Link().'view/'.$result[0]->ID);
		}
		else {
			return $this->redirectBack();
		}
	}

	/*
	** Searching
	*/

	public function CustomSearchForm() {
		if(singleton($this->ModelName)->hasMethod('getCustomSearchContext')) {
			$context = singleton($this->ModelName)->getCustomSearchContext();
			$fields = $context->getSearchFields();

			$actions = new FieldList(FormAction::create('doSearch', 'Suchen'));

			$form = new Form($this, 'CustomSearchForm', $fields, $actions);
			$form->disableSecurityToken();
			return $form;
		}
	}

	public function doSearch($data, $form) {
		$data['filter'] = 1;
		$s_data = $form->getData();
		$s_data['filter'] = 1;

		return $this->redirect($this->Link().'index?'.http_build_query($s_data));
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

	public function QuickSearchEnabled() {
		return (singleton($this->ModelName)->quick_search_field() != '');
	}

	public function GenericPageLink($modelName, $action='') {
		$page = DataObject::get_one('GenericManagementPage', 'ModelName = \''.$modelName."'");

		if($page) {
			return $page->Link($action);
		}
		else {
			return '';
		}
	}

	public function FormError() {
		$err = Session::get('form_error');
		Session::clear('form_error');
		return $err;
	}
}