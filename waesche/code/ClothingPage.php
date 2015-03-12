<?php

class ClothingPage extends GenericManagementPage {

}

class ClothingPage_Controller extends GenericManagementPage_Controller {
	static $allowed_actions = array(
        'togglemarked',
        'removemarked',
        'addmarked',
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

    public function togglemarked($request) {
        $id = $request->param('ID');

        $clothing = Clothing::get()->byID($id);

        $clothing->Marked = ($clothing->Marked == '0') ? '1' : '0';
        $clothing->write();

        return $this->redirectBack();
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

        $arr = new ArrayData(['Clothings' => $clothes, 'NewStaffMember' => $staffmember]);

        Requirements::clear();
        require_once("../thirdparty/mpdf/mpdf.php");

        $pdf = new mPDF();
        $pdf->ignore_invalid_utf8 = true;
        $pdf->WriteHTML($arr->renderWith(['Clothing_printchangerequest']));
        $pdf->Output();

        return;
        //return $this->renderWith(array('Clothing_printchangerequest', 'Page'), array('Clothings' => $clothes, 'NewStaffMember' => $staffmember));
    }

    public function removemarked($request) {
        $oldrequest = Session::get('oldrequest');
        Session::clear('oldrequest');

        $clothes = Clothing::get()->filter(array('Active' => '1', 'ID' => $oldrequest->postVar('SelectPrint')));

        foreach($clothes as $clothing) {
            $clothing->Marked = '0';
            $clothing->write();
        }

        return $this->redirect($oldrequest->getHeader('Referer'));
    }

    public function addmarked($request) {
        $oldrequest = Session::get('oldrequest');
        Session::clear('oldrequest');

        $clothes = Clothing::get()->filter(array('Active' => '1', 'ID' => $oldrequest->postVar('SelectPrint')));

        foreach($clothes as $clothing) {
            $clothing->Marked = '1';
            $clothing->write();
        }

        return $this->redirect($oldrequest->getHeader('Referer'));
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

    public function DateString() {
        return date("d.m.Y");
    }
}