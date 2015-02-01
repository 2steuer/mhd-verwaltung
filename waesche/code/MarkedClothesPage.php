<?php
/**
 * Created by PhpStorm.
 * User: Merlin
 * Date: 01.02.15
 * Time: 19:53
 */

class MarkedClothesPage extends Page {

}

class MarkedClothesPage_Controller extends Page_Controller {

    static $allowed_actions = array('index');

    public function index($request) {
        Requirements::javascript('waesche/js/label-checkboxes.js');

        //return parent::index($request);

        return $this->render();
    }

    public function MarkedClothes() {
        return Clothing::get()->filter(array('Marked' => '1', 'Active' => '1'));
    }

    public function GenericPageLink($modelName, $action='') {
        $page = DataObject::get_one('GenericManagementPage', 'ModelName = \''.$modelName."'");

        if($page) {
            return $page->Link($action);
        }
        else {
            return '';
        }
    }

    public function ClothingPageLink($action='') {
        $page = DataObject::get_one('GenericManagementPage', 'ModelName = \'Clothing\'');

        if($page) {
            return $page->Link($action);
        }
        else {
            return '';
        }
    }

    public function StaffMembers() {
        return StaffMember::get()->filter('Active', '1')->sort('Name');
    }


}