<?php

class StockPage extends Page {

}

class StockPage_Controller extends Page_Controller {

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
}