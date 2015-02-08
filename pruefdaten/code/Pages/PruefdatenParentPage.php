<?php
/**
 * Created by PhpStorm.
 * User: Merlin
 * Date: 08.02.15
 * Time: 21:33
 */

class PruefdatenParentPage extends RedirectorPage {
    static $allowed_children = array('CategoryPage', 'CheckTypePage', 'DevicePage', 'SubscriptionPage', 'SupplierPage');

    static $has_many = array('CheckTypes' => 'CheckType',
        'Devices' => 'Device',
        'DeviceCategories' => 'DeviceCategory',
        'Suppliers' => 'Supplier'
    );
}

class PruefdatenParentPage_Controller extends RedirectorPage_Controller {

}