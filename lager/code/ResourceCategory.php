<?php

class ResourceCategory extends MaterialDataObject {

	static $db = array(
			'Name' => 'Varchar',
			'Description' => 'Text'
		);

	static $has_many = array('Resources' => 'Resource');

	static $singular_name = "Artikelkategorie";
	static $plural_name = "Artikelkategorien";
}