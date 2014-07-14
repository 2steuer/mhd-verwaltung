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
}