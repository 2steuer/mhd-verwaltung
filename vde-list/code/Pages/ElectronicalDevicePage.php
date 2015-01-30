<?php

class ElectronicalDevicePage extends GenericManagementPage {

}

class ElectronicalDevicePage_Controller extends GenericManagementPage_Controller {
    static $allowed_actions = array('printlist');

    public function Places() {
        return Place::get()->filter('Active', '1')->sort('Name');
    }
}