<?php
/**
 * Created by PhpStorm.
 * User: Merlin
 * Date: 08.02.15
 * Time: 17:54
 */

class UpdateToMultisiteController extends Controller {
    static $allowed_actions = array('lager' => 'ADMIN', 'pruefdaten' => 'ADMIN');

    public function lager($request) {
        $pageID = $request->param('PageID');

        $res = Resource::get();

        foreach($res as $article) {
            $article->HolderPageID = $pageID;
            $article->write();
        }

        $book = Booking::get();

        foreach($book as $booking) {
            $booking->HolderPageID = $pageID;
            $booking->write();
        }

        $center = CostCenter::get();

        foreach($center as $cc) {
            $cc->HolderPageID =$pageID;
            $cc->write();
        }
    }

    public function pruefdaten($request) {
        $pageID = $request->param('PageID');

        $devs = Device::get();
        $checktypes = CheckType::get();
        $cats = DeviceCategory::get();
        $supps = Supplier::get();

        foreach($devs as $record) {
            $record->HolderPageID = $pageID;
            $record->write();
        }

        foreach($checktypes as $record) {
            $record->HolderPageID = $pageID;
            $record->write();
        }

        foreach($cats as $record) {
            $record->HolderPageID = $pageID;
            $record->write();
        }

        foreach($supps as $record) {
            $record->HolderPageID = $pageID;
            $record->write();
        }
    }
} 