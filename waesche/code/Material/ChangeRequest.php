<?php
/**
 * Created by PhpStorm.
 * User: Merlin
 * Date: 24.03.2015
 * Time: 21:37
 */

class ChangeRequest extends MaterialDataObject {
    static $db = array('Finished' => 'Boolean', 'Comment' => 'Text');

    static $has_one = array('NewStaffMember' => 'StaffMember');

    static $has_many = array('Clothings' => 'Clothing');
}