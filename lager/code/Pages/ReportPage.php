<?php

class ReportPage extends Page {

}

class ReportPage_Controller extends Page_Controller {
    static $allowed_actions = array('index',
        'TimeSpanSelectionForm'
        );

    public function TimeSpanSelectionForm() {
        $fields = FieldList::create(
            DropDownField::create('Direction', 'Buchungsrichtung')
                ->setSource(array('in' => 'Wareneingang', 'out' => 'Warenausgang'))
                ->setValue('out'),
            DropDownField::create('CostCenter', 'Kostenstelle')
                ->setSource(CostCenter::get()->filter('Active', '1')->map('ID', 'Name')),
            DateField::create('StartDate', 'Bericht von...')
                ->setConfig('showcalendar', true)
                ->setValue("01.01.".date('Y')),
            DateField::create('EndDate', 'Bericht bis...')
                ->setConfig('showcalendar', true)
                ->setValue("31.12.".date('Y'))
        );

        $actions = FieldList::create(FormAction::create('report', 'Bericht anzeigen'));

        $form = new Form($this, 'TimeSpanSelectionForm', $fields, $actions);

        return $form;
    }

    public function report($data, $form) {
        $start = $data['StartDate'];
        $end = $data['EndDate'];
        $costcenter = $data['CostCenter'];
        $direction = $data['Direction'];

        $theCostCenter = CostCenter::get()->byID($costcenter);

        return $this->render(array('Start' => $start,
                'End' => $end,
                'ReportLines' => $this->getReport($start, $end, $direction, $costcenter),
                'CostCenter' => $theCostCenter,
                'ShowReport' => true));
    }

    private function getReport($start, $end, $direction, $costcenter) {
        $start = strtotime($start) - 1;
        $end = strtotime($end) + (23 * 3600 + 59 * 60 + 59) + 1;

        $bookings = Booking::get()->filter(array(
                'Active' => '1',
                'Booked' => '1',
                'Direction' => $direction,
                'CostCenterID' => $costcenter,
                'Date:LessThan' => date('Y-m-d', $end),
                'Date:GreaterThan' => date('Y-m-d', $start)
            ));
        $report = new ArrayList();

        foreach($bookings as $booking) {

            foreach($booking->Entries() as $entry) {
                $res = $entry->Resource();
                $count = $entry->Count;

                if(($element = $report->find('ResourceID', $res->ID)) != null) {
                    $element->Count += $count;
                }
                else {
                    $report->add(ArrayData::create(array('ResourceID' => $res->ID, 'Resource' => $res, 'Count' => $count)));
                }
            }
        }

        return $report;
    }
}