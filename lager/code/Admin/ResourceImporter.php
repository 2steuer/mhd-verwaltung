<?php
/**
 * Created by PhpStorm.
 * User: Merlin
 * Date: 15.09.14
 * Time: 14:23
 */

class ResourceImporter extends CsvBulkLoader {
    public $columnMap = array(
        'Barcode' => '->insertBarcode'
    );

    public function insertBarcode(&$obj, $val, $record) {
        $obj->Barcode = str_pad($val, 13, '0', STR_PAD_LEFT);
    }
}