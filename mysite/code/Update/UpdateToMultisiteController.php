<?php
/**
 * Created by PhpStorm.
 * User: Merlin
 * Date: 08.02.15
 * Time: 17:54
 */

class UpdateToMultisiteController extends Controller {
    static $allowed_actions = array('lager' => 'ADMIN');

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
} 