<?php
/**
 * Created by PhpStorm.
 * User: Merlin
 * Date: 01.08.14
 * Time: 13:51
 */

class StaffMemberPage extends GenericManagementPage {
    static $defaults = array('ModelName' => 'StaffMember');

    static $db = array('ConfirmationText' => 'HTMLText');

    static $field_labels = array('ConfirmationText' => 'Text der Bestätigung für Helfer');

    public function getCMSFields() {
        $fields = parent::getCMSFields();

        $fields->addFieldToTab('Root.Main', HtmlEditorField::create('ConfirmationText', 'Text der Bestätigung'));

        return $fields;
    }
}

class StaffMemberPage_Controller extends GenericManagementPage_Controller {
    static $allowed_actions = array(
        'printconfirmation'
    );

    public function printconfirmation($request) {
        $id = $request->param('ID');
        $member = StaffMember::get()->byID($id);

        return $this->customise(array('StaffMember' => $member));
    }
}