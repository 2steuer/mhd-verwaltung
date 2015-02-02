<?php
/**
 * Created by PhpStorm.
 * User: Merlin
 * Date: 01.02.15
 * Time: 22:53
 */

class ResourcePage extends GenericManagementPage {
    static $defaults = array('ModelName' => 'Resource');

}

class ResourcePage_Controller extends GenericManagementPage_Controller {
    static $allowed_actions = array(
        'getbarcode',
        'barcodepdf'
    );

    public function init() {
        parent::init();

        Requirements::javascriptTemplate("lager/js/fetch_barcode.js", array('AjaxBarcodeUrl' => $this->Link('getbarcode')));
        Requirements::javascript("lager/js/resource_checkboxes.js");
    }

    public function getbarcode($request) {
        require_once("../thirdparty/mpdf/classes/barcode.php");

        $barcode = "";

        do {
            $barcode = "";
            for($i = 0; $i < 12; $i++) {
                $barcode .= rand(0,9);
            }
        } while(Resource::get()->filter(array('Barcode' => $barcode))->count() > 0);

        $bc = new PDFBarcode();
        $barcode .= $bc->getChecksum($barcode, 'EAN13');

        $arr = array();

        if($barcode[0] == '0') {
            $barcode = substr($barcode, 1, 12);
            $arr['leadingzero'] = 1;
        }
        else {
            $arr['leadingzero'] = 0;
        }

        $arr['barcode'] = $barcode;

        return json_encode($arr);
    }

    public function barcodepdf($request) {
        Requirements::clear();
        require_once("../thirdparty/mpdf/mpdf.php");

        $articles = Resource::get()->filter(array('Active' => '1', 'ID' => $request->postVar('SelectedResources')));

        $dat = new ArrayData(array('Articles' => $articles));

        $html = $dat->renderWith(array('BarcodePDF'));

        $pdf = new mPDF('de', array(62,29),'', '',0,0,0,0,0,0);
        $pdf->ignore_invalid_utf8 = true;
        $pdf->WriteHTML($html);

        $pdf->Output();

        return;
    }
}