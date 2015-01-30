<?php

class ClothingPage extends GenericManagementPage {

}

class ClothingPage_Controller extends GenericManagementPage_Controller {
	static $allowed_actions = array(
		'printlabels',
		'printuserlabels',
		'printstocklabels',
        'doclothingaction',
        'printchangerequest'
	);

	public function index($request) {
		Requirements::javascript('waesche/js/label-checkboxes.js');

		return parent::index($request);
	}

    public function doclothingaction($request) {
        $action = $request->postVar('redirect-action');

        Session::set('oldrequest', $request);

        return $this->redirect($action);
    }

	public function printlabels($request) {
        $oldrequest = Session::get('oldrequest');
        Session::clear('oldrequest');

		$clothes = Clothing::get()->filter(array('Active'=> '1', 'ID' => $oldrequest->postVar('SelectPrint')));

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

    public function printchangerequest($request) {
        $oldrequest = Session::get('oldrequest');
        Session::clear('oldrequest');

        $clothes = Clothing::get()->filter(array('Active' => '1', 'ID' => $oldrequest->postVar('SelectPrint')));
        $staffmember = StaffMember::get()->byID($oldrequest->postVar('StaffMemberID'));

        return $this->renderWith(array('Clothing_printchangerequest', 'Page'), array('Clothings' => $clothes, 'NewStaffMember' => $staffmember));
    }

    public function StaffMembers() {
        return StaffMember::get()->filter('Active', '1')->sort('Name');
    }

	public function SearchForm() {
		$fields = new FieldList(
			DropDownField::create('TypeID', 'Typ')
				->setSource(ClothingType::get()->filter(array('Active', '1'))->map('ID', 'Name')),
			TextField::create('Size', 'Größe'),
			TextField::create('IDCode', 'ID')
		);
	}
}