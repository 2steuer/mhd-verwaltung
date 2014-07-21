<?php

class StockPage extends Page {

}

class StockPage_Controller extends Page_Controller {

	static $allowed_actions = array('CustomSearchForm');

	public function StockClothing() {
		return Clothing::get()
			->filter(array('Active' => '1', 'OwnerID' => ''))
			->leftJoin('ClothingType', 'TypeID = ClothingType.ID')
			->sort('ClothingType.Name');
	}

	public function PrintLabelsLink() {
		$page = DataObject::get_one('GenericManagementPage', 'ModelName = \'Clothing\'');

		if($page) {
			return $page->Link('printstocklabels');
		}
		else {
			return '';
		}
	}

	public function index($request) {
		if($request->getVar('filter') == '1') {
			$context = singleton('Clothing')->getCustomSearchContext();
			$data = $context->getResults($request->getVars())
				->filter(array('Active' => '1', 'OwnerID' => ''))
				->leftJoin('ClothingType', 'TypeID = ClothingType.ID')
				->sort('ClothingType.Name');

			return $this->customise(array('StockClothing' => $data));
		}

		return array();
	}

	public function CustomSearchForm() {
		if(singleton('Clothing')->hasMethod('getCustomSearchContext')) {
			$context = singleton('Clothing')->getCustomSearchContext();
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

}