<?php

class StockPage extends Page {

}

class StockPage_Controller extends Page_Controller {

	public function StockClothing() {
		return Clothing::get()
			->filter('Active', '1')
			->leftJoin('ClothingType', 'TypeID = ClothingType.ID')
			->sort('ClothingType.Name');
	}
}