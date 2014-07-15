<?php

class ClothingPage extends GenericManagementPage {

}

class ClothingPage_Controller extends GenericManagementPage_Controller {
	static $allowed_actions = array(
		'printlabels',
		'printuserlabels',
		'printstocklabels'
	);

	public function index($request) {
		Requirements::javascript('waesche/js/label-checkboxes.js');

		return parent::index($request);
	}

	public function printlabels($request) {
		$clothes = Clothing::get()->filter(array('Active'=> '1', 'ID' => $request->postVar('SelectPrint')));

		return $this->renderWith(array('Clothing_labels', 'Page'), array('Clothings' => $clothes));		
	}

	public function printuserlabels($request) {
		$uid = $request->param('ID');

		$clothes = StaffMember::get()->byID($uid)->Clothings();

		return $this->renderWith(array('Clothing_labels', 'Page'), array('Clothings' => $clothes));
	}

	public function printstocklabels($request) {
		$clothes = Clothing::get()->filter(array('Active'=> '1', 'OwnerID' => ''));

		return $this->renderWith(array('Clothing_labels', 'Page'), array('Clothings' => $clothes));
	}
}