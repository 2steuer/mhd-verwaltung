<?php

class Resource extends MaterialDataObject {
	static $db = array(
			'Name' => 'Varchar',
			'Description' => 'Text',
			'Barcode' => 'Varchar',
			'Quantity' => 'Int',
			'WarningQuantity' => 'Int',
			'MinimumQuantity' => 'Int'
		);

	static $has_one = array('Category' => 'ResourceCategory',
		'Picture' => 'Image');

	static $singular_name = "Artikel";
	static $plural_name = "Artikel";
}