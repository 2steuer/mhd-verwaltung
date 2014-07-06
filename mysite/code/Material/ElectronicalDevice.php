<?php

class ElectronicalDevice extends DataObject {
	static $db = array(
			'Name' => 'Varchar',
			'Description' => 'Text',
			'Barcode' => 'Varchar'
		);

	static $has_one = array(
			'Place' => 'Place'
		);
}