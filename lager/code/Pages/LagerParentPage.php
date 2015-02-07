<?php


class LagerParentPage extends RedirectorPage {
    static $has_many = array(
        'Resources' => 'Resource',
        'Bookings' => 'Booking'
    );

}

class LagerParentPage_Controller extends RedirectorPage_Controller {

}