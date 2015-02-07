<?php


class LagerParentPage extends RedirectorPage {
    static $has_many = array(
        'Resources' => 'Resource',
        'Bookings' => 'Booking',
        'CostCenters' => 'CostCenter'
    );

    static $allowed_children = array('ResourcePage', 'BookingPage', 'ReportPage', 'CostCenterPage');
}

class LagerParentPage_Controller extends RedirectorPage_Controller {

}